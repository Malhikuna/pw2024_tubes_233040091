<?php
require "../functions/functions.php";
session_start();

$courses = query("SELECT *, courses.id as courses_id FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)
                  ORDER BY courses.id DESC LIMIT 9
");

$catagories = query("SELECT * FROM catagories");

if(isset($_POST["sort"])) {
  if($_POST["sort"] === "old") {
    $courses = query("SELECT *, courses.id as courses_id FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)
                  ORDER BY courses.id ASC LIMIT 9
  ");
  }

  if($_POST["sort"] === "new") {
    $courses = query("SELECT *, courses.id as courses_id FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)
                  ORDER BY courses.id DESC LIMIT 9
  ");
  }
}

if(isset($_POST['search'])) {
  $courses = search($_POST['keyword']);
}

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Roboto&family=Unbounded:wght@500&display=swap" rel="stylesheet" /> -->
</head>
<body>
  <?php require "../layouts/navbar.php"  ?>

  <div class="container">
    <form action="" method="post">
     <div class="sort-content">
        <select id="sort" name="sort" onchange="this.form.submit();">
          <?php if($_POST["sort"] === "old") : ?>
            <option value="new">Newest</option>
            <option value="old" selected>Oldest</option>
          <?php else : ?>
            <option value="new" selected>Newest</option>
            <option value="old">Oldest</option>
          <?php endif ; ?>
        </select>
        <div class="sort-icon">
          <i class="ri-arrow-down-s-fill"></i>
        </div>
      </div>
    </form>
    <section class="card-rows">
      <?php foreach($courses as $course) : ?>
        <div class="card">
          <form action="check.php" method="post">
            <input type="hidden" name="catagory" value="<?= $course["catagory_name"]; ?>">
            <img src="../img/<?= $course["thumbnail"] ?>" alt="">
            <input type="hidden" name="thumbnail" value="<?= $course["thumbnail"]; ?>">
            <p class="catagory"><?= $course["catagory_name"] ?></p>

            <div class="like">
              <i class="ri-heart-3-line"></i>
            </div>

            <div class="bottom">
              <div class="left">
                <h3><?= $course["name"] ?></h3> 
                <input type="hidden" name="course_name" value="<?= $course["name"]; ?>"> 
                <div class="channel-content">
                  <div class="channel"></div>
                  <p><?= $course["channel_name"] ?></p>
                  <input type="hidden" name="channel_name" value="<?= $course["channel_name"]; ?>">
                </div>
              </div>
              <div class="right">
                <input type="hidden" name="id" value="<?= $course["courses_id"]; ?>">
                <button class="check" name="check"></button>
              </div>
            </div>
          </form>
        </div>
      <?php endforeach ; ?>     
    </section>
    
    <h1 class="tag-line webdev">Web Development<i class="ri-arrow-down-wide-line"></i></h1>
    <section class="webdev-rows">
        <a href="search.php?course=<?= $courses[0]["name"]; ?>">
        <div class="webdev-card card-1">
          <i class="ri-html5-line"></i>
          <p>HTML</p>
          <div class="add add-1">
          <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        </a>
        <div class="webdev-card card-2">
          <i class="ri-css3-line"></i>
          <p>CSS</p>
          <div class="add add-2">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="webdev-card card-3">
        <i class="ri-javascript-line"></i>
          <p>JavaScript</p>
          <div class="add add-3">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="webdev-card card-4">
          <i class="ri-reactjs-line"></i>
          <p>React</p>
          <div class="add add-4">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="webdev-card card-5">
          <i class="ri-angularjs-fill"></i>
          <p>Angular.js</p>
          <div class="add add-5">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="webdev-card card-6">
          <i class="ri-bootstrap-line"></i>
          <p>Bootstrap</p>
          <div class="add add-6">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="webdev-card card-7">
          <i class="ri-vuejs-line"></i>
          <p>Vue.js</p>
          <div class="add add-7">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="webdev-card card-8">
          <i class="ri-ubuntu-fill"></i>
          <p>Ubuntu</p>
          <div class="add add-8">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
      </section>
  </div>

  <h1 class="tagline tag-line webdev">Other Catagories</h1>
  <section class="catagories-rows">
    <?php foreach($catagories as $catagory) : ?>
    <a href="catagory.php?catagory=<?= $catagory["catagory_name"]; ?>">
      <div class="catagory-card">
        <p><?= $catagory["catagory_name"]; ?></p>
      </div>
    </a>
    <?php endforeach ; ?>
  </section>


  <button class="print">Print</button>

  <?php if(isset($_SESSION["login"])) : ?>
    <button class="logout"><a href="logout.php">Logout</a></button>
  <?php endif ; ?>

  <?php require("../layouts/footer.php") ?>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
    $(document).ready(function () {
      // $for($i = 1; $i <= 8; $i++) {
      //   $(".add").hide();
      //     function () {
      //       $(".add-" + $i).show();
      //     },
      //     function () {
      //       $(".add-" + $i).hide();
      //     }
      //   );
      // }

      // $(".card-1").hover(
      //     function () {
      //       $(".add-1").show();
      //     },
      //     function () {
      //       $(".add-1").hide();
      //     }
      //   );
    })
  </script>
</body>
</html>
<?php
require "../functions/functions.php";
session_start();

if(isset($_POST["search"])) {
  $courses = search($_POST["keyword"]);
} else {
  header("Location: index.php");
  exit;
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
    <style>
      .container {
        min-height: 100vh;
      }

      footer {
        margin-top: 100px;
      }
    </style>
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
            <img src="../img/thumbnail/<?= $course["thumbnail"] ?>" alt="">
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

  <?php require("../layouts/footer.php") ?>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
    $(document).ready(function () {

    })
  </script>
</body>
</html>
<?php
require "../functions/functions.php";
session_start();

// if(!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }


$courses = query("SELECT *, courses.id as courses_id FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)
                  ORDER BY courses.id DESC
");

if(isset($_POST['search'])) {
  $courses = search($_POST['keyword']);
}

// if(isset($_POST["check"])) {
//   $id = $_POST["id"];

//   $open = true;

//   $crs = query("SELECT * FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)
//   WHERE courses.id = '$id'
//   ")[0];


// }

// if(isset($_POST["close"])) {
//   $open = false;
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
  <?php require "../layouts/navbar.php"  ?>

  <div class="container">
    <!-- <h1 class="tag-line">Recent Courses</h1> -->
    <div class="card-rows">
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
    </div>
  </div>

  <button class="print">Print</button>

  <?php if(isset($_SESSION["login"])) : ?>
    <button class="logout"><a href="logout.php">Logout</a></button>
  <?php endif ; ?>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
</body>
</html>
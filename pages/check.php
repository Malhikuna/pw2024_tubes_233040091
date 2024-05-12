<?php
require "../functions/functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$course_id = $_POST["id"];

$videos = query("SELECT * FROM course_video WHERE courses_id = '$course_id'");

$crs = query("SELECT * FROM courses JOIN catagories ON (courses.catagory_id = catagories.id) WHERE courses.id = '$course_id'")[0];

if(isset($_POST["play"])) {

  $_SESSION["course_id"] = $_POST["course_id"];

  header("Location: video.php");
  exit;
}

header("Cache-Control: no-cache, must-revalidate");

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/check.css">
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="course-content">
      <p class="catagory"><?= $crs["catagory_name"]; ?></p>
      <div class="top">
        <div class="left">
          <img src="../img/<?= $crs["thumbnail"]; ?>" alt="">
        </div>
        <div class="right">
          <h3>Include <?= count($videos) ?> Videos</h3>
          <?php foreach($videos as $video) : ?>
          <p>▶ <?= $video["video_name"]; ?></p>
          <?php endforeach ; ?>
        </div>
      </div>

      <div class="bottom">
        <div class="left">
          <h1><?= $crs["name"]; ?></h1>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur corrupti vitae tenetur quo soluta iste.</p>
          <div class="channel-content">
            <div class="channel"></div>
            <a href="profile.php?channel=<?= $crs["channel_name"]; ?>"><?= $crs["channel_name"]; ?></a>
          </div>
        </div>
        <div class="right">
          <form action="" method="post">
            <!-- <p>Rp100.000</p> -->
            <!-- <button>Add To Cart</button> -->
            <!-- <button>Buy Now</button> -->
            <input type="hidden" name="course_id" value="<?= $course_id; ?>">
            <button class="play" name="play">Play Video</button>
          </form>
        </div>
      </div>
      <div class="back">
        <p><a href="index.php">Back</a></p>
      </div>
    </div>
  </div>

</body>
</html>
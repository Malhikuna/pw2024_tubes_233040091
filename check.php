<?php
require "functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$course_id = $_POST["id"];

$videos = query("SELECT * FROM course_video WHERE courses_id = '$course_id'");

$catagory = $_POST["catagory"];
$thumbnail = $_POST["thumbnail"];
$title = $_POST["title"];
$author = $_POST["author"];

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Page</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/check.css">
</head>
<body>
<nav>
    <div class="navbar-brand">
      <a href="#" class="judul"
        >UP YOUR SKIL</a
      >
    </div>

    <div class="search-content">
      <form action="index.php" method="post">
        <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off" id="keyword">
        <input type="hidden" class="search" name="search" id="tombol-cari"></input>
      </form>
    </div>

    <div class="navbar-list">
      <ul>
        <li><a href="./index.php" class="link">home</a></li>
        <li><a href="./course" class="link">course</a></li>
        <li><a href="./playlist" class="link">playlist</a></li>
        <li><a href="./liked" class="link">liked</a></li>
        <li><a href="./upload.php" class="link">upload</a></li>
      </ul>
    </div>

    <div class="menu">
      <input type="checkbox" />
      <img src="img/icons/menu_icon.png" class="menu-icon" height="15px" width="15px" />
    </div>
  </nav>

  <div class="container">
    <div class="course-content">
      <p class="catagory"><?= $catagory; ?></p>
      <div class="top">
        <div class="left">
          <img src="img/<?= $thumbnail; ?>" alt="">
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
          <h1><?= $title; ?></h1>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur corrupti vitae tenetur quo soluta iste.</p>
          <div class="channel-content">
            <div class="channel"></div>
            <p><?= $author; ?></p>
          </div>
        </div>
        <div class="right">
          <p>Rp100.000</p>
          <button>Add To Cart</button>
          <button>Buy Now</button>
        </div>
      </div>
      <div class="back">
        <p><a href="index.php">Back</a></p>
      </div>
    </div>
  </div>
</body>
</html>
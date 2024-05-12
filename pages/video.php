<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$course_id = $_SESSION["course_id"];

$crs = query("SELECT * FROM courses JOIN catagories ON (courses.catagory_id = catagories.id) WHERE courses.id = '$course_id'")[0];

$videos = query("SELECT * FROM course_video WHERE courses_id = '$course_id'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/video.css">
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
  <div class="top-content">
    <div class="video-box">
      <video width="850" height="425" controls>
        <source src="../videos/663fd58675c29.mp4" type="video.mp4">
      </video>
      <h1><?= $videos[0]["video_name"]; ?></h1>
    </div>
    <div class="video-playlist">
      <form action="" method="post">
        <h4><?= $crs["name"]; ?></h4>
        <?php foreach($videos as $video) : ?>
          <div class="video-box">
            <img src="../img/<?= $crs["thumbnail"]; ?>" width="80" alt="">
              <button name="video-click">
                <p><?= $video["video_name"]; ?></p>
              </button>
            </div>
        <?php endforeach ; ?>
      </form>
    </div>
  </div>
  <div class="bottom-content">
    <div class="channel-box">
      <div class="picture-profile"></div>
      <p><?= $crs["channel_name"]; ?></p>
    </div>
    <div class="like-box">
      <button>❤ Like</button>
    </div>
  </div>
</div>

  
</body>
</html>
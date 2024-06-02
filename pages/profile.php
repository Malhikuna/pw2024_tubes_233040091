<?php 
require "../functions/functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$username = $_GET["profile"];
$profile = query("SELECT *, users.id as userId FROM profile JOIN users ON (user_id = users.id) WHERE username = '$username'")[0];
$profileUserId = $profile["userId"]; 

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN categories ON (courses.category_id = categories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
                  WHERE username = '$username'
                  ORDER BY courses.id DESC 
");

$numVideos = jumlah("videos");
$numCourses = jumlah("courses");
$numLikes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM video_likes JOIN videos ON videos.id = video_likes.video_id JOIN courses ON courses.id = course_id WHERE courses.user_id = $profileUserId"));
$numSold = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders JOIN courses ON courses.id = course_id WHERE courses.user_id = $profileUserId"));
$numPurchasedCourses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $profileUserId"));
$numPlaylist = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM playlist WHERE user_id = $profileUserId"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/profile.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="../css/remixicon.css" rel="stylesheet" />

</head>

<body>
  <div class="container">
    <?php require "../layouts/navbar.php" ?>

    <div class="profile-top">
      <img class="img" src="../img/profile/<?= $profile["image"]; ?>">
      <h3><?= $_GET["profile"] ?></h3>
      <div class="button">
        <button style="background-color: blue; color: white;">Follow</button>
        <button>Massage</button>
      </div>
      <a href="../print.php">
        <div class="print">
          <i class="ri-printer-fill"></i>
        </div>
      </a>
    </div>

    <div class="profile-bottom">
      <div class="follow-content">
        <div class="followers">
          <h2>0</h2>
          <p>Followers</p>
        </div>
        <div class="following">
          <h2>0</h2>
          <p>Following</p>
        </div>
      </div>
      <div class="about">
        <p>Birth : 08-04-2003</p>
        <p><i class="ri-map-pin-fill"></i> Indonesia</p>
      </div>
      <div class="sosmed">
        <a href="http://www.instagram.com/<?= $profile["instagram"]; ?>"><i class="ri-instagram-line"
            style="color: #ffffff;"></i></a>
        <a href=""><i class="ri-linkedin-fill" style="color: #ffffff;"></i></a>
        <a href=""><i class="ri-play-fill" style="color: #ffffff;"></i></a>
        <a href=""><i class="ri-facebook-fill" style="color: #ffffff;"></i></a>
      </div>
    </div>

    <div class="profile-right">
      <div class="stat-content">
        <div class="row">
          <div class="stat stat-1">
            <div class="stat-num">
              <h1><?= $numCourses; ?></h1>
              <h2>Courses</h2>
            </div>
            <div class="icon">
              <i class="ri-slideshow-3-fill"></i>
            </div>
          </div>
          <div class="stat stat-2">
            <div class="stat-num">
              <h1><?= $numVideos; ?></h1>
              <h2>Videos</h2>
            </div>
            <div class="icon">
              <i class="ri-video-fill"></i>
            </div>
          </div>
          <div class="stat stat-3">
            <div class="stat-num">
              <h1><?= $numLikes; ?></h1>
              <h2>Likes</h2>
            </div>
            <div class="icon">
              <i class="ri-heart-3-fill"></i>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="stat stat-4">
            <div class="stat-num">
              <h1><?= $numSold; ?></h1>
              <h2>Sold</h2>
            </div>
            <div class="icon">
              <i class="ri-bank-card-fill"></i>
            </div>
          </div>
          <div class="stat stat-5">
            <div class="stat-num">
              <h1><?= $numPurchasedCourses; ?></h1>
              <h2>Transaction</h2>
            </div>
            <div class="icon">
              <i class="ri-wallet-2-fill"></i>
            </div>
          </div>
          <div class="stat stat-6">
            <div class="stat-num">
              <h1><?= $numPlaylist; ?></h1>
              <h2>Playlist</h2>
            </div>
            <div class="icon">
              <i class="ri-play-list-2-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="description-content">
        <h3>About Me</h3>
        <div class="text-box">
          <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Harum consequuntur maxime dignissimos nostrum
            iure hic tempora magnam rem, quod maiores saepe a quos sit sed aut porro facere alias architecto.</p>
        </div>
      </div>
      <div class="courses">
        <?php require "../layouts/cards.php" ?>
      </div>
    </div>
</body>

</html>
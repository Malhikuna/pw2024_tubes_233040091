<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// user id yang dipakai
$myUserId = $_SESSION["id"];
$id = $_GET["id"];
$courseId = query("SELECT course_id FROM videos WHERE id = $id")[0]["course_id"];
$videoName = query("SELECT video_name FROM videos WHERE id = $id")[0]["video_name"];
$courseName = query("SELECT name FROM courses WHERE id = $courseId")[0]["name"];

// Mengambil data dari tabel plalist
$playlist = query("SELECT * FROM playlist WHERE user_id = $myUserId ORDER BY id DESC LIMIT 5");

if(isset($_POST["video_click"])) {
  $id = $_POST["videoId"];
  $courseId = query("SELECT course_id FROM videos WHERE id = $id")[0]["course_id"];
  $videoName = query("SELECT video_name FROM videos WHERE id = $id")[0]["video_name"];
  $courseName = query("SELECT name FROM courses WHERE id = $courseId")[0]["name"];
}

$userId = query("SELECT user_id FROM courses WHERE id = '$courseId'")[0]["user_id"];
$username = query("SELECT username FROM users WHERE id = '$userId'")[0]["username"];
$profilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];
$myUserId = $_SESSION["id"];
$videos = query("SELECT *, videos.id as videoId 
                  FROM videos
                  JOIN courses ON (course_id = courses.id) 
                  JOIN video_likes ON (video_id = videos.id) 
                  WHERE video_likes.user_id = '$myUserId'");

// Tambah ke playlist
if(isset($_POST["list"])) {
  $id = $_POST["videoId"];
  $courseId = query("SELECT course_id FROM videos WHERE id = $id")[0]["course_id"];
  $videoName = query("SELECT video_name FROM videos WHERE id = $id")[0]["video_name"];
  $courseName = query("SELECT name FROM courses WHERE id = $courseId")[0]["name"];
  $playlistName = $_POST["playlistName"];
  $value = $_POST["list"];
}

// Tambah playlist baru
if(isset($_POST["add-new"])) {
  $id = $_POST["videoId"];
  $courseId = query("SELECT course_id FROM videos WHERE id = $id")[0]["course_id"];
  $videoName = query("SELECT video_name FROM videos WHERE id = $id")[0]["video_name"];
  $courseName = query("SELECT name FROM courses WHERE id = $courseId")[0]["name"];
  $newPlaylist = $_POST["newPlaylist"];
}

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video Liked</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/video.css">
  <link rel="stylesheet" href="../css/alert.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <style>
  .course {
    position: absolute;
    bottom: -38px;
    right: 0;
    width: 100%;
    height: 30px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #4444f9;
  }

  .course p {
    color: white;
  }
  </style>
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <section class="top-content">
      <div class="video-box">
        <video width="850" height="425" controls>
          <source src="../videos/663fd58675c29.mp4" type="video.mp4">
        </video>
        <h1><?= $videoName; ?></h1>
        <p><?= $courseName; ?></p>
      </div>

      <!-- Jumlah Video Dalam List -->
      <div class="video-playlist">
        <h4>Video Liked</h4>
        <?php foreach($videos as $video) : ?>
        <form action="" method="post">
          <div class="video-box">
            <img src="../img/thumbnail/<?= $video["thumbnail"]; ?>" width="80" alt="">
            <input type="hidden" name="videoId" value="<?= $video["videoId"]; ?>">
            <button name="video_click">
              <p><?= $video["video_name"]; ?></p>
            </button>
          </div>
        </form>
        <?php endforeach ; ?>
        <a href="video.php?id=<?= $courseId; ?>">
          <div class="course">
            <p>See Full Course</p>
          </div>
        </a>
      </div>

      <!-- Menambahkan Ke Playlist -->
      <div class="close-click"></div>
      <button name="add" id="add"><i class="ri-play-list-add-fill"></i></button>
      <div class="add">
        <p>Save to..</p>
        <div class="list-name">
          <?php foreach($playlist as $list) : ?>
          <form action="" method="post">
            <div class="list">
              <input type="hidden" name="videoId" value="<?= $id; ?>">
              <input type="hidden" name="playlistId" value="<?= $list["id"]; ?>">
              <input type="hidden" name="playlistName" value="<?= $list["name"]; ?>">
              <?php 
              
              $playlistId = $list["id"]; 
              $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM video_playlist WHERE video_id = $id AND playlist_id = $playlistId")));
              
              ?>
              <?php if($result > 0) : ?>
              <input type="hidden" id="<?= $list["id"]; ?>" name="list" value="unsave">
              <input type="checkbox" id="<?= $list["id"]; ?>" name="list" value="unsave" onchange="this.form.submit();"
                checked>
              <?php else : ?>
              <input type="checkbox" id="<?= $list["id"]; ?>" name="list" value="save" onchange="this.form.submit();">
              <?php endif; ?>
              <label for="<?= $list["id"]; ?>"><?= $list["name"]; ?></label>
            </div>
          </form>
          <?php endforeach ; ?>
        </div>
        <form action="" method="post">
          <div id="new">
            <input type="text" name="newPlaylist" placeholder="add new playlist" autocomplete="off"><br>
            <input type="hidden" name="videoId" value="<?= $id; ?>">
            <input type="hidden" name="userId" value="<?= $myUserId; ?>">
            <button name="add-new">Add</button>
          </div>
        </form>
        <button id="close">
          <i class="ri-close-line"></i>
        </button>
        <button id="add-list">
          Add New
        </button>
    </section>

    <section class="bottom-content">
      <!-- Link Ke Halaman Profile -->
      <div class="channel-box">
        <a href="profile.php?profile=<?= $username; ?>">
          <img class="picture-profile" src="../img/profile/<?= $profilePicture; ?>">
        </a>
        <a href="profile.php?profile=<?= $username; ?>">
          <p><?= $username; ?></p>
        </a>
      </div>

      <!-- Tombol like -->
      <div class="like-box">
        <?php 
      
      $myUserId = $_SESSION["id"]; 
      $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM video_likes WHERE video_id = $id AND user_id = $myUserId")));

      ?>
        <form id="container">
          <input id="videoLikeId" type="hidden" value="<?= $id; ?>">
          <input id="userLikeId" type="hidden" value="<?= $myUserId; ?>">
          <?php if($result === null) : ?>
          <button type="button" id="likeButton"><i class="ri-heart-3-line"></i> Like</button>
          <?php else : ?>
          <button type="button" id="unLikeButton"><i class="ri-heart-3-fill" style="color: #ff0000"></i>
            Unlike</button>
          <?php endif ; ?>
        </form>
      </div>
    </section>


    <?php if(isset($_POST["add-new"])) : ?>
    <?php if (addNewPlaylist($_POST) > 0) : ?>
    <form action="" method="post">
      <div class="alert alert-green">
        <p>Video berhasil ditambahkan ke <?= $newPlaylist; ?></p>
        <input type="hidden" name="videoId" value="<?= $id; ?>">
        <button name="continue" class="continue">continue</button>
      </div>
      <?php else : ?>
      <div class="alert alert-red">
        <p>Video gagal ditambahkan</p>
        <button name="continue" class="continue con-red">continue</button>
      </div>
    </form>
    <?php endif ; ?>
    <?php endif ; ?>

  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/video.js"></script>
  <script src="../javascript/like.js"></script>
</body>

</html>
<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

// user id yang dipakai
$myUserId = $_SESSION["id"];
$courseId = $_GET["id"];
$userId = query("SELECT user_id FROM courses WHERE id = '$courseId'")[0]["user_id"];
$username = query("SELECT username FROM users WHERE id = '$userId'")[0]["username"];
$userProfilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

// Mengambil semua data dari ralasi tabel course, categories, dan users
$crs = query("SELECT * FROM courses 
              JOIN categories ON (courses.category_id = categories.id)
              JOIN users ON (user_id = users.id)
              WHERE courses.id = '$courseId'")[0];
$videos = query("SELECT * FROM videos WHERE course_id = '$courseId'");
$id = query("SELECT id FROM videos WHERE course_id = $courseId ORDER BY id LIMIT 1")[0]["id"];
$videoName = query("SELECT video_name FROM videos WHERE course_id = '$courseId' AND id = $id")[0]["video_name"];

// Mengambil data dari tabel plalist
$playlist = query("SELECT * FROM playlist WHERE user_id = $myUserId ORDER BY id DESC LIMIT 5");

// Ketika video di samping di klik / pindah ke video lain
if(isset($_POST["video_click"]) || isset($_POST["continue"])) {
  $id = $_POST["videoId"];
  $videoName = query("SELECT video_name FROM videos WHERE course_id = '$courseId' AND id = $id")[0]["video_name"];
}

// Tambah playlist baru
if(isset($_POST["add-new"])) {
  $id = $_POST["videoId"];
  $videoName = query("SELECT video_name FROM videos WHERE course_id = '$courseId' AND id = $id")[0]["video_name"];
  $newPlaylist = $_POST["newPlaylist"];
}

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/video.css">
  <link rel="stylesheet" href="../css/alert.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
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
      </div>

      <!-- Jumlah Video Dalam List -->
      <div class="video-playlist">
        <h4><?= $crs["name"]; ?></h4>
        <?php foreach($videos as $video) : ?>
        <form action="" method="post">
          <div class="video-box">
            <img src="../img/thumbnail/<?= $crs["thumbnail"]; ?>" width="80" alt="">
            <input type="hidden" name="videoId" value="<?= $video["id"]; ?>">
            <button name="video_click">
              <p><?= $video["video_name"]; ?></p>
            </button>
          </div>
        </form>
        <?php endforeach ; ?>
      </div>

      <!-- Menambahkan Ke Playlist -->
      <div class="close-click"></div>
      <button name="add" id="add"><i class="ri-play-list-add-fill"></i></button>
      <div class="add">
        <p>Save to..</p>
        <div class="list-name" id="list-container">
          <?php foreach($playlist as $list) : ?>
          <div class="list">
            <input type="hidden" id="videoId" value="<?= $id; ?>">
            <input type="hidden" id="playlistId" value="<?= $list["id"]; ?>">
            <input type="hidden" id="playlistName" value="<?= $list["name"]; ?>">
            <?php 
              
              $playlistId = $list["id"]; 
              $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM video_playlist WHERE video_id = $id AND playlist_id = $playlistId")));
              
              ?>
            <?php if($result > 0) : ?>

            <input type="checkbox" class="check1" id="<?= $list["id"]; ?>" value="unsave" checked>

            <?php else : ?>

            <input type="checkbox" class="check2" id="<?= $list["id"]; ?>" value="save">

            <?php endif; ?>
            <label for="<?= $list["id"]; ?>"><?= $list["name"]; ?></label>
          </div>
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
      </div>

      <!-- Tombol Tambah, Hapus, Dan Edit -->
      <?php if($crs["username"] === $_SESSION["username"]) : ?>
      <?php if(isset($_POST["video_click"])) : ?>
      <form action="delete-video.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <button class="delete">Delete</button>
      </form>
      <a href="edit-video.php?id=<?= $id; ?>"><button class="edit">Edit</button></a>
      <?php else : ?>
      <form action="delete-video.php" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <button class="delete">Delete</button>
      </form>
      <a href="edit-video.php?id=<?= $id; ?>"><button class="edit">Edit</button></a>
      <?php endif ; ?>
      <a href="add-video.php?id=<?= $courseId; ?>"><button name="new-video" class="new-video">New</button></a>
      <?php endif ; ?>
    </section>


    <section class="bottom-content">
      <!-- Link Ke Halaman Profile -->
      <div class="channel-box">
        <a href="profile.php?profile=<?= $username; ?>">
          <img class="picture-profile" src="../img/profile/<?= $userProfilePicture; ?>">
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
  <script src="../javascript/playlist.js"></script>
  <script src="../javascript/like.js"></script>
</body>

</html>
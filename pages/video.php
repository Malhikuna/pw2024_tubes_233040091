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
$profilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

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

// Ketika video di like
if(isset($_POST["liked"])) {
  videoLiked($_POST);
}

// Ketika video di unlike
if(isset($_POST["unliked"])) {
  videoUnliked($_POST);
}

// Tambah ke playlist
if(isset($_POST["list"])) {
  $id = $_POST["videoId"];
  $videoName = query("SELECT video_name FROM videos WHERE course_id = '$courseId' AND id = $id")[0]["video_name"];
  $playlistName = $_POST["playlistName"];
  $value = $_POST["list"];
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
          <img class="picture-profile" src="../img/profile/<?= $profilePicture; ?>">
        </a>
        <a href="profile.php?profile=<?= $username; ?>">
          <p><?= $username; ?></p>
        </a>
      </div>

      <!-- Tombol Like -->
      <div class="like-box">
        <?php 
      
      $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM video_likes WHERE video_id = $id AND user_id = $myUserId")));

      ?>
        <form action="" method="post" id="form-like">
          <input type="hidden" name="userId" value="<?= $myUserId; ?>">
          <input type="hidden" name="videoId" value="<?= $id; ?>">
          <?php if($result === null) : ?>
          <button name="liked" id="liked"><i class="ri-heart-3-line"></i> Like</button>
          <?php else : ?>
          <button name="unliked" id="unliked"><i class="ri-heart-3-fill"></i> Unlike</button>
          <?php endif ; ?>
        </form>
      </div>
    </section>

    <!-- Alert -->
    <?php if(isset($_POST["list"])) : ?>
    <?php if($value === "save") : ?>
    <?php if (saveTo($_POST) > 0) : ?>
    <form action="" method="post">
      <div class="alert alert-green">
        <p>Video berhasil ditambahkan ke <?= $playlistName; ?></p>
        <input type="hidden" name="videoId" value="<?= $id; ?>">
        <button name="continue" class="continue">continue</button>
      </div>
    </form>
    <?php endif  ?>
    <?php else : ?>
    <?php if (unSave($_POST) > 0) : ?>
    <form action="" method="post">
      <div class="alert alert-green">
        <p>Video berhasil dihapus dari list <?= $playlistName; ?></p>
        <input type="hidden" name="videoId" value="<?= $id; ?>">
        <button name="continue" class="continue">continue</button>
      </div>
    </form>
    <?php endif ; ?>
    <?php endif ; ?>
    <?php endif ; ?>

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
</body>

</html>
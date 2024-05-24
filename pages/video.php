<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$userId = $_SESSION["id"];
$profilePicture = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

$courseId = $_GET["id"];

$crs = query("SELECT * FROM courses 
              JOIN catagories ON (courses.catagory_id = catagories.id)
              JOIN users ON (user_id = users.id)
              WHERE courses.id = '$courseId'")[0];

$videos = query("SELECT * FROM videos WHERE course_id = '$courseId'");

$id = query("SELECT id FROM videos WHERE course_id = $courseId ORDER BY id LIMIT 1")[0]["id"];

if(isset($_POST["video_click"])) {
  $id = $_POST["video_id"];

  $videoName = query("SELECT * FROM videos WHERE course_id = '$courseId' AND id = '$id'")[0];
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
</head>
<body>
<?php require "../layouts/navbar.php" ?>

<div class="container">
  <div class="top-content">
    <div class="video-box">
      <video width="850" height="425" controls>
        <source src="../videos/663fd58675c29.mp4" type="video.mp4">
      </video>
      <?php if(isset($_POST["video_click"])) : ?>
        <h1><?= $videoName["video_name"]; ?></h1>
      <?php else : ?>
        <h1><?= $videos[0]["video_name"]; ?></h1>
      <?php endif ; ?>
    </div>
    <div class="video-playlist">
      <h4><?= $crs["name"]; ?></h4>
      <?php foreach($videos as $video) : ?>
        <form action="" method="post">
          <div class="video-box">
            <img src="../img/thumbnail/<?= $crs["thumbnail"]; ?>" width="80" alt="">
            <input type="hidden" name="video_id" value="<?= $video["id"]; ?>">
            <button name="video_click">
              <p><?= $video["video_name"]; ?></p>
            </button>
          </div>
        </form>
      <?php endforeach ; ?>
    </div>
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
  </div>
  <div class="bottom-content">
    <div class="channel-box">
      <a href="profile.php?profile=<?= $_SESSION["username"]; ?>">
        <img class="picture-profile" src="../img/profile/<?= $profilePicture; ?>">
      </a>
      <a href="profile.php?profile=<?= $_SESSION["username"]; ?>">
        <p><?= $crs["username"]; ?></p>
      </a>
    </div>
    <div class="like-box">
      <button>❤ Like</button>
    </div>
  </div>

</div>

  
</body>
</html>
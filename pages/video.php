<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$courseId = $_GET["id"];

$crs = query("SELECT * FROM courses JOIN catagories ON (courses.catagory_id = catagories.id) WHERE courses.id = '$courseId'")[0];

$videos = query("SELECT * FROM course_video WHERE courses_id = '$courseId'");

$id = query("SELECT id FROM course_video WHERE courses_id = $courseId ORDER BY id LIMIT 1")[0]["id"];

if(isset($_POST["video_click"])) {
  $id = $_POST["video_id"];

  $videoName = query("SELECT * FROM course_video WHERE courses_id = '$courseId' AND id = '$id'")[0];
  
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
            <img src="../img/<?= $crs["thumbnail"]; ?>" width="80" alt="">
            <input type="hidden" name="video_id" value="<?= $video["id"]; ?>">
            <button name="video_click">
              <p><?= $video["video_name"]; ?></p>
            </button>
          </div>
        </form>
      <?php endforeach ; ?>
    </div>
    <?php if($crs["channel_name"] === $_SESSION["username"]) : ?>
      <?php if(isset($_POST["video_click"])) : ?>
        <a href="delete-video.php?id=<?= $id; ?>"><button class="delete">Delete</button></a>
        <a href="edit-video.php?id=<?= $id; ?>"><button class="edit">Edit</button></a>
      <?php else : ?>
        <a href="delete-video.php?id=<?= $id; ?>"><button class="delete">Delete</button></a>
        <a href="edit-video.php?id=<?= $id; ?>"><button class="edit">Edit</button></a>
      <?php endif ; ?>
      <a href="add-video.php?id=<?= $courseId; ?>"><button name="new-video" class="new-video">New</button></a>
    <?php endif ; ?>
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
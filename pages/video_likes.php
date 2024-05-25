<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$id = $_GET["id"];

$courseId = query("SELECT course_id FROM videos WHERE id = $id")[0]["course_id"];
$videoName = query("SELECT video_name FROM videos WHERE id = $id")[0]["video_name"];
$courseName = query("SELECT name FROM courses WHERE id = $courseId")[0]["name"];

if(isset($_POST["video_click"])) {
  $id = $_POST["video_id"];
  
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

// Ketika video di like
if(isset($_POST["liked"])) {
  // videoLiked();
  if (videoLiked($_POST) > 0) {
    echo "<script> alert('Berhasil di Liked'); </script>";
  }
}

// Ketika video di unlike
if(isset($_POST["unliked"])) {
  videoUnliked($_POST);
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
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
    />
  <style>
    .course {
      position: absolute;
      bottom: -35px;
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
  <div class="top-content">
    <div class="video-box">
      <video width="850" height="425" controls>
        <source src="../videos/663fd58675c29.mp4" type="video.mp4">
      </video>
      <h1><?= $videoName; ?></h1>
      <p><?= $courseName; ?></p>
    </div>
    <div class="video-playlist">
      <h4>Video Liked</h4>
      <?php foreach($videos as $video) : ?>
        <form action="" method="post">
          <div class="video-box">
            <img src="../img/thumbnail/<?= $video["thumbnail"]; ?>" width="80" alt="">
            <input type="hidden" name="video_id" value="<?= $video["videoId"]; ?>">
            <button name="video_click">
              <p><?= $video["video_name"]; ?></p>
            </button>
          </div>
        </form>
      <?php endforeach ; ?>
      <a href="video.php?id=<?= $courseId; ?>"><div class="course"><p>See Full Course</p></div></a>
    </div>
  </div>
  <div class="bottom-content">
    <div class="channel-box">
      <a href="profile.php?profile=<?= $username; ?>">
        <img class="picture-profile" src="../img/profile/<?= $profilePicture; ?>">
      </a>
      <a href="profile.php?profile=<?= $username; ?>">
        <p><?= $username; ?></p>
      </a>
    </div>
    <div class="like-box">
      <?php 
      
      $myUserId = $_SESSION["id"]; 
      $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM video_likes WHERE video_id = $id AND user_id = $myUserId")));

      ?>
      <form action="" method="post">
        <input type="hidden" name="userId" value="<?= $myUserId; ?>">
        <input type="hidden" name="videoId" value="<?= $id; ?>">
        <?php if($result === null) : ?>
          <button name="liked" id="liked"><i class="ri-heart-3-line"></i> Like</button>
        <?php else : ?>
          <button name="unliked" id="unliked"><i class="ri-heart-3-fill"></i> Unlike</button>
        <?php endif ; ?>
      </form>
    </div>
  </div>

</div>

  
</body>
</html>
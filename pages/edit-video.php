<?php 

session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "../functions/functions.php";

$videoId = $_GET["id"];

$courseVideo = query("SELECT * FROM course_video WHERE id = $videoId")[0];
$videoName = $courseVideo["video_name"];
$description = $courseVideo["description"];
$videoFile = $courseVideo["video"];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/create.css">
  <link rel="stylesheet" href="../css/alert.css">
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="form-content">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-content-2">
          <h2>Create Video</h2>
          <label>
            Video Title
            <input type="text" name="videoName" value="<?= $videoName; ?>">
            <br>
          </label>
          <label>
            Description <br>
            <textarea name="description" style="resize: none;" value="<?= $description; ?>"></textarea>
          </label>
          <br>
          <label>
            Video
            <input type="file" name="video" class="video">
            <input type="hidden" name="oldVideo" value="<?= $videoFile; ?>">
          </label>
          <input type="hidden" name="id" value="<?= $videoId; ?>">
          <button type="submit" name="update" class="upload" >Update</button>
        </div>
      </form>
    </div>

    
    <?php if(isset($_POST["update"])) : ?>
      <?php if (updateVideo($_POST) > 0) : ?>
        <div class="alert alert-green">
          <p>Video berhasil diupdate</p>
          <a href="#" onclick="history.go(-2)"><button name="continue" class="continue">continue</button></a>
        </div>
      <?php else : ?>
        <div class="alert alert-red">
          <p>Video gagal diupdate</p>
          <a href="edit-video.php"><button name="continue" class="continue con-red">continue</button></a>
        </div>    
      <?php endif ; ?>
    <?php endif ; ?> 
  </div>

  <script src="../javascript/jquery.js"></script>
</body>
</html>
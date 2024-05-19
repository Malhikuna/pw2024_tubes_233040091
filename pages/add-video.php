<?php 

session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "../functions/functions.php";

$courseId = $_GET["id"];
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
            <input type="text" name="video_name" required>
            <br>
          </label>
          <label>
            Description <br>
            <textarea name="description" style="resize: none;"></textarea>
          </label>
          <br>
          <label>
            Video
            <input type="file" name="video" class="video" required>
          </label>
          <input type="hidden" name="courseId" value="<?= $courseId; ?>">
          <button type="submit" name="upload" class="upload" >Upload</button>
          <a href="#" onclick="history.go(-1)"><button type="button" class="prev">Prev</button></a>
        </div>
      </form>
    </div>

    
    <?php if(isset($_POST["upload"])) : ?>
      <?php if (addVideo($_POST) > 0) : ?>
        <div class="alert alert-green">
          <p>Video berhasil diupload</p>
          <a href="#" onclick="history.go(-2)"><button name="continue" class="continue">continue</button></a>
        </div>
      <?php else : ?>
        <div class="alert alert-red">
          <p>Video gagal diupload</p>
          <a href="add-video.php"><button name="continue" class="continue con-red">continue</button></a>
        </div>    
      <?php endif ; ?>
    <?php endif ; ?> 
  </div>

  <script src="../javascript/jquery.js"></script>
</body>
</html>
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
  <title>Create New Video</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/create.css">
  <link rel="stylesheet" href="../css/alert.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="form-content">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-content-2">
          <h2>Create New Video</h2>
          <label>
            Video Title
            <input type="text" name="videoName" autocomplete="off" required>
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
          <button type="submit" name="upload" class="upload">Upload</button>
        </div>
      </form>
    </div>


    <?php if(isset($_POST["upload"])) : ?>
    <?php if (addVideo($_POST) > 0) : ?>
    <div class="alert alert-green">
      <p>Video berhasil diupload</p>
      <a href="video.php?id=<?= $courseId; ?>"><button name="continue" class="continue">continue</button></a>
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
<?php 
require "../functions/functions.php";
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$crs = query("SELECT * FROM courses JOIN catagories ON (courses.catagory_id = catagories.id) WHERE courses.id = '$id'")[0];

// cek apakah tombol update sudah ditekan atau belum

header("Cache-Control: no-cache, must-revalidate");



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/create.css">
  <link rel="stylesheet" href="../css/update.css">
  <link rel="stylesheet" href="../css/alert.css">
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="form-content">
      <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="old_thumbnail" value="<?= $crs["thumbnail"]; ?>">
        <div class="form-content-1">
          <h2>Edit Your Course</h2>
          <label>
            Course Name
            <input type="text" name="course_name" value="<?= $crs["name"]; ?>" autocomplete="off">
          </label>
          <label>
            Price
            <input type="number" name="price" value="<?= $crs["price"]; ?>" autocomplete="off" >
          </label>
          <label>
            Catagory
            <select name="catagory" id="catagory">
              <option value="Frontend Developer" selected>Frontend Developer</option>
              <option value="Backend Developer">Backend Developer</option>
            </select>
            <br>
          </label>
          <label>
            Thumbnail Image
            <input type="file" name="thumbnail" class="thumbnail" value="<?= $crs["thumbnail"]; ?>">
          </label>
          <div class="img">
            <img src="../img/<?= $crs["thumbnail"]; ?>" alt=""><br>
          </div>
          <label>
            <input type="hidden" name="channel_name" value="<?= $_SESSION["username"]; ?>">
          </label>
          <button name="update" class="update">Update</button>
        </div>
      </form>
    </div>

    <?php if(isset($_POST["update"])) : ?>
      <?php if (update($_POST) > 0) : ?>
        <div class="alert alert-green">
          <p>data berhasil diubah</p>
          <a href="course.php"><button name="continue" class="continue">continue</button></a>        
        </div>
      <?php else : ?>
        <div class="alert alert-red">
          <p>data gagal diubah</p>
          <button name="continue" class="continue con-red">continue</button>
        </div>    
      <?php endif ; ?>
    <?php endif ; ?> 
    
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
</body>
</html>
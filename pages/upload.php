<?php 
require "../functions/functions.php";
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$categories = query("SELECT * FROM categories");

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
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="form-content">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-content-1">
          <h2>Create Your Course</h2>
          <label>
            Course Name
            <input type="text" name="courseName" required autocomplete="off">
          </label>
          <label>
            Price
            <input type="number" name="price" required>
          </label>
          <label>
            Category
            <select name="category" id="category" required>
              <?php foreach($categories as $category) : ?>
              <option value="<?= $category["id"]; ?>"><?= $category["category_name"]; ?></option>
              <?php endforeach ; ?>
            </select>
            <br>
          </label>
          <label>
            Thumbnail Image
            <input type="file" name="thumbnail" class="thumbnail" required>
          </label>
          <label>
            <input type="hidden" name="userId" value="<?= $_SESSION["id"]; ?>">
          </label>
          <button class="next">Next</button>
        </div>
        <div class="form-content-2">
          <h2>Create First Video</h2>
          <label>
            Video Title
            <input type="text" name="videoName" value="Pendahuluan" required autocomplete="off">
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
          <button type="submit" name="upload" class="upload">Upload</button>
          <button class="prev">Prev</button>
        </div>
      </form>
    </div>


    <?php if(isset($_POST["upload"])) : ?>
    <?php if (uploadCourse($_POST) > 0) : ?>
    <div class="alert alert-green">
      <p>data berhasil diupload</p>
      <a href="course.php"><button name="continue" class="continue">continue</button></a>
    </div>
    <?php else : ?>
    <div class="alert alert-red">
      <p>data gagal diupload</p>
      <a href="upload.php"><button name="continue" class="continue con-red">continue</button></a>
    </div>
    <?php endif ; ?>
    <?php endif ; ?>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
</body>

</html>
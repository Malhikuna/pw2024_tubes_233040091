<?php 
require "../functions/functions.php";
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$crs = query("SELECT * FROM courses JOIN categories ON (courses.category_id = categories.id) WHERE courses.id = '$id'")[0];

$categoryId = $crs["category_id"];
$oldCategory= query("SELECT category_name FROM categories WHERE id = $categoryId")[0]["category_name"];

$categories = query("SELECT * FROM categories WHERE id != $categoryId");

// cek apakah tombol update sudah ditekan atau belum

header("Cache-Control: no-cache, must-revalidate");



 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Course</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/create.css">
  <link rel="stylesheet" href="../css/update.css">
  <link rel="stylesheet" href="../css/alert.css">

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="form-content">
      <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="oldThumbnail" value="<?= $crs["thumbnail"]; ?>">
        <div class="form-content-1">
          <h2>Edit Your Course</h2>
          <label>
            Course Name
            <input type="text" name="courseName" value="<?= $crs["name"]; ?>" autocomplete="off">
          </label>
          <label>
            Price
            <input type="number" name="price" value="<?= $crs["price"]; ?>" autocomplete="off">
          </label>
          <label>
            Category
            <select name="category" id="category">
              <option value="<?= $categoryId; ?>"><?= $oldCategory; ?></option>
              <?php foreach($categories as $category) : ?>
              <option value="<?= $category["id"]; ?>"><?= $category["category_name"]; ?></option>
              <?php endforeach ; ?>
            </select>
            <br>
          </label>
          <label>
            Thumbnail Image
            <input type="file" name="thumbnail" class="thumbnail" value="<?= $crs["thumbnail"]; ?>">
          </label>
          <div class="img">
            <img src="../img/thumbnail/<?= $crs["thumbnail"]; ?>" alt=""><br>
          </div>
          <button name="update" class="update">Update</button>
        </div>
      </form>
    </div>

    <?php if(isset($_POST["update"])) : ?>
    <?php if (updateCourse($_POST) > 0) : ?>
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
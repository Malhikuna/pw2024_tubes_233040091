<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$role = $_SESSION["role"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($role !== "admin") {
  header("Location: index.php");
}

$id = $_GET["id"];

$categoryName = query("SELECT category_name FROM categories WHERE id = '$id'")[0]["category_name"];

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/alert.css">
  <style>
  body {
    min-height: 100vh !important;
  }

  .alert {
    left: 724.5px !important;
  }

  .right {
    width: 1130px;
  }

  .left .menu-box a:nth-child(5) {
    font-weight: bold;
    color: #6060ff;
  }
  </style>
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <?php require "../layouts/sidebar.php" ?>
    <div class="right categories">
      <form action="" method="post">
        <div class="updateCategory">
          <input type="text" name="categoryName" value="<?= $categoryName; ?>" autocomplete="off" required>
          <input type="hidden" name="id" value="<?= $id; ?>">
          <div class="button">
            <a href="dashboard-categories.php"><button type="button" id="continue">Continue</button></a>
            <button name="update" id="update">Update</button>
          </div>
        </div>
      </form>

      <?php if(isset($_POST["update"])) : ?>
      <?php 
        $categoryName = $_POST["categoryName"];
        
        $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories WHERE category_name = '$categoryName'"));
        ?>
      <?php if($count > 0) : ?>
      <div class="alert alert-green">
        <p>Silahkan perbarui Kategori</p>
        <a href="update-category.php?id=<?= $id; ?>"><button class="continue con-red">continue</button></a>
      </div>
      <?php else : ?>
      <?php if (updateCategory($_POST) > 0) : ?>
      <div class="alert alert-green">
        <p>Katagori Berhasil diupdate</p>
        <a href="dashboard-categories.php"><button class="continue con-red">continue</button></a>
      </div>
      <?php else : ?>
      <div class="alert alert-red">
        <p>Katagori gagal diupdate</p>
        <a href="dashboard-categories.php"><button class="continue con-red">continue</button></a>
      </div>
      <?php endif ; ?>
      <?php endif ; ?>
      <?php endif ; ?>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
</body>

</html>
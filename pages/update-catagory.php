<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($status !== "admin") {
  header("Location: index.php");
}

$id = $_GET["id"];

$catagoryName = query("SELECT catagory_name FROM catagories WHERE id = '$id'")[0]["catagory_name"];

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
    .alert {
      left: 707px !important;
    }
  </style>
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left">

    </div>
    <div class="right catagories">
      <form action="" method="post">
      <div class="updateCatagory">
        <input type="text" name="catagoryName" value="<?= $catagoryName; ?>" autocomplete="off">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <div class="button">
          <a href="catagories.php"><button type="button" id="continue">Continue</button></a>
          <button name="update" id="update">Update</button>
        </div>
      </div>
      </form>

      <?php if(isset($_POST["update"])) : ?>
        <?php if (updateCatagory($_POST) > 0) : ?>
          <div class="alert alert-green">
            <p>Katagori Berhasil diupdate</p>
            <a href="dashboard-catagories.php"><button class="continue con-red">continue</button></a>
          </div>    
        <?php else : ?>
          <div class="alert alert-red">
            <p>Katagori gagal diupdate</p>
            <a href="dashboard-catagories.php"><button class="continue con-red">continue</button></a>
          </div>    
        <?php endif ; ?>
      <?php endif ; ?>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
</body>
</html>
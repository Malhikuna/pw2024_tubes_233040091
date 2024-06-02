<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$adminId = $_SESSION["id"];
$email = $_SESSION["email"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($status !== "admin") {
  header("Location: index.php");
}

$accounts = query("SELECT * FROM users JOIN profile on users.id = user_id");

$imageProfile = query("SELECT image FROM profile WHERE user_id = $adminId")[0]["image"];

$videos = jumlah("videos");
$categories = jumlah("categories");
$courses = jumlah("courses");

$currentCourse = query("SELECT *, courses.id as courses_id FROM courses JOIN categories ON (courses.category_id = categories.id)
ORDER BY courses.id DESC LIMIT 3
");

header("Cache-Control: no-cache, must-revalidate");

$userClickId = 0;
if(isset($_POST["alert1"])) {
  $userClickId = $_POST["userId"];
}

if(isset($_POST["alert2"])) {
  $idToClickId = $_POST["userId"];
}

if(isset($_POST["add"])) {
  myqsli_query($conn, "UPDATE users SET status = 'admin'");
}


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
  <link rel="stylesheet" href="../css/accounts.css">
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left">
      <div class="profile-box">
        <img src="../img/profile/<?= $imageProfile; ?>" alt="">
        <h4><?= $username; ?></h2>
          <p><?= $email; ?></p>
          <div class="status">
            <p><?= $status; ?></p>
          </div>
      </div>
      <div class="menu-box">
        <p>Menu</p>
        <a href=""><i class="ri-home-6-fill"></i> Home</a>
        <a href=""><i class="ri-home-6-fill"></i> Manage Courses</a>
        <a href=""><i class="ri-account-box-fill"></i> Manage Accounts</a>
        <a href=""><i class="ri-bank-card-2-fill"></i> Payment History</a>
      </div>
    </div>
    <div class="right accounts">
      <div id="search">
        <form action="" method="post">
          <input class="search" type="text" name="key" size="40" placeholder="search.." autocomplete="off" id="key">
        </form>
      </div>

      <div class="row">
        <?php foreach($accounts as $account) : ?>
        <div class="card">
          <img src="../img/profile/<?= $account["image"] ?>" alt="">
          <h4><?= $account["username"]; ?></h4>
          <form action="" method="post">
            <input type="hidden" name="userId" value="<?= $account["id"]; ?>">
            <div class="button">
              <?php 
              $userName = $account["username"];
              $resultAdmin = query("SELECT * FROM users WHERE username = '$userName'")[0]["status"];
              
              if($resultAdmin === "admin") {
              ?>
              <button name="alert1" style="background-color: #323232;">set to admin</button>
              <?php 
              } else {
              ?>
              <button name="alert3" style="background-color: #6060ff;">set to admin</button>
              <?php 
              }
              ?>
              <button name="alert2"><i class="ri-delete-bin-6-fill"></i></button>
            </div>
          </form>
          <div class="bottom">
            <div class="det">
              <div class="icon">
                <i class="ri-mail-fill"></i>
              </div>
              <p><?= $account["email"]; ?></p>
            </div>
            <div class="det">
              <div class="icon">
                <i class="ri-phone-fill"></i>
              </div>
              <p>089663850026</p>
            </div>
            <div class="det">
              <div class="icon">
                <i class="ri-map-pin-fill"></i>
              </div>
              <p>Indonesia</p>
            </div>
          </div>
        </div>
        <?php endforeach ; ?>
      </div>
    </div>

    <?php if(isset($_POST["alert1"])) : ?>
    <div class="alert">
      <p>The user will be deleted</p>
      <p>Are you sure?</p>
      <div class="yon">
        <a href="javascript:history.back()"><button type="button" class="no">No</button></a>
        <form action="" method="post">
          <input type="hidden" name="id" value="<?= $userDeleteId; ?>">
          <button name="delete" class="yes">Yes</button>
        </form>
      </div>
    </div>
    <?php endif ; ?>

    <?php if(isset($_POST["alert2"])) : ?>
    <div class="alert">
      <p>The user will be admin</p>
      <p>Are you sure?</p>
      <div class="yon">
        <a href="javascript:history.back()"><button type="button" class="no">No</button></a>
        <form action="" method="post">
          <input type="hidden" name="id" value="<?= $userDeleteId; ?>">
          <button name="add" class="yes">Yes</button>
        </form>
      </div>
    </div>
    <?php endif ; ?>

    <?php if(isset($_POST["delete"])) : ?>
    <?php $id = $_POST["id"] ?>
    <?php if( deleteAccount($id) > 0) : ?>
    <div class="alert alert-green">
      <p>Video berhasil terhapus</p>
      <a href="#" onclick="history.go(-2)"><button name="continue" class="continue">continue</button></a>
    </div>
    <?php else : ?>
    <div class="alert alert-red">
      <p>Video gagal terhapus</p>
      <a href="#" onclick="history.go(-2)"><button name="continue" class="continue con-red">continue</button></a>
    </div>
    <?php endif ; ?>
    <?php endif ; ?>

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/script.js"></script>
    <script>
    $(document).ready(function() {
      // $(".alert").hide;

      // $("#alert").click(function(e) {
      //   $(".alert").show();
      // });

      // $(".no").click(function(e) {
      //   $(".alert").hide();
      // });
    })
    </script>
</body>

</html>
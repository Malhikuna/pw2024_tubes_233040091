<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$email = $_SESSION["email"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

$videos = jumlah("videos");
$categories = jumlah("categories");
$courses = jumlah("courses");

$currentCourse = query("SELECT *, courses.id as courses_id FROM courses JOIN categories ON (courses.category_id = categories.id)
ORDER BY courses.id DESC LIMIT 3
");

header("Cache-Control: no-cache, must-revalidate");

if(isset($_POST["delete"])) {
  $_SESSION["video_id"] = $_POST["id"];
  header("Location: delete.php");
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
  <link rel="stylesheet" href="../css/setting.css">
  <link rel="stylesheet" href="../css/alert.css">

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
  <style>
  .left .menu-box a:nth-child(1) {
    font-weight: bold;
    color: #6060ff;
  }
  </style>
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left">
      <div class="menu-box">
        <p>Menu</p>
        <a href="../pages/dashboard.php"><i class="ri-home-6-fill"></i> Account</a>
        <a href="../pages/dashboard-courses.php"><i class="ri-slideshow-3-fill"></i> Theme</a>
        <a href="../pages/logout.php"><i class="ri-login-box-fill"></i> Logout</a>
      </div>
    </div>
    <div class="right default">
      <form action="" method="post">
        <div class="row">
          <label>
            Email
            <input type="email" name="email" value="<?= $email; ?>">
          </label>
          <button name="changeEmail">Change</button>
          <label>
            Password
            <input type="password" name="password">
          </label>
          <button name="changePassword">Change</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/check.js"></script>
  <script src="../javascript/script.js"></script>
</body>

</html>
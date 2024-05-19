<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

var_dump($status);

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($status !== "admin") {
  header("Location: index.php");
}

$course_videos = query("SELECT *, course_video.id as video_id FROM courses JOIN course_video ON (courses_id = courses.id)
                  ORDER BY courses.id DESC LIMIT 5
");

$catagory = query("SELECT * FROM catagories");

$videos = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM course_video"));
$catagories = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM catagories"));

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
  <link rel="stylesheet" href="../css/alert.css">
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left">

    </div>
    <div class="right deffault">
      <h1>Welcome Hikmal</h1>
      <div class="row row-1">
        <div class="col col-1">
          <div class="circle">
            <i class="ri-video-fill"></i>
          </div>
          <p><?= $videos; ?></p>
          <p>Videos</p>
          <div class="add add-1">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
        <div class="col col-2">
          <div class="circle">
            <i class="ri-stack-fill"></i>
          </div>
          <p><?= $catagories; ?></p>
          <p>Catagories</p>
          <div class="add add-2">
            <i class="ri-add-circle-line"></i>
          </div>
        </div>
        <div class="col col-3"></div>
      </div>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/check.js"></script>
  <script src="../javascript/script.js"></script>
</body>
</html>
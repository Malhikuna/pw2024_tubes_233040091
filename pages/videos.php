<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
};

$courseVideos = query("SELECT *, course_video.id as video_id FROM courses JOIN course_video ON (courses_id = courses.id)
                  ORDER BY courses.id DESC LIMIT 5
");

$catagory = query("SELECT * FROM catagories");

$videos = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM course_video"));
$catagories = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM catagories"));

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
      min-height: 160vh;
    }
  </style>
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left"></div>
    <div class="right videos">
      <i class="ri-arrow-left-circle-fill back"></i>
      <section class="table">
        <div class="top">
        </div>
        <div class="bottom">
          <table>
            <thead>
              <tr>
                <th>Channnel</th>
                <th>Videos</th>
                <th>Title</th>
                <th>Realease</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($courseVideos as $video) : ?>
                <tr>
                  <td><?= $video["channel_name"]; ?></td>
                  <td><img src="../img/<?= $video["thumbnail"]; ?>"></td>
                  <td><?= $video["video_name"]; ?></td>
                  <td>08-02-2024</td>
                  <td><a href="delete-video.php?id=<?= $video["video_id"]; ?>"><button name="delete" class="delete">Delete</button></a></td>
                </tr>
              <?php endforeach ; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/check.js"></script>
  <script src="../javascript/script.js"></script>
</body>
</html>
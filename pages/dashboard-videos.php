<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

$courseVideos = query("SELECT *, videos.id as videoId FROM courses JOIN videos ON (course_id = courses.id)
                  ORDER BY videos.id DESC LIMIT 5
");

$videos = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM videos"));

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Videos Dashboard</title>
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

      <div id="search">
        <form action="" method="post">
          <input class="search" type="text" name="key" size="40" placeholder="search.." autocomplete="off" id="key">
        </form>
      </div>
      <section class="table">
        <div class="top">
        </div>
        <div class="bottom" id="container">
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
                  <td>
                    <form action="delete-video.php" method="post">
                      <input type="hidden" name="id" value="<?= $video["videoId"]; ?>">
                      <button class="delete">Delete</button>
                    </form>
                  </td>
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
  <script>
    $(document).ready(function () {
      // Event ketika keyword ditulis
      $("#key").on("keyup", function () {
        // $.get()
        $.get("../ajax/dashboard-videos.php?keyword=" + $("#key").val(), function (data) {
          $("#container").html(data);
        });
      });
    });
  </script>
</body>
</html>
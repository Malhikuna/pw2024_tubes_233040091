<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT *, videos.id as videoId FROM courses JOIN videos ON (course_id = courses.id)"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courseVideos = query("SELECT *, videos.id as videoId FROM courses JOIN videos ON (course_id = courses.id) ORDER BY videos.id DESC LIMIT $dataAwal, $jumlahDataPerHalaman");

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
    
      <section class="table" id="container">
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
                  <td><img src="../img/thumbnail/<?= $video["thumbnail"]; ?>"></td>
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

        <div class="pagination">
          <?php if( $halamanAktif > 1 ) : ?>
            <a href="?page=<?= $halamanAktif - 1 ?>">&laquo;</a>
          <?php endif ; ?>
    
          <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
            <?php if( $i == $halamanAktif ) : ?>
            <div class="active">
              <a href="?page=<?= $i ?>"><?= $i; ?></a>
            </div>
            <?php else : ?>
            <a href="?page=<?= $i ?>"><?= $i; ?></a>
            <?php endif ; ?>
          <?php endfor ; ?>
    
          <?php if( $halamanAktif < $jumlahHalaman ) : ?>
            <a href="?page=<?= $halamanAktif + 1 ?>">&raquo;</a>
          <?php endif ; ?>
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
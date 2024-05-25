<?php 
require "../functions/functions.php";
session_start();

$userId = $_SESSION["id"];

// Pagination
$jumlahDataPerHalaman = 9;
$jumlahData = count(query("SELECT * 
                            FROM video_likes
                            WHERE user_id = '$userId'"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$videos = query("SELECT *, users.id as userId, videos.id as videoId
                  FROM videos
                  JOIN courses ON (course_id = courses.id) 
                  JOIN catagories ON (catagory_id = catagories.id)
                  JOIN video_likes ON (video_id = videos.id)
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
                  WHERE video_likes.user_id = '$userId'
                  ORDER BY videos.id DESC 
                  LIMIT $dataAwal, $jumlahDataPerHalaman
");

// Ambil semua data dari tabel kategori
$catagories = query("SELECT * FROM catagories");

// Sorting
if(isset($_POST["sort"])) {
  if($_POST["sort"] === "old") {
    $videos = query("SELECT *, users.id as userId, videos.id as videoId
                      FROM videos
                      JOIN courses ON (course_id = courses.id) 
                      JOIN catagories ON (catagory_id = catagories.id)
                      JOIN video_likes ON (video_id = videos.id)
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE video_likes.user_id = '$userId'
                      ORDER BY courses.id ASC 
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }

  if($_POST["sort"] === "new") {
    $videos = query("SELECT *, users.id as userId, videos.id as videoId
                      FROM videos
                      JOIN courses ON (course_id = courses.id) 
                      JOIN catagories ON (catagory_id = catagories.id)
                      JOIN video_likes ON (video_id = videos.id)
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE video_likes.user_id = '$userId'
                      ORDER BY courses.id DESC 
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }
}

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <style>
    .container {
        min-height: 100vh;
      }

    footer {
      margin-top: 100px;
    }

    .channel-content {
      margin-top: 0;
    }

    .card-rows .card {
      height: 270px;
    }
  </style>
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <h1 class="tag-line">Liked Videos</h1>
    <form action="" method="post">
     <div class="sort-content">
        <select id="sort" name="sort" onchange="this.form.submit();">
          <?php if($_POST["sort"] === "old") : ?>
            <option value="new">Newest</option>
            <option value="old" selected>Oldest</option>
          <?php else : ?>
            <option value="new" selected>Newest</option>
            <option value="old">Oldest</option>
          <?php endif ; ?>
        </select>
        <div class="sort-icon">
          <i class="ri-arrow-down-s-fill"></i>
        </div>
      </div>
    </form>
    <section class="card-rows">
    <?php foreach($videos as $video) : ?>
      <a href="video_likes.php?id=<?= $video["videoId"]; ?>">
        <div class="card">
          <form action="check.php" method="post">
            <img src="../img/thumbnail/<?= $video["thumbnail"] ?>" alt="">
            <p class="catagory"><?= $video["catagory_name"] ?></p>

            <div class="like">
              <i class="ri-heart-3-fill" style="color: red;"></i>
            </div>

            <div class="bottom">
              <div class="left">
                <h3><?= $video["video_name"] ?></h3> 
                <hp><?= $video["name"] ?></hp> 
                <div class="channel-content">
                  <img class="channel" src="../img/profile/<?= $video["image"]; ?>">
                  <p><?= $video["username"] ?></p>
                </div>
              </div>
            </div>
          </form>
        </div>
      </a>
    <?php endforeach ; ?>
    </section>

    <?php require "../layouts/pagination.php" ?>

    <?php require "../layouts/footer.php" ?>
  </div>
</body>
</html>
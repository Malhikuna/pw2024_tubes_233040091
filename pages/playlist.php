<?php 
require "../functions/functions.php";
session_start();

$userId = $_SESSION["id"];

// Pagination
$jumlahDataPerHalaman = 9;
$jumlahData = count(query("SELECT * FROM playlist"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$myUserId = $_SESSION["id"];

$playlist = query("SELECT * 
                    FROM playlist 
                    WHERE user_id = $myUserId
                    ORDER BY id DESC 
                    LIMIT $dataAwal, $jumlahDataPerHalaman");

// Ambil semua data dari tabel kategori
$categories = query("SELECT * FROM categories");

// Sorting
if(isset($_POST["sort"])) {
  if($_POST["sort"] === "old") {
    $playlist = query("SELECT *
                        FROM playlist
                        WHERE user_id = $myUserId 
                        ORDER BY id DESC 
                        LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }

  if($_POST["sort"] === "new") {
    $playlist = query("SELECT *
                        FROM playlist
                        WHERE user_id = $myUserId 
                        ORDER BY id ASC 
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
  <title>Video Playlist</title>
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
      height: 220px;
    }

    .img {
      width: 100%;
      height: 190px;
      background-color: gray;
      border-radius: 20px 20px 0 0;
    }
  </style>
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <h1 class="tag-line">Video Playlist</h1>
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
    <?php foreach($playlist as $list) : ?>
      <a href="video_playlist.php?id=<?= $list["id"]; ?>">
        <div class="card">
          <form action="check.php" method="post">
            <?php 
            
            $playlistId = $list["id"];
            $result = mysqli_num_rows(mysqli_query($conn, "SELECT *
                                                            FROM video_playlist
                                                            WHERE playlist_id = $playlistId"));
            ?>


            <?php if($result > 0) : ?>
              <?php 

                $videoPlaylist = query("SELECT video_id 
                                        FROM video_playlist 
                                        WHERE playlist_id = $playlistId 
                                        LIMIT 1")[0]["video_id"];               
                $image = query("SELECT thumbnail FROM videos JOIN courses ON (course_id = courses.id) WHERE videos.id = $videoPlaylist")[0]["thumbnail"];

                ?>
              <img src="../img/thumbnail/<?= $image; ?>" alt="">
              <p class="category"><?= $result; ?> Videos</p>
            <?php else : ?>
              <div class="img"></div>
              <p class="category">0 Videos</p>
            <?php endif ; ?>

            <div class="bottom">
              <div class="left">
                <h3 style="margin-left: 5px;"><?= $list["name"] ?></h3> 
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
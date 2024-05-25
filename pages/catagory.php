<?php
require "../functions/functions.php";
session_start();

$catagoryName = $_GET["catagory"];

$catagoryId = query("SELECT id FROM catagories WHERE catagory_name = '$catagoryName'")[0]["id"];

// Pagination
$jumlahDataPerHalaman = 9;
$jumlahData = count(query("SELECT * 
                            FROM courses
                            WHERE catagory_id = $catagoryId"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN catagories ON (courses.catagory_id = catagories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
                  WHERE catagory_id = $catagoryId
                  ORDER BY courses.id DESC 
                  LIMIT $dataAwal, $jumlahDataPerHalaman
");

if(isset($_POST["sort"])) {
  if($_POST["sort"] === "old") {
    $courses = query("SELECT *, courses.id as courseId, users.id as userId 
                      FROM courses 
                      JOIN catagories ON (courses.catagory_id = catagories.id) 
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE catagory_id = $catagoryId
                      ORDER BY courses.id ASC;
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }

  if($_POST["sort"] === "new") {
    $courses = query("SELECT *, courses.id as courseId, users.id as userId 
                      FROM courses 
                      JOIN catagories ON (courses.catagory_id = catagories.id) 
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE catagory_id = $catagoryId
                      ORDER BY courses.id DESC;
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }
}

if(isset($_POST['search'])) {
  $courses = search($_POST['keyword']);
}

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Roboto&family=Unbounded:wght@500&display=swap" rel="stylesheet" /> -->
    <style>
      .container {
        min-height: 100vh;
      }

      footer {
        margin-top: 100px;
      }
    </style>
</head>
<body>
  <?php require "../layouts/navbar.php"  ?>

  <div class="container">
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
      <?php require "../layouts/cards.php" ?>     
    </section>
    
    <!-- Pagination -->
    <?php require "../layouts/pagination.php" ?>

    <?php require("../layouts/footer.php") ?>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
    $(document).ready(function () {

    })
  </script>
</body>
</html>
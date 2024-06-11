<?php 
require "../functions/functions.php";
session_start();

$userId = $_SESSION["id"];

// Pagination
$jumlahDataPerHalaman = 6;
$jumlahData = count(query("SELECT * 
                            FROM courses
                            WHERE user_id = '$userId'"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN categories ON (courses.category_id = categories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
                  WHERE courses.user_id = '$userId'
                  ORDER BY courses.id DESC 
                  LIMIT $dataAwal, $jumlahDataPerHalaman
");

// Ambil semua data dari tabel kategori
$categories = query("SELECT * FROM categories");

// Sorting
if(isset($_POST["sort"])) {
  if($_POST["sort"] === "old") {
    $courses = query("SELECT *, courses.id as courseId, users.id as userId 
                      FROM courses 
                      JOIN categories ON (courses.category_id = categories.id) 
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE courses.user_id = '$userId'
                      ORDER BY courses.id ASC 
                      LIMIT $dataAwal, $jumlahDataPerHalaman
  ");
  }

  if($_POST["sort"] === "new") {
    $courses = query("SELECT *, courses.id as courseId, users.id as userId 
                      FROM courses 
                      JOIN categories ON (courses.category_id = categories.id) 
                      JOIN users ON (courses.user_id = users.id)
                      JOIN profile ON (users.id = profile.user_id)
                      WHERE courses.user_id = '$userId'
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

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
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
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <h1 class="tag-line">My Course</h1>
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

    <?php require "../layouts/pagination.php" ?>

    <?php require "../layouts/footer.php" ?>
  </div>
</body>

</html>
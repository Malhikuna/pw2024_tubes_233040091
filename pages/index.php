<?php
require "../functions/functions.php";
session_start();

// Pagination
$jumlahDataPerHalaman = 9;
$jumlahData = count(query("SELECT * FROM courses"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN categories ON (courses.category_id = categories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
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
  <title>Halaman Utama</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="../css/remixicon.css" rel="stylesheet" />

  <!-- Fonts -->
  <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Roboto&family=Unbounded:wght@500&display=swap" rel="stylesheet" /> -->
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

    <h1 class="tag-line webdev">Web Development</h1>
    <section class="webdev-rows">
      <a href="search.php?course=<?= $courses[0]["name"]; ?>">
        <div class="webdev-card card-1">
          <i class="ri-html5-line"></i>
          <p>HTML</p>
          <div class="add add-1">
            <i class="ri-arrow-right-circle-line"></i>
          </div>
        </div>
      </a>
      <div class="webdev-card card-2">
        <i class="ri-css3-line"></i>
        <p>CSS</p>
        <div class="add add-2">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
      <div class="webdev-card card-3">
        <i class="ri-javascript-line"></i>
        <p>JavaScript</p>
        <div class="add add-3">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
      <div class="webdev-card card-4">
        <i class="ri-reactjs-line"></i>
        <p>React</p>
        <div class="add add-4">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
      <div class="webdev-card card-5">
        <i class="ri-angularjs-fill"></i>
        <p>Angular.js</p>
        <div class="add add-5">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
      <div class="webdev-card card-6">
        <i class="ri-bootstrap-line"></i>
        <p>Bootstrap</p>
        <div class="add add-6">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
      <div class="webdev-card card-7">
        <i class="ri-vuejs-line"></i>
        <p>Vue.js</p>
        <div class="add add-7">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
      <div class="webdev-card card-8">
        <i class="ri-ubuntu-fill"></i>
        <p>Ubuntu</p>
        <div class="add add-8">
          <i class="ri-arrow-right-circle-line"></i>
        </div>
      </div>
    </section>
  </div>

  <h1 class="tagline tag-line webdev">Other Categories</h1>
  <section class="categories-rows">
    <?php foreach($categories as $category) : ?>
    <a href="category.php?category=<?= $category["category_name"]; ?>">
      <div class="category-card">
        <p><?= $category["category_name"]; ?></p>
      </div>
    </a>
    <?php endforeach ; ?>
  </section>

  <?php require("../layouts/footer.php") ?>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
  $(document).ready(function() {
    // $for($i = 1; $i <= 8; $i++) {
    //   $(".add").hide();
    //     function () {
    //       $(".add-" + $i).show();
    //     },
    //     function () {
    //       $(".add-" + $i).hide();
    //     }
    //   );
    // }

    // $(".card-1").hover(
    //     function () {
    //       $(".add-1").show();
    //     },
    //     function () {
    //       $(".add-1").hide();
    //     }
    //   );
  })
  </script>
</body>

</html>
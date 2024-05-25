<?php
require "../functions/functions.php";
session_start();

if(isset($_POST["search"])) {
  $courses = search($_POST["keyword"]);
} else {
  header("Location: index.php");
  exit;
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
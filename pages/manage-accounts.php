<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$role = $_SESSION["role"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($role !== "admin") {
  header("Location: index.php");
}

// Pagination
$jumlahDataPerHalaman = 8;
$jumlahData = count(query("SELECT * FROM users JOIN profile on users.id = user_id WHERE status = 'user'"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$accounts = query("SELECT *, users.id = user_id FROM users JOIN profile on users.id = user_id WHERE status = 'user' ORDER BY users.id LIMIT $dataAwal, $jumlahDataPerHalaman");
// End Pagination

$videos = jumlah("videos");
$categories = jumlah("categories");
$courses = jumlah("courses");

$currentCourse = query("SELECT *, courses.id as courses_id FROM courses JOIN categories ON (courses.category_id = categories.id)
ORDER BY courses.id DESC LIMIT 3
");

header("Cache-Control: no-cache, must-revalidate");

$userClickId = 0;
if(isset($_POST["detail"])) {
  $_SESSION["accountId"] = $_POST["userId"];
  header("Location: user-detail.php");
}

if(isset($_POST["alert2"])) {
  $userClickId = $_POST["userId"];
}

if(isset($_POST["alert3"])) {
  $userClickId = $_POST["userId"];
}

if(isset($_POST["delete"])) {
  $id = $_POST["userId"];
  var_dump($id);
}

if(isset($_POST["add"])) {
  myqsli_query($conn, "UPDATE users SET status = 'admin'");
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
  <link rel="stylesheet" href="../css/accounts.css">
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <?php require "../layouts/sidebar.php" ?>
    <div class="right accounts">
      <div id="search">
        <form action="" method="post">
          <input class="search" type="text" name="key" size="40" placeholder="search.." autocomplete="off" id="key">
        </form>
      </div>

      <div class="row">
        <?php foreach($accounts as $account) : ?>
        <div class="card">
          <img src="../img/profile/<?= $account["image"] ?>" alt="">
          <h4><?= $account["username"]; ?></h4>
          <form action="" method="post">
            <input type="hidden" name="userId" value="<?= $account["user_id"]; ?>">
            <div class="button">
              <button id="detail" name="detail" style="background-color: #6060ff;">detail</button>
              <button id="delete" name="alert2"><i class="ri-delete-bin-6-fill"></i></button>
            </div>
          </form>
          <div class="bottom">
            <div class="det">
              <div class="icon">
                <i class="ri-mail-fill"></i>
              </div>
              <p><?= $account["email"]; ?></p>
            </div>
            <div class="det">
              <div class="icon">
                <i class="ri-phone-fill"></i>
              </div>
              <p>089663850026</p>
            </div>
            <div class="det">
              <div class="icon">
                <i class="ri-map-pin-fill"></i>
              </div>
              <p>Indonesia</p>
            </div>
          </div>
        </div>
        <?php endforeach ; ?>
      </div>

    </div>

    <?php if(isset($_POST["alert2"])) : ?>
    <div class="alert">
      <p>Akun user tersebut akan terhapus</p>
      <p>Apakah anda yakin?</p>
      <div class="yon">
        <button type="button" class="no">No</button>
        <form action="" method="post">
          <input type="hidden" name="userId" value="<?= $userClickId; ?>">
          <button name="delete" class="yes">Yes</button>
        </form>
      </div>
    </div>
    <?php endif ; ?>

    <?php if(isset($_POST["delete"])) : ?>
    <?php $id = $_POST["userId"] ?>
    <?php if( deleteUser($id) > 0) : ?>
    <div class="alert alert-green">
      <p>Akun user berhasil terhapus</p>
      <a href="dashboard-courses.php"><button name="continue" class="continue">continue</button></a>
    </div>
    <?php else : ?>
    <div class="alert alert-red">
      <p>Akun user gagal terhapus</p>
      <a href="dashboard-courses.php"><button name="continue" class="continue con-red">continue</button></a>
    </div>
    <?php endif ; ?>
    <?php endif ; ?>

    <!-- <div class="close-click"></div> -->

    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/script.js"></script>
    <script>
    $(document).ready(function() {
      // $(".alert").hide();
      // $(".close-click").hide()

      $("#delete").click(function(e) {
        // $(".close-click").show()
        $(".alert").show();
      });

      $(".no").click(function(e) {
        $(".alert").hide();
        // $(".close-click").hide()
      });

      // $(".close-click").click(function(e) {
      //   $(".alert").hide();
      //   $(".close-click").hide();
      // });
    })
    </script>
</body>

</html>
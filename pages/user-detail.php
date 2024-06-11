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

$accountId = $_SESSION["accountId"];

$account = query("SELECT *, users.id = user_id FROM users JOIN profile on users.id = user_id WHERE users.id = $accountId")[0];

$videos = jumlah("videos");
$categories = jumlah("categories");
$courses = jumlah("courses");

$currentCourse = query("SELECT *, courses.id as courses_id FROM courses JOIN categories ON (courses.category_id = categories.id)
ORDER BY courses.id DESC LIMIT 3
");

$numVideos = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM videos JOIN courses ON course_id = courses.id WHERE user_id = $accountId"));
$numCourses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM courses WHERE user_id = $accountId"));
$numSold = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders_detail JOIN courses ON courses.id = course_id WHERE courses.user_id = $accountId"));
$numPurchasedCourses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $accountId"));

header("Cache-Control: no-cache, must-revalidate");

$userClickId = 0;

if(isset($_POST["back"])) {
  header("Location: manage-accounts.php");
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
  mysqli_query($conn, "UPDATE users SET status = 'admin'");
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
  <link rel="stylesheet" href="../css/user-detail.css">

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <?php require "../layouts/sidebar.php" ?>
    <div class="right accounts">
      <div class="row">
        <div class="card card1">
          <img src="../img/profile/<?= $account["image"] ?>" alt="">
          <h4><?= $account["username"]; ?></h4>
          <form action="" method="post">
            <input type="hidden" name="userId" value="<?= $account["user_id"]; ?>">
            <div class="button">
              <button id="back" name="back" style="background-color: #6060ff;">Back</button>
              <button id="delete" name="alert2"><i class="ri-delete-bin-6-fill"></i></button>
            </div>
          </form>
        </div>
        <div class="card card2">
          <div class="left-side">
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
            <div class="det">
              <div class="icon">
                <i class="ri-map-pin-fill"></i>
              </div>
              <p>Indonesia</p>
            </div>
            <div class="det">
              <div class="icon">
                <i class="ri-map-pin-fill"></i>
              </div>
              <p>Indonesia</p>
            </div>
          </div>
          <div class="right-side">
            <div class="square">
              <i class="ri-slideshow-3-fill"></i>
              <h4><?= $numCourses; ?></h4>
              <h4>Courses</h4>
            </div>
            <div class="square">
              <i class="ri-video-fill"></i>
              <h4><?= $numVideos; ?></h4>
              <h4>Videos</h4>
            </div>
            <div class="square">
              <i class="ri-bank-card-fill"></i>
              <h4><?= $numSold; ?></h4>
              <h4>Sold</h4>
            </div>
            <div class="square">
              <i class="ri-wallet-2-fill"></i>
              <h4><?= $numPurchasedCourses; ?></h4>
              <h4>Transactions</h4>
            </div>
          </div>
        </div>
      </div>
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
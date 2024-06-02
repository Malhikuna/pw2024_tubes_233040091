<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$adminId = $_SESSION["id"];
$email = $_SESSION["email"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($status !== "admin") {
  header("Location: index.php");
}

$imageProfile = query("SELECT image FROM profile WHERE user_id = $adminId")[0]["image"];

$jumlahDataPerHalaman = 10;
$jumlahData = count(query("SELECT * FROM categories"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$category = query("SELECT * FROM categories ORDER BY id DESC LIMIT 10");

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/alert.css">
  <style>
  .table-category {
    position: relative;
    overflow: hidden;
  }

  .pagination {
    left: 50%;
    transform: translateX(-50%);
  }

  body {
    height: 165vh !important;
  }

  .container {
    height: 165vh !important;
  }

  .right {
    height: 165vh !important;
  }
  </style>
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left">
      <div class="profile-box">
        <img src="../img/profile/<?= $imageProfile; ?>" alt="">
        <h4><?= $username; ?></h2>
          <p><?= $email; ?></p>
      </div>
      <div class="menu-box">
        <p>Menu</p>
        <a href=""><i class="ri-home-6-fill"></i> Home</a>
        <a href=""><i class="ri-home-6-fill"></i> Manage Courses</a>
        <a href=""><i class="ri-account-box-fill"></i> Manage Accounts</a>
        <a href=""><i class="ri-bank-card-2-fill"></i> Payment History</a>
      </div>
    </div>
    <div class="right categories">
      <i class="ri-arrow-left-circle-fill back"></i>

      <div id="search">
        <form action="" method="post">
          <input class="search" type="text" name="key" size="40" placeholder="search.." autocomplete="off" id="key">
        </form>
      </div>
      <button id="add"><i class="ri-add-circle-line"></i></button>
      <section class="table table-category">
        <div class="top">
        </div>
        <div class="bottom" id="container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Category Name</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
              <?php $i = 1; ?>
              <?php foreach($category as $ctg) : ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $ctg["category_name"]; ?></td>
                <td>
                  <a href="update-category.php?id=<?= $ctg["id"]; ?>"><button name="update"
                      class="update">Update</button></a>
                  <a href="delete-category.php?id=<?= $ctg["id"]; ?>"><button name="delete"
                      class="delete">Delete</button></a>
                </td>
              </tr>
              <?php endforeach ; ?>
            </tbody>
          </table>
        </div>

      </section>
      <?php require "../layouts/pagination.php" ?>

      <form action="" method="post">
        <div class="add-ctg">
          <input type="text" name="category" placeholder="name category" autocomplete="off" required>
          <button id="submit" name="add">Add</button>
        </div>
      </form>

      <?php if(isset($_POST["add"])) : ?>
      <?php 
        $categoryName = $_POST["category"];
        
        $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories WHERE category_name = '$categoryName'"));
        ?>
      <?php if($count > 0) : ?>
      <div class="alert alert-green">
        <p>Katagori sudah ada</p>
        <button id="continue" class="continue con-red">continue</button>
      </div>
      <?php else : ?>
      <?php if (addCategory($_POST) > 0) : ?>
      <div class="alert alert-green">
        <p>Category Berhasil ditambahkan</p>
        <a href="dashboard-categories.php"><button name="continue" class="continue con-red">continue</button></a>
      </div>
      <?php else : ?>
      <div class="alert alert-red">
        <p>Category gagal ditambahkan</p>
        <button id="continue" name="continue" class="continue con-red">continue</button>
      </div>
      <?php endif ; ?>
      <?php endif ; ?>
      <?php endif ; ?>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
  $(document).ready(function() {
    $(".updateCategory").hide();

    // $(".alert").hide();

    $("#submit").click(function(e) {
      $(".alert").show();
    });

    $("#continue").click(function(e) {
      $(".alert").hide();
    });


    // Event ketika keyword ditulis
    $("#key").on("keyup", function() {
      // $.get()
      $.get("../ajax/dashboard-categories.php?keyword=" + $("#key").val(), function(data) {
        $("#container").html(data);
      });
    });
  })
  </script>
</body>

</html>
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
$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * 
                            FROM courses
                            JOIN orders_detail ON course_id = courses.id
                            JOIN orders ON orders.id = order_id"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$orders = query("SELECT *,
                  orders.date AS order_date,
                  orders_detail.id AS id
                  FROM courses
                  JOIN orders_detail ON course_id = courses.id
                  JOIN orders ON orders.id = order_id
                  ORDER BY orders_detail.id DESC 
                  LIMIT $dataAwal, $jumlahDataPerHalaman
");

header("Cache-Control: no-cache, must-revalidate");

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

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
  <style>
  body {
    height: 160vh !important;
  }

  .container {
    height: 160vh !important;
  }

  .right {
    height: 160vh !important;
  }

  .left .menu-box a:nth-child(7) {
    font-weight: bold;
    color: #6060ff;
  }

  .table {
    overflow: hidden;
  }
  </style>
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <?php require "../layouts/sidebar.php" ?>
    <div class="right videos">
      <i class="ri-arrow-left-circle-fill back"></i>

      <div id="search">
        <form action="" method="post">
          <input class="search" type="text" name="key" size="40" placeholder="search.." autocomplete="off" id="key">
        </form>
      </div>
      <section class="table">
        <div class="top">
        </div>
        <div class="bottom" id="container">
          <table>
            <thead>
              <tr>
                <th>Order Id</th>
                <th>Course</th>
                <th>Price</th>
                <th>date</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>
              <?php 
              foreach($orders as $order) : 
                $dateTimestamp = $order["order_date"];
                $timestamp = strtotime($dateTimestamp);
                $date = date('d-m-y', $timestamp);
              ?>
              <tr>
                <td><?= $order["order_id"]; ?></td>
                <td>
                  <img src="../img/thumbnail/<?= $order["thumbnail"]; ?>">
                  <p><?= $order["name"]; ?></p>
                </td>
                <td>Rp<?= $order["price"]; ?></td>
                <td><?= $date; ?></td>
                <td>
                  <form action="delete-order.php" method="post">
                    <input type="hidden" name="id" value="<?= $order["id"]; ?>">
                    <button class="confirm">Confirm</button>
                  </form>
                </td>
              </tr>
              <?php endforeach ; ?>
            </tbody>
          </table>
        </div>

        <?php require "../layouts/pagination.php" ?>
      </section>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/check.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
  $(document).ready(function() {
    // Event ketika keyword ditulis
    $("#key").on("keyup", function() {
      // $.get()
      $.get("../ajax/dashboard-courses.php?keyword=" + $("#key").val(), function(data) {
        $("#container").html(data);
      });
    });
  });
  </script>
</body>

</html>
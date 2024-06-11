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
$jumlahData = count(query("SELECT * FROM courses"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, 
                  courses.id as courseId,
                  users.id as userId,
                  courses.date AS course_date
                  FROM courses 
                  JOIN categories ON (courses.category_id = categories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  ORDER BY courses.id DESC 
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

  .left .menu-box a:nth-child(3) {
    font-weight: bold;
    color: #6060ff;
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
                <th>Channnel</th>
                <th>Course</th>
                <th>Name</th>
                <th>date</th>
                <th>Delete</th>
              </tr>
            </thead>

            <tbody>
              <?php 
              foreach($courses as $course) : 
                $dateTimestamp = $course["course_date"];
                $timestamp = strtotime($dateTimestamp);
                $date = date('d-m-y', $timestamp);
              ?>
              <tr>
                <td><a href="profile.php?profile=<?= $course["username"]; ?>"><?= $course["username"]; ?></a></td>
                <td><img src="../img/thumbnail/<?= $course["thumbnail"]; ?>"></td>
                <td><?= $course["name"]; ?></td>
                <td><?= $date; ?></td>
                <td>
                  <form action="delete-course.php" method="post">
                    <input type="hidden" name="id" value="<?= $course["courseId"]; ?>">
                    <button class="delete">Delete</button>
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
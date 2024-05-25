<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($status !== "admin") {
  header("Location: index.php");
}

// Pagination
$jumlahDataPerHalaman = 5;
$jumlahData = count(query("SELECT * FROM courses"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN catagories ON (courses.catagory_id = catagories.id) 
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
  <style>
    body {
      min-height: 160vh;
    }
  </style>
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left"></div>
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
                <th>Realease</th>
                <th>Delete</th>
              </tr>
            </thead>
            
            <tbody>
              <?php foreach($courses as $course) : ?>
                <tr>
                  <td><a href="profile.php?profile=<?= $course["username"]; ?>"><?= $course["username"]; ?></a></td>
                  <td><img src="../img/thumbnail/<?= $course["thumbnail"]; ?>"></td>
                  <td><?= $course["name"]; ?></td>
                  <td>08-02-2024</td>
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
    $(document).ready(function () {
      // Event ketika keyword ditulis
      $("#key").on("keyup", function () {
        // $.get()
        $.get("../ajax/dashboard-courses.php?keyword=" + $("#key").val(), function (data) {
          $("#container").html(data);
        });
      });
    });
  </script>
</body>
</html>
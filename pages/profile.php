<?php 
require "../functions/functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$username = $_GET["profile"];

$profile = query("SELECT *, users.id as userId FROM profile JOIN users ON (user_id = users.id) WHERE username = '$username'")[0];

$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * 
                            FROM courses 
                            JOIN users ON (courses.user_id = users.id)
                            WHERE username = '$username'"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courseId, users.id as userId 
                  FROM courses 
                  JOIN catagories ON (courses.catagory_id = catagories.id) 
                  JOIN users ON (courses.user_id = users.id)
                  JOIN profile ON (users.id = profile.user_id)
                  WHERE username = '$username'
                  ORDER BY courses.id DESC 
                  LIMIT $dataAwal, $jumlahDataPerHalaman
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/profile.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="../css/remixicon.css" rel="stylesheet" />

</head>
<body>
  <div class="container">
    <?php require "../layouts/navbar.php" ?>

    <div class="profile-top">
      <img class="img" src="../img/profile/<?= $profile["image"]; ?>">
      <h3><?= $_GET["profile"] ?></h3>
      <div class="button">
        <button style="background-color: blue; color: white;">Follow</button>
        <button>Massage</button>
      </div>
    </div>

    <div class="profile-bottom">

    </div>

    <div class="profile-right">
      <div class="courses">
        <?php require "../layouts/cards.php" ?>
    </div>
  </div>
</body>
</html>
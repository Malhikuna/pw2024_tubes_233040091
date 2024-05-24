<?php 
require "../functions/functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];

$profile = query("SELECT * FROM profile JOIN users ON (user_id = users.id) WHERE username = '$username'")[0];

$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT *, courses.id as courses_id 
                          FROM courses 
                          JOIN catagories ON (courses.catagory_id = catagories.id)
                          JOIN users ON (user_id = users.id)
                          ORDER BY courses.id DESC"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$courses = query("SELECT *, courses.id as courses_id 
                  FROM courses 
                  JOIN catagories ON (courses.catagory_id = catagories.id)
                  JOIN users ON (user_id = users.id)
                  WHERE username = '$username' 
                  ORDER BY courses.id DESC LIMIT 2
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
        <?php foreach($courses as $course) : ?>
        <div class="card">
          <form action="check.php" method="post">
            <input type="hidden" name="catagory" value="<?= $course["catagory_name"]; ?>">
            <img src="../img/thumbnail/<?= $course["thumbnail"] ?>" alt="">
            <input type="hidden" name="thumbnail" value="<?= $course["thumbnail"]; ?>">
            <p class="catagory"><?= $course["catagory_name"] ?></p>

            <div class="like">
              <i class="ri-heart-3-line"></i>
            </div>

            <div class="bottom">
              <div class="left">
                <h4><?= $course["name"] ?></h4> 
                <input type="hidden" name="course_name" value="<?= $course["name"]; ?>"> 
                <div class="channel-content">
                  <div class="channel"></div>
                  <p><?= $course["username"] ?></p>
                  <input type="hidden" name="channel_name" value="<?= $course["username"]; ?>">
                </div>
              </div>
              <div class="right">
                <input type="hidden" name="id" value="<?= $course["courses_id"]; ?>">
                <button class="check" name="check"></button>
              </div>
            </div>
          </form>
        </div>
        <?php endforeach ; ?>
    </div>
  
</body>
</html>
<?php 
require "../functions/functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
  <div class="container">
    <?php require "../layouts/navbar.php" ?>

    <div class="profile-content">
      <div class="top">
        <div class="left">
          <div class="img"></div>
          <h2><?= $_GET["channel"] ?></h2>
          <div class="button">
            <button style="background-color: blue; color: white;">Follow</button>
            <button>Massage</button>
          </div>
        </div>
      </div>

      <div class="center"></div>
    </div>




    <div class="coba">
      <div class="coba2"></div>
      <div class="coba1"></div>
    </div>
  </div>
  
</body>
</html>
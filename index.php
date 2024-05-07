<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "functions.php";

$courses = query("SELECT * FROM courses");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
<nav>
      <div class="navbar-brand">
        <a href="#" class="judul"
          >UP YOUR SKIL</a
        >
      </div>

      <div class="search-content">
        <form action="" method="post">
          <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off" id="keyword">
          <!-- <button type="submit" name="cari" id="tombol-cari">Cari!</button> -->
          <!-- <img src="img/loader.gif" class="loader"> -->
        </form>
      </div>

      <div class="navbar-list">
        <ul>
          <li><a href="#home" class="link">home</a></li>
          <li><a href="#about" class="link">upload</a></li>
          <li><a href="#skils" class="link">course</a></li>
          <li><a href="#portfolio" class="link">playlist</a></li>
          <li><a href="#contact" class="link">liked</a></li>
        </ul>
      </div>

      <div class="menu">
        <input type="checkbox" />
        <img src="img/icons/menu_icon.png" class="menu-icon" height="15px" width="15px" />
      </div>
    </nav>

    <div class="container">
      <h1 class="tag-line">Popular Courses</h1>
        <div class="card-rows">
            <?php foreach($courses as $course) : ?>
            <div class="card">
                <p><?= $course["type"] ?></p>
                <img src="./img/<?= $course["thumbnail"] ?>" alt="">
                <h3><?= $course["title"] ?></h3>
                <!-- <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias quod dignissimos fugit.</p> -->
                <div class="channel-content">
                  <div class="channel"></div>
                  <p><?= $course["author"] ?></p>
                </div>
                <button class="go">Go</button>
            </div>
            <?php endforeach ; ?>
        </div>
    </div>

    <button class="print">Print</button>

    <button class="logout"><a href="logout.php">Logout</a></button>

    <div></div>
</body>
</html>
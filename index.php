<?php
session_start();

// if(!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

require "functions.php";
// require "login.php";

$courses = query("SELECT * FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)");

if(isset($_POST['search'])) {
  $courses = search($_POST['keyword']);
}

if(isset($_POST["go"])) {
  $appreance = true;
}

// if(isset($_POST["close"])) {
//   $appreance = false;
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
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
        <input type="hidden" class="search" name="search" id="tombol-cari"></input>
        <!-- <img src="img/loader.gif" class="loader"> -->
      </form>
    </div>

    <div class="navbar-list">
      <ul>
        <li><a href="./index.php" class="link">home</a></li>
        <li><a href="./course" class="link">course</a></li>
        <li><a href="./playlist" class="link">playlist</a></li>
        <li><a href="./liked" class="link">liked</a></li>
        <?php if(!isset($_SESSION["login"])) : ?>
          <li><a href="./login.php" class="link">Login</a></li>
        <?php else : ?>
          <li><a href="./upload.php" class="link">upload</a></li>
        <?php endif ; ?>
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
            <form action="check.php" method="post">
              <p><?= $course["catagory_name"] ?></p>
              <input type="hidden" name="catagory" value="<?= $course["catagory_name"]; ?>">
              <img src="./img/<?= $course["thumbnail"] ?>" alt="">
              <input type="hidden" name="thumbnail" value="<?= $course["thumbnail"]; ?>">

              <div class="bottom">
                <div class="left">
                  <h3><?= $course["title"] ?></h3> 
                  <input type="hidden" name="title" value="<?= $course["title"]; ?>"> 
                  <div class="channel-content">
                    <div class="channel"></div>
                    <p><?= $course["author"] ?></p>
                    <input type="hidden" name="author" value="<?= $course["author"]; ?>">
                  </div>
                </div>
                <div class="right">
                  <input type="hidden" name="id" value="<?= $course["id"]; ?>">
                  <button class="check">Check</button>
                </div>
              </div>
              
              <!-- <button class="go" name="go">go</button> -->
            </form>
          </div>
          <!-- <div class="course-content">
            <p>$course["catagory"]</p>
            <div class="top">
              <div class="left">
                <img src="img/$course["thumbnail"]" alt="">
              </div>
              <div class="right"></div>
            </div>

            <div class="bottom">
              <div class="left">
                <h1>$course["title"]</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur corrupti vitae tenetur quo soluta iste.</p>
                <div class="channel-content">
                  <div class="channel"></div>
                  <p>$course["author"]</p>
                </div>
              </div>
              <div class="right">
                <p>Rp100.000</p>
                <button>Add To Cart</button>
                <button>Buy Now</button>
              </div>
            </div>
            <div class="close">
              <p>X</p>
            </div>
          </div> -->
          <?php //if(isset($appreance)) : ?>
            
          <?php //endif ; ?>
          <?php endforeach ; ?>
          
      </div>
  </div>

  <button class="print">Print</button>

  <?php if(isset($_SESSION["login"])) : ?>
    <button class="logout"><a href="logout.php">Logout</a></button>
  <?php endif ; ?>

  <script src="javascript/jquery.js"></script>
  <script src="javascript/script.js"></script>
</body>
</html>
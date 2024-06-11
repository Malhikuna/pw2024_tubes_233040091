<?php
require "../functions/functions.php";
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$userId = $_POST["userId"];
$myUserId = $_SESSION["id"];
$channel = query("SELECT image FROM profile WHERE user_id = $userId")[0]["image"];

$courseId = $_POST["courseId"];

$videos = query("SELECT * FROM videos WHERE course_id = '$courseId'");

$numVideos = strval(count($videos));

// var_dump($numVideos);

$crs = query("SELECT * FROM courses 
              JOIN categories ON (courses.category_id = categories.id)
              JOIN users ON (courses.user_id = users.id)
              WHERE courses.id = '$courseId'")[0];

$result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders_detail JOIN orders ON order_id = orders.id WHERE course_id = $courseId AND user_id = $myUserId"));

header("Cache-Control: no-cache, must-revalidate");

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check Page</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/check.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="../css/remixicon.css" rel="stylesheet" />

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <section class="course-content">
      <p class="category"><?= $crs["category_name"]; ?></p>
      <?php if($crs["username"] === $_SESSION["username"]) : ?>
      <button class="delete" name="delete">Delete</button>
      <?php endif ; ?>
      <section class="top">
        <div class="left">
          <img src="../img/thumbnail/<?= $crs["thumbnail"]; ?>" alt="">
        </div>
        <div class="right">
          <h3>Include <?= $numVideos ?> Videos</h3>
          <?php foreach($videos as $video) : ?>
          <p>▶ <?= $video["video_name"]; ?></p>
          <?php endforeach ; ?>
        </div>
      </section>

      <section class="bottom">
        <div class="left">
          <h1><?= $crs["name"]; ?></h1>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur corrupti vitae tenetur quo soluta iste.
          </p>
          <div class="channel-content">
            <a href="profile.php?profile=<?= $crs["username"]; ?>">
              <img class="channel" src="../img/profile/<?= $channel; ?>">
            </a>
            <a href="profile.php?profile=<?= $crs["username"]; ?>"><?= $crs["username"]; ?></a>
          </div>
        </div>
        <div class="right" id="container">
          <input type="hidden" name="course_id" value="<?= $courseId; ?>">
          <?php if($crs["username"] === $_SESSION["username"]) { ?>

          <a href="edit-course.php?id=<?= $courseId; ?>"><button type="button" id="edit" name="edit">Edit</button></a>
          <a href="video.php?id=<?= $courseId; ?>"><button type="button" id="play" name="play">Play Video</button></a>

          <?php } else if($result > 0) { ?>

          <a href="video.php?id=<?= $courseId; ?>"><button type="button" id="play" name="play">Play Video</button></a>

          <?php $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE user_id = $myUserId")); ?>
          <?php } else { ?>

          <p>Rp<?= $crs["price"]; ?></p>
          <input type="hidden" id="courseId" value="<?= $courseId; ?>">
          <?php 
            
            $cartResult = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cart WHERE course_id = $courseId AND user_id = $myUserId"));

            if($cartResult) {
            ?>
          <button id="add" class="added">Add To Cart</button>
          <?php 
            } else {
            ?>
          <button id="add">Add To Cart</button>
          <?php 
            } 
            ?>
          <button id="buy">Buy Now</button>
          <?php 
          } 
          ?>
        </div>
      </section>

      <div class="alert">
        <p>The course will be deleted</p>
        <p>Are you sure?</p>
        <div class="yon">
          <button class="no">No</button>
          <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?= $courseId; ?>">
            <input type="hidden" name="videos" value="<?= $numVideos; ?>">
            <button class="yes">Yes</button>
          </form>
        </div>
      </div>
      <a href="javascript:history.back()"><button class="back">Back</button></a>
    </section>

    <section>
      <h1>Related Courses</h1>
    </section>

    <?php require "../layouts/footer.php" ?>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/check.js"></script>

</body>

</html>
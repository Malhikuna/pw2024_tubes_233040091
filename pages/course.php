<?php 
require "../functions/functions.php";
session_start();

$userId = $_SESSION["id"];

$courses = query("SELECT *, courses.id as courseId 
                  FROM courses 
                  JOIN catagories ON (courses.catagory_id = catagories.id)
                  JOIN users ON (user_id = users.id)
                  WHERE user_id = '$userId'
                  ORDER BY courseId DESC 
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <h1 class="tag-line">My Course</h1>
    <div class="card-rows">
      <?php foreach($courses as $course) : ?>
        <div class="card">
          <form action="check.php" method="post">
            <p class="catagory"><?= $course["catagory_name"] ?></p>
            <input type="hidden" name="catagory" value="<?= $course["catagory_name"]; ?>">
            <img src="../img/thumbnail/<?= $course["thumbnail"] ?>" alt="">
            <input type="hidden" name="thumbnail" value="<?= $course["thumbnail"]; ?>">

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
                <input type="hidden" name="id" value="<?= $course["courseId"]; ?>">
                <button class="check" name="check"></button>
              </div>
            </div>
          </form>
        </div>
      <?php endforeach ; ?>     
    </div>
  </div>
</body>
</html>
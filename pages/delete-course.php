<?php
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "../functions/functions.php";

$id = $_POST["id"];

var_dump($id);

$videos = query("SELECT * FROM videos WHERE course_id = '$id'");

$numVideos = strval(count($videos));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/alert.css">
    <style>
      .alert-green {
        background-color: hsl(84, 95%, 70%);
      }

      .alert-red {
        background-color: hsl(0, 95%, 64%);
      }
    </style>
</head>
<body>
    <div class="container">
      <div class="alert" >
        <p>The course will be deleted</p>
        <p>Are you sure?</p>
        <div class="yon">
          <a href="javascript:history.back()"><button type="button" class="no">No</button></a>
          <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <button name="yes" class="yes">Yes</button>
          </form>
        </div>
      </div>

      <div class="container">
        <?php if(isset($_POST["yes"])) : ?>
          <?php $id = $_POST["id"] ?>
          <?php if( delete($id, $numVideos) > 0) : ?>
              <div class="alert alert-green">
                <p>Course berhasil terhapus</p>
                <a href="dashboard-courses.php"><button name="continue" class="continue">continue</button></a>
              </div>
          <?php else : ?>
              <div class="alert alert-red">
                <p>Course gagal terhapus</p>
                <a href="dashboard-courses.php"><button name="continue" class="continue con-red">continue</button></a>
              </div>    
          <?php endif ; ?>
        <?php endif ; ?>
    </div>

    </div>

    <script src="../javascript/jquery.js"></script>
    <script>
        $(document).ready(function () {
          $(".no").click(function () {
             $(".alert").hide();
          });
        })
    </script>
</body>
</html>
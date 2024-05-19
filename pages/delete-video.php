<?php
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "../functions/functions.php";

$id = $_GET["id"];

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
        <p>The video will be deleted</p>
        <p>Are you sure?</p>
        <div class="yon">
          <a href="javascript:history.back()"><button type="button" class="no">No</button></a>
          <form action="" method="post">
            <button name="yes" class="yes">Yes</button>
          </form>
        </div>
      </div>

      <div class="container">
        <?php if(isset($_POST["yes"])) : ?>
          <?php if( deleteVideo($id) > 0) : ?>
              <div class="alert alert-green">
                <p>Video berhasil terhapus</p>
                <a href="#" onclick="history.go(-2)"><button name="continue" class="continue">continue</button></a>
              </div>
          <?php else : ?>
              <div class="alert alert-red">
                <p>Video gagal terhapus</p>
                <a href="#" onclick="history.go(-2)"><button name="continue" class="continue con-red">continue</button></a>
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
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
      <div class="alert first" >
        <p>The video will be deleted</p>
        <p>Are you sure?</p>
        <div class="yon">
          <a href="catagories.php"><button type="button" class="no">No</button></a>
          <form action="" method="post">
            <button name="yes" class="yes">Yes</button>
          </form>
        </div>
      </div>

      <?php if(isset($_POST["yes"])) : ?>
        <?php if( deleteCatagory($id) > 0) : ?>
            <div class="alert alert-green">
              <p>Katagori berhasil terhapus</p>
              <a href="catagories.php"><button name="continue" class="continue">continue</button></a>
            </div>
        <?php else : ?>
            <div class="alert alert-red">
              <p>Katagori gagal terhapus</p>
              <a href="catagories.php"><button name="continue" class="continue con-red">continue</button></a>
            </div>    
        <?php endif ; ?>
      <?php endif ; ?>
    </div>

    <script src="../javascript/jquery.js"></script>
    <script>
        $(document).ready(function () {
          $(".no").click(function () {
             $(".first").hide();
          });

          $(".yes").click(function () { 
            $(".first").hide();
          });
        })
    </script>
</body>
</html>
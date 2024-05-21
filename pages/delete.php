<?php
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "../functions/functions.php";

$id = $_POST["id"];
$videos = $_POST["videos"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/alert.css">
</head>
<body>
    <div class="container">
        <?php if( delete($id, $videos) > 0) : ?>
            <div class="alert alert-green">
              <p>Course berhasil terhapus</p>
              <a href="course.php"><button name="continue" class="continue">continue</button></a>
            </div>
        <?php else : ?>
            <div class="alert alert-red">
              <p>Course gagal terhapus</p>
              <a href="course.php"><button name="continue" class="continue con-red">continue</button></a>
            </div>    
        <?php endif ; ?>
    </div>

    <script src="../javascript/jquery.js"></script>
    <script>
    </script>
</body>
</html>
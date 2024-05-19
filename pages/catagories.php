<?php 
session_start();
require "../functions/functions.php";

$username = $_SESSION["username"];
$status = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

var_dump($status);

if(!isset($_SESSION["login"])) {
  header("Location: index.php");
}

if($status !== "admin") {
  header("Location: index.php");
}

$catagory = query("SELECT * FROM catagories");

header("Cache-Control: no-cache, must-revalidate");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/alert.css">
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="left">

    </div>
    <div class="right catagories">
      <i class="ri-arrow-left-circle-fill back"></i>
      <button id="add"><i class="ri-add-circle-line"></i></button>
      <section class="table table-catagory">
        <div class="top">
        </div>
        <div class="bottom">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Catagory Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach($catagory as $ctg) : ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $ctg["catagory_name"]; ?></td>
                  <td>
                    <a href="update-catagory.php?id=<?= $ctg["id"]; ?>"><button name="update" class="update">Update</button></a>
                    <a href="delete-catagory.php?id=<?= $ctg["id"]; ?>"><button name="delete" class="delete">Delete</button></a>
                  </td>
                </tr>
                <?php endforeach ; ?>
              </tbody>
          </table>
        </div>
      </section>

      <form action="" method="post">
        <div class="add-ctg">
          <input type="text" name="catagory" placeholder="name catagory" autocomplete="off" required>
          <button id="submit" name="add">Add</button>
        </div>
      </form>

      <?php if(isset($_POST["add"])) : ?>
        <?php if (addCatagory($_POST) > 0) : ?>
          <div class="alert alert-green">
            <p>Catagory Berhasil ditambahkan</p>
            <a href="catagories.php"><button name="continue" class="continue con-red">continue</button></a>
          </div>    
        <?php else : ?>
          <div class="alert alert-red">
            <p>Catagory gagal ditambahkan</p>
            <a href="catagories.php"><button name="continue" class="continue con-red">continue</button></a>
          </div>    
        <?php endif ; ?>
      <?php endif ; ?> 
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script>
    $(document).ready(function () {
      $(".updateCatagory").hide();


    })
  </script>
</body>
</html>
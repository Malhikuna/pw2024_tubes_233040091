<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$userId = $_SESSION["id"];
$cartResult = mysqli_num_rows(mysqli_query($conn, "SELECT * 
                                                    FROM cart 
                                                    WHERE user_id = $userId"));

// Pagination
$jumlahDataPerHalaman = 3;
$jumlahData = count(query("SELECT *  
                            FROM cart 
                            WHERE user_id = $userId "));
                            
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

$dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$cartLst = query("SELECT *, cart.user_id as userId, cart.id as cartId
                    FROM cart 
                    JOIN courses ON course_id = courses.id 
                    WHERE cart.user_id = $userId 
                    LIMIT $dataAwal, $jumlahDataPerHalaman");

header("Cache-Control: no-cache, must-revalidate");

if(isset($_POST["check"])) {
  $value = $_POST["check"];
  $cartId = $_POST["cartId"];
  
  if ($value === "1") {
    global $conn; 
    $cartId = $_POST["cartId"];
    $query = "INSERT INTO order_summary (cart_id, user_id) VALUES ('$cartId', '$userId')";

    mysqli_query($conn, $query);

    $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE cart_id = $cartId")));
    
  } else {
    global $conn; 
    $cartId = $_POST["cartId"];
    $query = "DELETE FROM order_summary WHERE cart_id = $cartId";
    
    mysqli_query($conn, $query);
    $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE cart_id = $cartId")));
  }
}

if(isset($_POST["confirm"])) {
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$userId'");
  $row = mysqli_fetch_assoc(($result));
}

if(isset($_POST["delete"])) {
  $cartId = $_POST["cartId"];
  deleteCartList($cartId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/cart.css">
  <link rel="stylesheet" href="../css/alert.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="cart-content">
      <div class="left">
        <h2>Shopping Cart</h2>
        <table>
          <thead>
            <tr>
              <th>Course Details</th>
              <th>Price</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($cartLst as $crtList) : ?>
            <form action="" method="post" id="form_check">
              <tr>
                <td>
                  <?php 
                  $courseId = $crtList["course_id"];
                  $listResult = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cart WHERE course_id = $courseId AND user_id = $userId"));

                  if($listResult) {
                  ?>
                  <input type="hidden" name="cartId" value="<?= $crtList["cartId"]; ?>">
                  <?php 
                  
                  $cartId = $crtList["cartId"]; 
                  $result = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE cart_id = $cartId")));
                  
                    if(isset($_POST["check"])) {
                      if($result > 0) {
                  ?>
                  <input type="hidden" id="<?= $crtList["cartId"]; ?>" name="check" value="0">
                  <input class="check" type="checkbox" id="<?= $crtList["cartId"]; ?>" name="check"
                    onchange="this.form.submit();" checked>
                  <?php
                      } else if($result <= 0) {
                  ?>
                  <input class="check" type="checkbox" id="<?= $crtList["cartId"]; ?>" name="check" value="1"
                    onchange="this.form.submit(); ">
                  <?php
                      }
                    } else if($result > 0){
                  ?>
                  <input type="hidden" id="<?= $crtList["cartId"]; ?>" name="check" value="0">
                  <input class="check" type="checkbox" id="<?= $crtList["cartId"]; ?>" name="check"
                    onchange="this.form.submit();" checked>
                  <?php 
                    } else if($result <= 0) {
                  ?>
                  <input class="check" type="checkbox" id="<?= $crtList["cartId"]; ?>" name="check" value="1"
                    onchange="this.form.submit(); ">
                  <?php 
                    } 
                  ?>
                  <img src="../img/thumbnail/<?= $crtList["thumbnail"]; ?>" alt="">
                  <p><?= $crtList["name"]; ?></p>
                </td>
                <td><?= $crtList["price"]; ?></td>
                <form action="" method="post">
                  <td>
                    <input type="hidden" name="userId" value="<?= $userId; ?>">
                    <button type="submit" name="delete">Delete</button>
                    <?php
                  }
                  ?>
                  </td>
                </form>
              </tr>
            </form>
            <?php endforeach ; ?>
        </table>

        <?php require "../layouts/pagination.php" ?>
      </div>
      <div class="right">
        <div class="top-text">
          <h2>Order Summary</h2>
          <?php 
          $result2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE user_id = $userId"));

          $jumlahCourse = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM order_summary WHERE user_id = $userId"));

          if ($result2 > 0) {
            $orderSummary = query("SELECT *
            FROM order_summary
            JOIN cart ON cart.id = cart_id
            JOIN courses ON courses.id = course_id
            WHERE order_summary.user_id = $userId")[0];

            $totalPrice = query("SELECT SUM(price) AS 'Total Price'
            FROM order_summary
            JOIN cart ON cart.id = cart_id
            JOIN courses ON courses.id = course_id
            WHERE order_summary.user_id = $userId ")[0]["Total Price"];
        ?>
          <p><?= $jumlahCourse; ?> courses</p>
        </div>
        <div class="check-content">
          <img src="../img/thumbnail/<?= $orderSummary["thumbnail"]; ?>" alt="">
          <p><?= $orderSummary["name"]; ?></p>
        </div>
        <!-- <div class="check-content-alt">
          for
          <img src="../img/thumbnail/" alt="">
          <p>JavaScript</p>
        </div> -->
        <div class="total-content">
          <p>Total</p>
          <p>Rp<?= $totalPrice; ?></p>
        </div>
        <div class="checkout-content">
          <button id="check_button">Checkout</button>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php 
  
$orderSummary = query("SELECT *
                          FROM order_summary
                          JOIN cart ON cart.id = cart_id
                          JOIN courses ON courses.id = course_id
                          WHERE order_summary.user_id = $userId");

$totalPrice = query("SELECT SUM(price) AS 'Total Price'
                      FROM order_summary
                      JOIN cart ON cart.id = cart_id
                      JOIN courses ON courses.id = course_id
                      WHERE order_summary.user_id = $userId ")[0]["Total Price"];

  ?>

  <form action="" method="post">
    <div id="checkout">
      <h3>Confirm Password</h3>
      <input type="password" name="password" id="" required>
      <div class="courses">
        <?php foreach($orderSummary as $order) : ?>
        <div class="orders">
          <p><?= $order["name"]; ?></p>
          <p>Rp<?= $order["price"]; ?></p>
        </div>
        <?php endforeach ; ?>
      </div>
      <div id="total">
        <p>Total Amount</p>
        <p>Rp<?= $totalPrice; ?></p>
      </div>
      <input type="hidden" name="userId" value="<?= $userId; ?>">
      <button name="confirm">Confirm</button>
      <button class="close"><i class="ri-close-line"></i></button>
    </div>



    <?php if(isset($_POST["sure"])) : ?>
    <?php if (password_verify($password, $row["password"])) : ?>
    <div class="alert">
      <p>Are you sure?</p>
      <div class="yon">
        <a href="javascript:history.back()"><button type="button" class="no">No</button></a>
        <form action="" method="post">
          <input type="hidden" name="userId" value="<?= $userId; ?>">
          <button name="confirm" class="yes">Yes</button>
        </form>
      </div>
    </div>
    <?php endif ; ?>
    <?php endif ; ?>
  </form>

  <?php if(isset($_POST["confirm"])) : ?>
  <?php if (password_verify($password, $row["password"])) : ?>
  <?php if(checkout($_POST) > 0) : ?>
  <div class="alert alert-green">
    <p>Course berhasil terhapus</p>
    <a href="my-learning.php"><button type="button" name="continue" class="continue">continue</button></a>
  </div>
  <?php endif ; ?>
  <?php endif ; ?>
  <?php endif ; ?>

  <?php require "../layouts/footer.php" ?>

  <script src="../javascript/jquery.js"></script>
  <script>
  $(document).ready(function() {
    $("#checkout").hide();

    $("#check_button").click(function(e) {
      $("#checkout").show();
    });

    $(".close").click(function(e) {
      $("#checkout").hide();
    });

    // $("#form_check").submit(function(e) {
    //   e.preventDefault();
    // });
  })
  </script>
</body>

</html>
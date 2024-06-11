<?php 
session_start();
require "../functions/functions.php";

if(!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$userId = $_SESSION["id"];
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$phone = query("SELECT phone FROM users WHERE email = '$email'")[0]["phone"];
$cartResult = mysqli_num_rows(mysqli_query($conn, "SELECT * 
                                                    FROM cart 
                                                    WHERE user_id = $userId"));

// Pagination
$cartLst = query("SELECT *, cart.user_id as userId, cart.id as cartId
                    FROM cart 
                    JOIN courses ON course_id = courses.id 
                    WHERE cart.user_id = $userId");

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
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />

  <!-- JS -->
  <!-- <script src="../javascript/checkout.js" async></script> -->

  <!-- Midtrans -->
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-n2-yieImZZkM66iL"></script>
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
            <form action="" method="post" id="<?= $crtList["cartId"]; ?>">
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

      </div>
      <div class="right">
        <div class="top-text">
          <h2>Order Summary</h2>
          <?php 
          $result2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE user_id = $userId"));

          $jumlahCourse = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM order_summary WHERE user_id = $userId"));

          if ($result2 > 0) {
            $orderSummary = query("SELECT *, courses.id as id
            FROM order_summary
            JOIN cart ON cart.id = cart_id
            JOIN courses ON courses.id = course_id
            WHERE order_summary.user_id = $userId")[0];

            $orderItems = query("SELECT courses.id as id, name, price
            FROM order_summary
            JOIN cart ON cart.id = cart_id
            JOIN courses ON courses.id = course_id
            WHERE order_summary.user_id = $userId")[0]["name"];

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
        <div class="total-content">
          <p>Total</p>
          <p>Rp<?= $totalPrice; ?></p>
        </div>
        <form action="" id="checkoutForm">
          <input type="hidden" name="total" value="<?= $totalPrice; ?>">
          <input type="hidden" name="items" value="<?= $orderItems; ?>">
          <input type="hidden" name="name" value="<?= $username; ?>">
          <input type="hidden" name="email" value="<?= $email; ?>">
          <input type="hidden" name="phone" value="<?= $phone; ?>">
          <input type="hidden" name="id" value="<?= $userId; ?>">
          <div class="checkout-content">
            <button type="button" id="checkButton">Checkout</button>
          </div>
        </form>
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- Checkout -->

  <?php require "../layouts/footer.php" ?>

  <div class="close-click"></div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/checkout.js"></script>
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="Mid-client-3MVh8M26cxNIxMN6"></script>
  <script>
  $(document).ready(function() {
    $("#checkout").hide();

    $("#checkButton").click(function(e) {
      // $("#checkout").show();
      // $(".close-click").show();
    });

    $(".close").click(function(e) {
      $("#checkout").hide();
      $(".close-click").hide();
    });

    $(".close-click").hide();
  });
  </script>
</body>

</html>
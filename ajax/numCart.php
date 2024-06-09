<!-- Number of Cartlist -->
<?php 
session_start();
require "../functions/functions.php";

$myUserId = $_SESSION["id"];
$cartResult = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $myUserId"));

?>

<i class="ri-shopping-cart-2-line"></i>
<?php if($cartResult > 0) : ?>
<?php if($cartResult > 9) : ?>
<div class="number">
  <p>9+</p>
</div>
<?php endif ; ?>
<div class="number">
  <p><?= $cartResult; ?></p>
</div>
<?php endif ; ?>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/check.js"></script>
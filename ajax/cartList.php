<?php 

session_start();
require "../functions/functions.php";
$myUserId = $_SESSION["id"];
$cartList = query("SELECT *, cart.user_id as userId FROM cart JOIN courses ON course_id = courses.id WHERE cart.user_id = $myUserId LIMIT 2");

?>

<div class="cart-list">
  <?php foreach($cartList as $crt) : ?>
  <div class="course-list">
    <img src="../img/thumbnail/<?= $crt["thumbnail"]; ?>" alt="" class="course-img">
    <p><?= $crt["name"]; ?></p>
  </div>
  <?php endforeach ; ?>
</div>
<div id="total-price">
  <?php 
        
        $total_price = query("SELECT SUM(price) AS 'Total Price'
        FROM cart JOIN courses ON courses.id = course_id WHERE cart.user_id = $myUserId ")[0]["Total Price"];

        ?>
  <h3>Total</h3>
  <?php if($total_price === null) : ?>
  <p>Rp0</p>
  <?php else : ?>
  <p>Rp<?= $total_price; ?></p>
  <?php endif ; ?>
</div>
<a href="cart.php"><button>See Cart</button></a>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/check.js"></script>
<?php 

session_start();
require "../functions/functions.php";
$courseId = $_GET["courseId"];
$myUserId = $_SESSION["id"];
$crs = query("SELECT * FROM courses 
              JOIN categories ON (courses.category_id = categories.id)
              JOIN users ON (courses.user_id = users.id)
              WHERE courses.id = '$courseId'")[0];
              
addToCart($myUserId, $courseId);

$result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders_detail JOIN orders ON order_id = orders.id WHERE course_id = $courseId AND user_id = $myUserId"));

?>



<!-- Chekout Button -->
<div class="right" id="container">
  <input type="hidden" name="course_id" value="<?= $courseId; ?>">
  <?php if($crs["username"] === $_SESSION["username"]) { ?>

  <a href="edit-course.php?id=<?= $courseId; ?>"><button type="button" id="edit" name="edit">Edit</button></a>
  <a href="video.php?id=<?= $courseId; ?>"><button type="button" id="play" name="play">Play Video</button></a>

  <?php } else if($result > 0) { ?>

  <a href="video.php?id=<?= $courseId; ?>"><button type="button" id="play" name="play">Play Video</button></a>

  <?php $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM order_summary WHERE user_id = $myUserId")); ?>
  <?php } else { ?>

  <p>Rp<?= $crs["price"]; ?></p>
  <input type="hidden" id="courseId" value="<?= $courseId; ?>">
  <?php 
            
            $cartResult = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM cart WHERE course_id = $courseId AND user_id = $myUserId"));

            if($cartResult) {
            ?>
  <button id="add" class="added">Add To Cart</button>
  <?php 
            } else {
            ?>
  <button id="add">Add To Cart</button>
  <?php 
            } 
            ?>
  <button id="buy">Buy Now</button>
  <?php 
          } 
          ?>
</div>
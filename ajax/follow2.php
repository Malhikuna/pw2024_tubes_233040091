<?php 

session_start();
require "../functions/functions.php";

$profileUserId = $_GET["id"];

$numFollowers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM followers WHERE profile_id = $profileUserId"));
$numFollowing = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM followers WHERE user_id = $profileUserId"));
?>

<div class="followers">
  <h2><?= $numFollowers; ?></h2>
  <p>Followers</p>
</div>
<div class="following">
  <h2><?= $numFollowing; ?></h2>
  <p>Following</p>
</div>
<?php 

session_start();
require "../functions/functions.php";

$userId = $_GET["id"];
$myUserId = $_SESSION["id"];

$result = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM followers WHERE user_id = $myUserId AND profile_id = $userId"));


if($result > 0) {
  unFollow($userId, $myUserId);
} else {
  follow($userId, $myUserId);
}

$result2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM followers WHERE user_id = $myUserId AND profile_id = $userId"));
?>
<input type="hidden" id="userId" value="<?= $userId; ?>">
<?php 
  if($result === 0) {
  ?>
<button style="background-color: blue; color: white;" id="unFollow">Unfollow</button>
<?php 
  } else {
    ?>
<button style="background-color: blue; color: white;" id="follow">Follow</button>
<?php 
  }
  ?>
<button>Massage</button>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/profile.js"></script>
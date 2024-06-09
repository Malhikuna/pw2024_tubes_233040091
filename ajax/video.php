<?php 
require "../functions/functions.php";
$id = $_GET["videoId"];
$myUserId = $_GET["userId"];

$result = (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM video_likes WHERE video_id = $id AND user_id = $myUserId")));

if($result > 0) {
  videoUnLiked($id, $myUserId);
} else {
  videoLiked($id, $myUserId);
}


?>
<input id="videoLikeId" type="hidden" value="<?= $id; ?>">
<input id="userLikeId" type="hidden" value="<?= $myUserId; ?>">
<?php if($result === 0) : ?>
<button type="button" id="unLikeButton"><i class="ri-heart-3-fill" style="color: #ff0000"></i>
  unlike</button>
<?php else : ?>
<button type="button" id="likeButton"><i class="ri-heart-3-line"></i> Like</button>
<?php endif ; ?>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/like.js"></script>
<?php 

session_start();
require "../functions/functions.php";
$playlistName = $_GET["playlistName"];
$playListId = $_GET["playListId"];
$videoId = $_GET["videoId"];
$value = $_GET["value"];
$myUserId = $_SESSION["id"];

// Mengambil data dari tabel plalist
$playlist = query("SELECT * FROM playlist WHERE user_id = $myUserId ORDER BY id DESC LIMIT 5");

?>

<!-- Alert -->
<?php 
if($value === "save") { 

  if (saveTo($videoId, $playListId) > 0) { 
  ?>
<div class="alert alert-green">
  <p>Video berhasil ditambahkan ke <?= $playlistName; ?></p>
  <button class="continue">continue</button>
</div>
<?php 
  }  
} else { 

  if (unSave($videoId, $playListId) > 0) { 
?>
<div class="alert alert-green">
  <p>Video berhasil dihapus dari list <?= $playlistName; ?></p>
  <button class="continue">continue</button>
</div>
<?php 
  } 
} ?>

<!-- Playlist Check -->
<?php foreach($playlist as $list) : ?>
<input type="hidden" id="videoId" value="<?= $videoId; ?>">
<input type="hidden" id="playlistId" value="<?= $list["id"]; ?>">
<input type="hidden" id="playlistName" value="<?= $list["name"]; ?>">
<div class="list">
  <?php if($value === "save") : ?>
  <input type="checkbox" class="check2" id="<?= $list["id"]; ?>" value="unsave" checked>
  <p><?= $value; ?></p>
  <?php else : ?>
  <input type="checkbox" class="check1" id="<?= $list["id"]; ?>" value="save">
  <p><?= $value; ?></p>
  <?php endif ; ?>
  <label for="<?= $list["id"]; ?>"><?= $list["name"]; ?></label>
</div>
<?php endforeach ; ?>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/playlist.js"></script>
<script>
$(document).ready(function() {
  $("#close").click(function(e) {
    $(".close-click").hide();
    $(".add").hide();
    $("#new").hide();
  });

  $(".close-click").click(function(e) {
    $(".close-click").hide();
    $(".add").hide();
    $("#new").hide();
  });

  $(".continue").click(function(e) {
    $(".alert").hide();
  });

  $(".check1").change(function(e) {
    $(".alert").show();
  });
  $(".check2").change(function(e) {
    $(".alert").show();
  });

  $("#add").click(function(e) {
    $(".alert").hide();
  });
});
</script>
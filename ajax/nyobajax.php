<?php 

$value = $_GET["value"];

?>

<div id="container">

  <input type="checkbox" class="check" checked>
  <input type="hidden" id="value" value="1">
  <label for="check"><?= $value; ?></label>
  <h1>kontol</h1>

</div>

<script src="../javascript/jquery.js"></script>
<script>
$(document).ready(function() {
  $(".check").on("change", function() {
    // $.get()
    $.get("../ajax/nyobajax.php?value=" + $("#value").val(), function(data) {
      $("#container").html(data);
    });
  });
});
</script>
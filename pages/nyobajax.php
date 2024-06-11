<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Latihan Ajax</title>
</head>

<body>

  <div id="container">
    <input type="hidden" id="value" value="0">
    <input type="checkbox" class="check">
    <label for="check">Kontol</label>
  </div>



  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/video.js"></script>
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
</body>

</html>
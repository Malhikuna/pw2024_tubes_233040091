<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Latihan Ajax</title>
</head>

<body>
  <input type="search" id="keyword">
  <div id="container">

  </div>



  <script src="../javascript/jquery.js"></script>
  <script>
  $(document).ready(function() {
    // Event ketika keyword ditulis
    $("#click").on("click", function() {
      // $.get()
      $.get("../ajax/nyobajax.php?id=" + $("#id").val(), function(data) {
        $("#container").html(data);
      });
    });

    $("#keyword").on("keyup", function() {
      // $.get()
      $.get("../ajax/nyobajax.php?keyword=" + $("#keyword").val(), function(data) {
        $("#container").html(data);
      });
    });
  });
  </script>
</body>

</html>
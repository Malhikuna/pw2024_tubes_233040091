<?php 

if(isset($_POST["contoh"])) {
  echo "Hello";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Percobaan</title>
  <link rel="stylesheet" href="../css/main.css">
  <style>
    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
  <script src="../javascript/jquery.js"></script>
  <script>
    $(document).ready(function () {
    })
  </script>
</head>
<body>
  <div class="container">
    <form action="" method="post">
      <select name="contoh" onchange="this.form.submit();" >
        <option value="new">New</option>
        <option value="old">Old</option>
      </select>
    </form>
  </div>
</body>
</html>
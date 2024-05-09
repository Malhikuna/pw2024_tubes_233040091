<?php 

session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "functions.php";
// cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["upload"])) {
    // cek apakah data berhasil ditambahkan atau tidak
    if (upload($_POST) > 0) {
        echo "
            <script>
                alert('Berhasil upload');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf anda gagal mengupload, silahkan cek kembali');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Page</title>
  <link rel="stylesheet" href="css/main.css">
  <!-- <link rel="stylesheet" href="css/upload.css"> -->
  <link rel="stylesheet" href="css/create.css">
</head>
<body>
  <nav>
    <div class="navbar-brand">
      <a href="#" class="judul"
        >UP YOUR SKIL</a
      >
    </div>

    <div class="search-content">
      <form action="index.php" method="post">
        <input class="search" type="text" name="keyword" size="40" placeholder="search.." autocomplete="off" id="keyword">
        <input type="hidden" class="search" name="search" id="tombol-cari"></input>
      </form>
    </div>

    <div class="navbar-list">
      <ul>
        <li><a href="./index.php" class="link">home</a></li>
        <li><a href="./upload.php" class="link">upload</a></li>
        <li><a href="./course" class="link">course</a></li>
        <li><a href="./playlist" class="link">playlist</a></li>
        <li><a href="./liked" class="link">liked</a></li>
      </ul>
    </div>

    <div class="menu">
      <input type="checkbox" />
      <img src="img/icons/menu_icon.png" class="menu-icon" height="15px" width="15px" />
    </div>
  </nav>

  <div class="container">
    <div class="form-content">
      <h2>Create Your Course</h2>
      <h2><?= $_SESSION["username"]; ?></h2>
      <form action="" method="post" enctype="multipart/form-data">
        <label>
          Catagory
          <input type="text" name="catagory" id="">
          <br>
        </label>
        <label>
          Course's Name
          <input type="text" name="title" required>
        </label>
        <label>
          Thumbnail Image
          <input type="file" name="thumbnail" class="thumbnail" required>
        </label>
        <label>
          <input type="hidden" name="author" value="<?= $_SESSION["username"]; ?>">
        </label>
        <button type="submit" name="upload" >Next</button>
      </form>
    </div>
  </div>
</body>
</html>
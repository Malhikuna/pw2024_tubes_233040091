<?php 

session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "../functions/functions.php";

// cek apakah tombol upload sudah ditekan atau belum
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
                // document.location.href = 'index.php';
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
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/create.css">
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <div class="form-content">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-content-1">
          <h2>Create Your Course</h2>
          <label>
            Course Name
            <input type="text" name="course_name" value="JavaScript Object Oriented Programing">
          </label>
          <label>
            Price
            <input type="number" name="price" value="100000">
          </label>
          <label>
            Catagory
            <select name="catagory" id="catagory">
              <option value="Frontend Developer" selected>Frontend Developer</option>
              <option value="Backend Developer">Backend Developer</option>
            </select>
            <br>
          </label>
          <label>
            Thumbnail Image
            <input type="file" name="thumbnail" class="thumbnail">
          </label>
          <label>
            <input type="hidden" name="channel_name" value="<?= $_SESSION["username"]; ?>">
          </label>
          <button class="next">Next</button>
        </div>
        <div class="form-content-2">
          <h2>Create Video</h2>
          <label>
            Video Title
            <input type="text" name="video_name" value="Pendahuluan">
            <br>
          </label>
          <label>
            Description <br>
            <textarea name="description" style="resize: none;"></textarea>
          </label>
          <br>
          <label>
            Video
            <input type="file" name="video" class="video" required>
          </label>
          <button type="submit" name="upload" >Upload</button>
          <button class="prev">Prev</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
</body>
</html>
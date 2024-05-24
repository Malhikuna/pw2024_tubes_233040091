<?php 
require "../functions/functions.php";
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
$userId = $_SESSION["id"];

$profile = query("SELECT * FROM profile WHERE user_id = $userId")[0]; 


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Video</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/alert.css">
  <link rel="stylesheet" href="../css/edit-profile.css">
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
    />
</head>
<body>
  <?php require "../layouts/navbar.php" ?>

  <div class="container">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-content">
        <div class="form-content-1">
          <label>
            Name
            <input type="text" name="username" value="<?= $_SESSION["username"]; ?>" autocomplete="off" required>
            <br>
          </label>
          <label>
            Birth
            <input type="date" name="birth" value="<?= $profile["birth"]; ?>">
          </label>
          <label for="description">Description</label>
          <div class="description">
            <div class="top">
              <button type="button" class="bold-text"><i class="ri-bold"></i></button>
              <button type="button" class="italic-text"><i class="ri-italic"></i></button>
            </div>
            <div class="bottom">
                <textarea id="description" name="description" style="resize: none;"></textarea>
            </div>
          </div>
          <br>
        </div>
        <div class="form-content-1">
          <label>
            Instagram
            <div class="sosmed">
              <div class="left">http://www.instagram.com/</div>
              <input type="text" name="instagram" value="" placeholder="Username" autocomplete="off">
            </div>
          </label>
          <label>
            Linkedin
            <div class="sosmed">
              <div class="left">http://www.linkedin.com/</div>
              <input type="text" name="linkedin" value="" placeholder="Username" autocomplete="off">
            </div>
          </label>
          <label>
            Facebook
            <div class="sosmed">
              <div class="left">http://www.facebook.com/</div>
              <input type="text" name="facebook" value="" placeholder="Username" autocomplete="off">
            </div>
          </label>
          <label>
            Youtube
            <div class="sosmed">
              <div class="left">http://www.youtube.com/</div>
              <input type="text" name="youtube" value="" placeholder="Username" autocomplete="off">
            </div>
          </label>
          <input type="hidden" name="userId" value="<?= $userId; ?>">
          <input type="hidden" name="oldProfilePicture" value="<?= $profile["image"]; ?>">
          <button type="submit" name="save" class="save" >Save</button>
        </div>


        <div class="form-content-2">
        <div class="image-profile" style="background-image: url(../img/profile/<?= $profile["image"]; ?>"></div>
          <label for="select" class="select"><i class="ri-camera-line"></i></label>
          <div class="img">
            <input id="select" type="file" name="profilePicture" value="" >
            <div class="erase"></div>
            <button name="saveImage" class="right">Save</button>
          </div>
        </div>

        <div class="option">
          <button type="button" class="square profile-about"><i class="ri-account-box-fill"></i></button>
          <button type="button" class="square profile-picture"><i class="ri-camera-fill"></i></button>
        </div>
      </div>
    </form>
    
    <?php if(isset($_POST["save"])) : ?>
      <?php if (editProfile($_POST) > 0) : ?>
        <?php $_SESSION["username"] = $_POST["username"] ?>
        <div class="alert alert-green">
          <p>Profile berhasil diupdate</p>
          <a href="profile.php?profile=<?= $_SESSION["username"]; ?>"><button name="continue" class="continue">continue</button></a>
        </div>
      <?php else : ?>
        <div class="alert alert-red">
          <p>Profile gagal diupdate</p>
          <a href="edit-profile.php"><button name="continue" class="continue con-red">continue</button></a>
        </div>    
      <?php endif ; ?>
    <?php endif ; ?>

    <?php if(isset($_POST["saveImage"])) : ?>
      <?php if (editProfilePicture($_POST) > 0) : ?>
        <?php $_SESSION["username"] = $_POST["username"] ?>
        <div class="alert alert-green">
          <p>Gambar profile anda berhasil diupdate</p>
          <a href="profile.php?profile=<?= $_SESSION["username"]; ?>"><button name="continue" class="continue">continue</button></a>
        </div>
      <?php else : ?>
        <div class="alert alert-red">
          <p>Gambar profile anda gagal diupdate</p>
          <a href="edit-profile.php"><button name="continue" class="continue con-red">continue</button></a>
        </div>    
      <?php endif ; ?>
    <?php endif ; ?> 
  </div>

  <script src="../javascript/jquery.js"></script>
  <script>
    $(document).ready(function () {
      $(".bold-text").click(function (e) { 
        $(".bold-text").toggleClass("active");
        $(".ri-bold").toggleClass("white");
        $("#description").toggleClass("bold");
      });

      $(".italic-text").click(function (e) { 
        $(".italic-text").toggleClass("active");
        $(".ri-italic").toggleClass("white");
        $("#description").toggleClass("italic");
      });

      $(".profile-about").addClass("active");
      $(".ri-account-box-fill").addClass("white");
      
      $(".form-content-2").hide();

      $(".profile-picture").click(function (e) { 
        $(".profile-picture").addClass("active");
        $(".ri-camera-fill").addClass("white");
        $(".profile-about").removeClass("active");
        $(".ri-account-box-fill").removeClass("white");
        $(".form-content-2").show();
        $(".form-content-1").hide();
      });

      $(".profile-about").click(function (e) { 
        $(".profile-about").addClass("active");
        $(".ri-account-box-fill").addClass("white");
        $(".profile-picture").removeClass("active");
        $(".ri-camera-fill").removeClass("white");
        $(".form-content-2").hide();
        $(".form-content-1").show();
      });


     })
  </script>
</body>
</html>
<?php 
require "../functions/functions.php";
session_start();

if(isset($_SESSION["login"])) {
  header ("Location: index.php");
  exit;
}

if (isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
  // Cek username
  if(mysqli_num_rows($result) === 1) {
    // Cek password

    $row = mysqli_fetch_assoc(($result));
    if (password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;

      $_SESSION["username"] = (user($_POST["email"]));

      $username = $_SESSION["username"];
      $_SESSION["id"] = query("SELECT id FROM users WHERE username = '$username'")[0]["id"];
      $_SESSION["email"] = query("SELECT email FROM users WHERE username = '$username'")[0]["email"];
      $_SESSION["role"] = query("SELECT status FROM users WHERE username = '$username'")[0]["status"];

      if ($_SESSION["role"] === "admin") {
        header ("Location: dashboard.php");
        exit;
      } else {
        header ("Location: index.php");
        exit;
      }
    }
  }
  
  $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/alert.css">
</head>

<body>
  <div class="container">
    <div class="form-content">
      <div class="left-content">
        <div class="sign-in sign-in-left">
          <h1>Sign In</h1>

          <p>Use Your Email Account</p>

          <form action="" method="post">
            <ul>
              <li>
                <input type="email" name="email" id="email" placeholder="email" autocomplete="off" required>
              </li>
              <li>
                <input type="password" name="password" id="password" placeholder="password" required>
              </li>
              <li>
                <!-- <label for="remember">Remember me :</label>
                  <input type="checkbox" name="remember" id="remember"> -->
              </li>
              <li>
                <center>
                  <hr width="100">
                </center>
                <!-- <a href="forget">Forget your password?</a> -->
                <div class="login">
                  <button type="submit" name="login">Login</button>
                </div>
              </li>
            </ul>
          </form>



          <!-- <p class="line">or continue with</p><br>

          <p>Don't have a account? <a href="registrasi.php" class="account">Create Account</a></p> -->

          <?php if(isset($error)) : ?>
          <div class="error-content">
            <p class="error">inccorect email or password</p>
          </div>
          <?php endif ; ?>

        </div>
        <div class="sign-in-open">
          <h1>Welcome Back!</h1>
          <p>Sign in To Your Account!</p>

          <button id="sign-in">SIGN IN</button>
        </div>
      </div>

      <div class="right-content">
        <div class="sign-up">
          <h1>Welcome Back!</h1>
          <p>Let's Go Create Your Account</p>

          <button type="button" id="sign-up">SIGN UP</button>
        </div>
        <div class="sign-up-input">
          <h1>Create Account</h1>
          <form action="" method="post">
            <ul>
              <li>
                <input type="email" name="email" id="email" autocomplete="off" placeholder="email" autocomplete="off"
                  required>
              </li>
              <li>
                <input type="text" name="username" id="username" autocomplete="off" placeholder="username"
                  autocomplete="off" required>
              </li>
              <li>
                <input type="number" name="phone" id="phone" autocomplete="off" placeholder="phone" autocomplete="off"
                  required>
              </li>
              <li>
                <input type="password" name="password1" id="password1" placeholder="password" required>
              </li>
              <li>
                <input type="password" name="password2" id="password2" placeholder="confirm password" required>
              </li>
              <li>
                <center>
                  <hr width="100">
                </center>
                <div class="login">
                  <button type="submit" name="sign-up">Sign UP</button>
                </div>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>

  </div>

  <?php if(isset($_POST["sign-up"])) { 
    $email = htmlspecialchars(strtolower($_POST["email"]));
    $username = htmlspecialchars(ucwords(stripslashes($_POST["username"])));
    $password1 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["password1"]));
    $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["password2"]));
    $resultEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $resultUsername = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if($password1 !== $password2) {
  ?>
  <div class="alert alert-red">
    <p>Konfirmasi password tidak sesuai</p>
    <a href="login.php"><button name="continue" class="continue con-red">continue</button></a>
  </div>
  <?php 
    } else if (mysqli_num_rows($resultEmail) > 0) {
  ?>
  <div class="alert alert-red">
    <p>Email sudah terdaftar</p>
    <a href="login.php"><button name="continue" class="continue con-red">continue</button></a>
  </div>
  <?php 
    } else if(mysqli_num_rows($resultUsername) > 0) {
  ?>
  <div class="alert alert-red">
    <p>Username sudah terpakai</p>
    <a href="login.php"><button name="continue" class="continue con-red">continue</button></a>
  </div>
  <?php 
    } else if ( registrasi($_POST) <= 0) {
  ?>
  <div class="alert alert-red">
    <p>Registrasi Gagal</p>
    <a href="login.php"><button name="continue" class="continue con-red">continue</button></a>
  </div>
  <?php
    } else {
  ?>
  <div class="alert alert-green">
    <p>Registrasi Berhasil</p>
    <a href="login.php"><button name="continue" class="continue con-red">continue</button></a>
  </div>
  <?php
    } 
  } 
  ?>

  <script src="../javascript/jquery.js"></script>
  <script src="../javascript/script.js"></script>
  <script src="../javascript/login.js"></script>
</body>

</html>
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

      // var_dump((user($_POST["email"])));

      $_SESSION["username"] = (user($_POST["email"]));

      header ("Location: index.php");
      exit;
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
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
  <div class="container">
    <div class="form-content">
      <div class="left-content">
        <div class="sign-in">
          <h1>Sign In</h1>

          <p>Use Your Email Account</p>

          <form action="" method="post">
            <ul>
              <li>
                  <input type="email" name="email" id="email" autocomplete="off" placeholder="email" autocomplete="off">
              </li>
              <li>
                  <input type="password" name="password" id="password" placeholder="password">
              </li>
              <li>
                  <!-- <label for="remember">Remember me :</label>
                  <input type="checkbox" name="remember" id="remember"> -->
              </li>
              <li>
                <div class="login">
                  <button type="submit" name="login" >Login</button>
                </div>
              </li>
            </ul>
          </form>

          <p class="line">or continue with</p><br>

          <p>Don't have a account? <a href="registrasi.php" class="account">Create Account</a></p>

          <?php if(isset($error)) : ?>
            <div class="error-content">
              <p class="error">inccorect email or password</p>
            </div>
          <?php endif ; ?>

        </div>
      </div>

      <div class="right-content">
        <div class="sign-up">
          <h1>Welcome Back!</h1>
          <p>Let's Go Create Your Account</p>

          <button id="sign-up">SIGN UP</button>
        </div>
      </div>
        
    </div>
  </div>
</body>
</html>
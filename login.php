<?php 
require "functions.php";
session_start();

if(isset($_SESSION["login"])) {
    header ("Location: index.php");
    exit;
}
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    // Cek username
    if(mysqli_num_rows($result) === 1) {
        // Cek password
    
        $row = mysqli_fetch_assoc(($result));
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
    
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
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="form-content">
            <h1>Hello !<br>Welcome Back</h1>
            
            <form action="" method="post">
                <ul>
                    <li>
                        <input type="text" name="username" id="username" placeholder="enter your name">
                    </li>
                    <li>
                        <input type="password" name="password" id="password" placeholder="enter your password">
                    </li>
                    <li>
                        <!-- <label for="remember">Remember me :</label>
                        <input type="checkbox" name="remember" id="remember"> -->
                    </li>
                    <li>
                        <button type="submit" name="login" >Login</button>
                    </li>
                </ul>
            </form>

            <p class="line">or continue with</p><br>

            <p>Don't have a account? <a href="registrasi.php" class="account">Create Account</a></p>

            <?php if(isset($error)) : ?>
                <p class="error">username / password salah</p>
            <?php endif ; ?>

        </div>
    </div>
</body>
</html>
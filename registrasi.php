<?php
require 'functions.php';

if (isset($_POST["register"])) {
    if( registrasi($_POST) > 0) {
        echo "<script>
                alert('user baru berhasil ditambahan!');
                </script>";

        // header ("Location: login.php");
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>


<div class="container">
    <div class="form-content">
    <h1 class="tag-line">Halaman Registrasi</h1>
        <form action="" method="post">
            <ul>
                <li>
                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email">
                </li>
                <li>
                    <label for="username">Username :</label>
                    <input type="text" name="username" id="username">
                </li>
                <li>
                    <label for="password1">Password :</label>
                    <input type="password" name="password1" id="password1">
                </li>
                <li>
                    <label for="password2">Konfirmasi password :</label>
                    <input type="password" name="password2" id="password2">
                </li>
                <li>
                    <button type="submit" name="register">Register</button>
                </li>
            </ul>
        </form>
    </div>
</div>

</body>
</html>
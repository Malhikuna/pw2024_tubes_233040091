<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <h1>Hello World!</h1>
    <button><a href="logout.php">Logout</a></button>

    <div class="container">
        <div class="card-rows">
            <div class="card">
                <h1>Judul 1</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias quod dignissimos, explicabo consectetur quaerat fugit.</p>
                <h4>Hikmal Maulana</h4>
                <button>Go</button>
            </div>
            <div class="card">
                <h1>Judul 1</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias quod dignissimos, explicabo consectetur quaerat fugit.</p>
                <h4>Hikmal Maulana</h4>
                <button>Go</button>
            </div>
            <div class="card">
                <h1>Judul 1</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias quod dignissimos, explicabo consectetur quaerat fugit.</p>
                <h4>Hikmal Maulana</h4>
                <button>Go</button>
            </div>
            <div class="card">
                <h1>Judul 1</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias quod dignissimos, explicabo consectetur quaerat fugit.</p>
                <h4>Hikmal Maulana</h4>
                <button>Go</button>
            </div>
        </div>
    </div>
</body>
</html>
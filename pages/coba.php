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
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
    />
  <style>
    h1, p {
      /* font-family: ; */
      font-weight: bold;
    }

    #desc {
      font-weight: 900;
    }

    img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin: auto;
      display: block;
    }
    
    .img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin: auto;
      background-position: center;
      background-size: cover;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Hello World!</h1>
    <h1><i class="ri-heart-fill"></h1>
    <p>Hello World!</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias delectus ut, veritatis, expedita possimus, esse fuga quis aut excepturi tempora porro nesciunt reprehenderit labore quibusdam suscipit natus laudantium voluptates iusto?</p>

    <label>
      Desc
      <textarea name="" id="desc"></textarea>
    </label>

    <div class="img" style="background-image: url(../img/profile/665013d3d58fb.jpeg);"></div>

    <img src="../img/profile/665013d3d58fb.jpeg">
  </div>

</body>
</html>
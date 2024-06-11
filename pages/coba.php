<?php 

if(isset($_POST["contoh"])) {
  echo "Hello";
}

$satu = 1;
$dua = "dua";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Percobaan</title>
  <link rel="stylesheet" href="../css/main.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />

  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="Mid-client-3MVh8M26cxNIxMN6"></script>
  <style>
  label {
    display: block;
  }
  </style>
</head>

<body>
  <div class="container">

    <form action="" id="checkoutForm">
      <input type="hidden" name="id" value="1">
      <label>
        Username
        <input type="text" name="username">
      </label>
      <label>
        Email
        <input type="email" name="email">
      </label>

      <button id="checkButton">Checkout</button>
    </form>

    <?php 
  
$orderSummary = query("SELECT *
                          FROM order_summary
                          JOIN cart ON cart.id = cart_id
                          JOIN courses ON courses.id = course_id
                          WHERE order_summary.user_id = $userId");

$totalPrice = query("SELECT SUM(price) AS 'Total Price'
                      FROM order_summary
                      JOIN cart ON cart.id = cart_id
                      JOIN courses ON courses.id = course_id
                      WHERE order_summary.user_id = $userId ")[0]["Total Price"];

  ?>

    <form action="" method="post">
      <div id="checkout">
        <h3>Confirm Password</h3>
        <input type="password" name="password" id="" required>
        <div class="courses">
          <?php foreach($orderSummary as $order) : ?>
          <div class="orders">
            <p><?= $order["name"]; ?></p>
            <p>Rp<?= $order["price"]; ?></p>
          </div>
          <?php endforeach ; ?>
        </div>
        <div id="total">
          <p>Total Amount</p>
          <p>Rp<?= $totalPrice; ?></p>
        </div>
        <input type="hidden" name="userId" value="<?= $userId; ?>">
        <input type="hidden" name="totalPrice" value="<?= $totalPrice; ?>">
        <button name="confirm">Confirm</button>
        <button class="close"><i class="ri-close-line"></i></button>
      </div>

      <?php if(isset($_POST["sure"])) : ?>
      <?php if (password_verify($password, $row["password"])) : ?>
      <div class="alert">
        <p>Are you sure?</p>
        <div class="yon">
          <a href="javascript:history.back()"><button type="button" class="no">No</button></a>
          <form action="" method="post">
            <input type="hidden" name="userId" value="<?= $userId; ?>">
            <button name="confirm" class="yes">Yes</button>
          </form>
        </div>
      </div>
      <?php endif ; ?>
      <?php endif ; ?>
    </form>


    <?php if(isset($_POST["confirm"])) : ?>
    <?php if (password_verify($password, $row["password"])) : ?>
    <?php if(checkout($id, $total) > 0) : ?>
    <div class="alert alert-green">
      <p>Chekout Berhasil</p>
      <a href="../invoice.php"><button type="button" name="continue" class="continue">continue</button></a>
    </div>
    <?php else : ?>
    <div class="alert alert-red">
      <p>Chekout Gagal</p>
      <a href="cart.php"><button type="button" name="continue" class="continue">continue</button></a>
    </div>
    <?php endif ; ?>
    <?php else : ?>
    <div class="alert alert-red">
      <p>Password Salah</p>
      <a href="cart.php"><button type="button" name="continue" class="continue">continue</button></a>
    </div>
    <?php endif ; ?>
    <?php endif ; ?>

    <?php require "../layouts/footer.php" ?>

  </div>

  <script>
  const form = document.querySelector("#checkoutForm");
  const checkoutButton = document.querySelector("#checkButton");

  // Kirim data ketika tombol checkout diklik
  checkoutButton.addEventListener("click", async function(e) {
    e.preventDefault();
    const formData = new FormData(form);
    const data = new URLSearchParams(formData);
    const objData = Object.fromEntries(data);
    console.log(objData);

    // minta transaction token menggunakan ajax / fetch
    try {
      const response = await fetch("../transaction/placeOrder.php", {
        method: "POST",
        body: data,
      });
      const token = await response.text();
      console.log(token);
      // window.snap.embed("YOUR_SNAP_TOKEN", {
      //   embedId: "snap-container",
      // });
    } catch (err) {
      console.log(err.message);
    }
  });
  </script>
</body>

</html>
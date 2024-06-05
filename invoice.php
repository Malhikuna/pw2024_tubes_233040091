<?php 
session_start();
require "functions/functions.php";

$userId = $_SESSION["id"];
$username = $_SESSION["username"];

$orderId = query("SELECT id FROM orders WHERE user_id = $userId ORDER BY id DESC LIMIT 1")[0]["id"];

$orders = query("SELECT * FROM orders_detail JOIN courses ON course_id = courses.id WHERE order_id = $orderId");
$totalPrice = query("SELECT SUM(courses.price) AS 'Total Price' FROM orders_detail JOIN courses ON course_id = courses.id WHERE order_id = $orderId")[0]["Total Price"];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <link rel="stylesheet" href="invoice.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="../css/remixicon.css" rel="stylesheet" />
</head>

<body>
  <div class="container">
    <a href="print.php"><button class="print"><i class="ri-printer-fill"></i></button></a>
    <div class="top">
      <div class="left">
        <h2><?= $username; ?></h2>
      </div>
      <div class="right">
        <h1>INVOICE</h1>
        <div class="bottom-right">
          <div class="date">
            <h3>Date Information</h3>
            <p>Date Information</p>
          </div>
          <div class="number">
            <h3>Invoice Number</h3>
            <p>C00001</p>
          </div>
        </div>
      </div>
    </div>
    <div class="center">
      <table>
        <thead>
          <tr>
            <th>NO</th>
            <th>Course Video</th>
            <th>Price</th>
          </tr>
        </thead>

        <tbody>
          <?php $i = 1; ?>
          <?php foreach($orders as $ord) : ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $ord["name"]; ?></td>
            <td>Rp<?= $ord["price"]; ?></td>
          </tr>
          <?php endforeach ; ?>
        </tbody>
      </table>
    </div>
    <div class="bottom">
      <h3>Total</h3>
      <div class="total-row">
        <p>Rp<?= $totalPrice; ?></p>
      </div>
    </div>
  </div>
</body>

</html>
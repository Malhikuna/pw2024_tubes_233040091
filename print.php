<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

session_start();
require "functions/functions.php";

$userId = $_SESSION["id"];
$username = $_SESSION["username"];

$orderId = query("SELECT id FROM orders WHERE user_id = $userId ORDER BY id DESC LIMIT 1")[0]["id"];
$orderDate = query("SELECT date FROM orders WHERE user_id = $userId AND id = $orderId")[0]["date"];

$orders = query("SELECT * FROM orders_detail JOIN courses ON course_id = courses.id WHERE order_id = $orderId");
$totalPrice = query("SELECT SUM(courses.price) AS 'Total Price' FROM orders_detail JOIN courses ON course_id = courses.id WHERE order_id = $orderId")[0]["Total Price"];

$html = '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <link rel="stylesheet" href="invoice.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@300&family=Rajdhani:wght@300&family=Great+Vibes&family=Roboto&family=Unbounded:wght@500&family=Oswald:wght@200;400&family=REM:wght@100;400&display=swap"
    rel="stylesheet" />
  <style>
    .top {
      width: 500px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="top">
      <div class="left">
      <h2>'. $username .'</h2>
      </div>
      <div class="right">
        <h1>INVOICE</h1>
        <div class="bottom-right">
          <div class="date">
            <h3>Date Information</h3>
            <p>' . $orderDate . '</p>
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
        
        <tbody>';

        $i = 1;
        foreach($orders as $ord) {
          $html .= '<tr>
          <td>'. $i++ .'</td>
          <td>'. $ord["name"] .'</td>
          <td>Rp'. $ord["price"] .'</td>
        </tr>';
        }

$html .= '</tbody>
</table>
</div>
<div class="bottom">
  <h3>Total</h3>
  <div class="total-row">
    <p>Rp'. $totalPrice .'</p>
  </div>
</div>
</div>
</body>

</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();
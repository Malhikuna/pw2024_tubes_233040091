<?php 
session_start();
require "../functions/functions.php";

if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$userId = $_POST["id"];
$totalPrice= $_POST["total"];

checkout($userId, $totalPrice);

?>
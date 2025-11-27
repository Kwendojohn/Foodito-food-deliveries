<?php
session_start();
include 'db_connect.php';

if (isset($_GET['food_id']) && isset($_GET['price'])) {
    $food_id = $_GET['food_id'];
    $price = $_GET['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $item = ['food_id' => $food_id, 'price' => $price];

    $_SESSION['cart'][] = $item;

    header('Location: menu.php');
    exit;
}
;
?>
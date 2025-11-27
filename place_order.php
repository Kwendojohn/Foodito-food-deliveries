<?php
session_start();
include 'db_connect.php';

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.html');
    exit;
}

// If no cart, redirect to the menu page
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$location = $_POST['location'];
$order_date = date('Y-m-d H:i:s');

// Loop through the cart items and insert into the orders table
foreach ($_SESSION['cart'] as $item) {
    $food_id = $item['food_id'];
    $total_cost = $item['price'];

    // Insert the order into the database
    $sql = "INSERT INTO orders (customer_id, food_id, total_cost, location, order_date) VALUES ('$customer_id', '$food_id', '$total_cost', '$location', '$order_date')";
    if ($conn->query($sql) === TRUE) {
        // Order successfully placed
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Clear the cart after placing the order
unset($_SESSION['cart']);

echo "<p>Order placed successfully! <a href='menu.php'>Browse Menu</a></p>";

// Close the database connection
$conn->close();
?>
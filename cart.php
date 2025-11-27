<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='menu.php'>Browse the menu</a></p>";
    exit;
}

$total_cost = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="cart.php">View Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a></li>
            </ul>
        </nav>
    </header>

    <section class="cart">
        <h1>Your Cart</h1>
        <div class="cart-items">
            <?php
            foreach ($_SESSION['cart'] as $item) {
                $food_id = $item['food_id'];
                $price = $item['price'];

                // Query the food details from the database
                $sql = "SELECT food_name FROM food WHERE food_id = $food_id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                echo '<div class="cart-item">';
                echo '<h3>' . htmlspecialchars($row['food_name']) . '</h3>';
                echo '<p>Price: $' . number_format($price, 2) . '</p>';
                $total_cost += $price;
                echo '</div>';
            }
            ?>

            <p>Total Cost: $<?php echo number_format($total_cost, 2); ?></p>
            <form action="place_order.php" method="post">
                <label for="location">Enter Delivery Location:</label>
                <input type="text" name="location" required>
                <button type="submit">Place Order</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Food Delivery Kenya</p>
    </footer>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
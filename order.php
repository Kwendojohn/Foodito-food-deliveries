<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='menu.php'>Browse the menu</a></p>";
    exit;
}

// Calculate the total cost of the order
$total_cost = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_cost += $item['price'] * $item['quantity'];
}

// Insert the order into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO orders (user_id, total_cost) VALUES ($user_id, $total_cost)";
    if ($conn->query($sql)) {
        $order_id = $conn->insert_id; // Get the ID of the newly created order

        // Insert each cart item into the order_items table
        foreach ($_SESSION['cart'] as $item) {
            $food_id = $item['food_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $conn->query("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES ($order_id, $food_id, $quantity, $price)");
        }

        // Clear the cart after the order is placed
        unset($_SESSION['cart']);
        header("Location: checkout.php?order_id=$order_id");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="css/menustyles.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="order-summary">
        <h1>Your Order Summary</h1>
        <table>
            <thead>
                <tr>
                    <th>Food Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $item) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($item['food_name']) . "</td>";
                    echo "<td>$" . number_format($item['price'], 2) . "</td>";
                    echo "<td>" . $item['quantity'] . "</td>";
                    echo "<td>$" . number_format($item['price'] * $item['quantity'], 2) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <p>Total Cost: $<?php echo number_format($total_cost, 2); ?></p>
        <form method="post">
            <button type="submit">Place Order</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Food Delivery Kenya</p>
    </footer>
</body>

</html>
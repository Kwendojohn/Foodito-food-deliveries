<?php
session_start();
include 'db_connect.php';

// Query to fetch all food items
$sql = "SELECT * FROM food";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu</title>
    <link rel="stylesheet" href="css/menustyles.css"> <!-- Adjust path if necessary -->
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <?php if (isset($_SESSION['customer_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <!-- View Cart Button -->
                    <li><a href="cart.php">View Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>



    <section class="menu">
        <h1>Our Delicious Menu</h1>
        <div class="menu-items">
            <?php
            if ($result->num_rows > 0) {
                // Loop through each row of food items
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item">';
                    echo '<img src="uploads/' . $row['image'] . '" alt="' . htmlspecialchars($row['food_name']) . '">';
                    echo '<h3>' . htmlspecialchars($row['food_name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<p>Price: $' . number_format($row['price'], 2) . '</p>';
                    echo '<a href="add_to_cart.php?food_id=' . $row['food_id'] . '&price=' . $row['price'] . '" class="order-button">Order Now</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No food items found.</p>";
            }
            ?>
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
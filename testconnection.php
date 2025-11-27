<?php

$host = 'localhost';  // Server hostname
$user = 'root';       // Default XAMPP username
$password = '';       // Default XAMPP password (leave blank)
$dbname = 'foodito';  // Your database name


$conn = new mysqli($host, $user, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful!<br>";
}

// Test query: Fetch data from the `food` table
$sql = "SELECT * FROM food";
$result = $conn->query($sql);

// Check if the table has data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Food Name: " . $row['food_name'] . "Food image: " . $row['image'] . " - Price: $" . $row['price'] . "<br>";
    }
} else {
    echo "No data found in the `food` table.";
}

// Close the connection
$conn->close();
?>
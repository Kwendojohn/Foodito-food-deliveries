<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "foodito");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Insert data into the customers table
    $sql = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='login.html'>Login here</a>";
    } else {
        if ($conn->errno === 1062) {
            echo "Error: Email already exists!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
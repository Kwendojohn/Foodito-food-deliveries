<?php
session_start();
include 'db_connect.php';



$email = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT * FROM customers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Invalid email or password.";
    exit();
}

if (password_verify($password, $user['password'])) {
    $_SESSION['customer_id'] = $user['customer_id'];
    $_SESSION['name'] = $user['name'];
    echo "Login successful! Welcome, " . htmlspecialchars($user['name']) . ".";
    header("Location: index.html");
    exit();
} else {
    echo "Invalid email or password.";
}
?>
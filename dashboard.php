<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.html");
    exit;
}
?>
<h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
<a href="logout.php">Logout</a>
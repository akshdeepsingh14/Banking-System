<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['deposit'])) {
    $amount = $_POST['amount'];
    $id = $_SESSION['user_id'];

    mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE id='$id'");
    mysqli_query($conn, "INSERT INTO transactions (user_id, type, amount) VALUES ('$id', 'deposit', '$amount')");

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deposit Money</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Deposit Money</h2>

<form method="POST">
    <input type="number" name="amount" placeholder="Amount" required min="1">
    <button type="submit" name="deposit">Deposit</button>
</form>

<br>

<a href="dashboard.php">Back to Dashboard</a> 

</body>
</html>

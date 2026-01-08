<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT balance FROM users WHERE id='$id'")
);

if (isset($_POST['withdraw'])) {
    $amount = $_POST['amount'];

    if ($user['balance'] < $amount) {
        $error = "Insufficient balance";
    } else {
        mysqli_query($conn, "UPDATE users SET balance = balance - $amount WHERE id='$id'");
        mysqli_query($conn, "INSERT INTO transactions (user_id, type, amount) VALUES ('$id', 'withdraw', '$amount')");
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Withdraw Money</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Withdraw Money</h2>

<form method="POST">
    <input type="number" name="amount" placeholder="Amount" required min="1">
    <button type="submit" name="withdraw">Withdraw</button>
</form>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>

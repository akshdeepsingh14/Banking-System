<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['user_id'];
$data = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($data);

if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="dashboard">

    <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['last_name']); ?></h2>

    <div class="account-box">
        <p><b>Account No:</b> <?php echo $user['account_number']; ?></p>
        <p class="balance">₹<?php echo $user['balance']; ?></p>
    </div>

    <a href="profile.php">Profile</a>
    <a href="deposit.php">Deposit</a>
    <a href="withdraw.php">Withdraw</a>
    <a href="transfer.php">Transfer Money</a>
    <a href="logout.php" class="logout" onclick="return confirmLogout()">Logout</a>

</div>

<script src="js/script.js"></script>
</body>
</html>

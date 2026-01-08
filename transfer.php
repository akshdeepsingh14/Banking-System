<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$sender_id = $_SESSION['user_id'];

// Get sender data
$senderData = mysqli_query($conn, "SELECT * FROM users WHERE id='$sender_id'");
$sender = mysqli_fetch_assoc($senderData);

if (!$sender) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_POST['transfer'])) {
    $receiver_account = $_POST['account'];
    $amount = $_POST['amount'];

    // Basic validation
    if ($amount <= 0) {
        $error = "Invalid amount";
    } else {
        // Get receiver
        $receiver_query = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE account_number='$receiver_account'"
        );

        if (mysqli_num_rows($receiver_query) == 0) {
            $error = "Receiver account not found";
        } else {
            $receiver = mysqli_fetch_assoc($receiver_query);

            if ($receiver['id'] == $sender_id) {
                $error = "You cannot transfer to your own account";
            } elseif ($sender['balance'] < $amount) {
                $error = "Insufficient balance";
            } else {
                // Start transfer
                mysqli_query(
                    $conn,
                    "UPDATE users SET balance = balance - $amount WHERE id='$sender_id'"
                );

                mysqli_query(
                    $conn,
                    "UPDATE users SET balance = balance + $amount WHERE id='{$receiver['id']}'"
                );

                // Insert transactions
                mysqli_query(
                    $conn,
                    "INSERT INTO transactions (user_id, type, amount)
                     VALUES ('$sender_id', 'transfer_out', '$amount')"
                );

                mysqli_query(
                    $conn,
                    "INSERT INTO transactions (user_id, type, amount)
                     VALUES ('{$receiver['id']}', 'transfer_in', '$amount')"
                );

                $success = "Money transferred successfully";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transfer Money</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Bank to Bank Transfer</h2>

<form method="POST">
    <input type="text" name="account" placeholder="Receiver Account Number" required>
    <input type="number" name="amount" placeholder="Amount" required min="1">
    <button type="submit" name="transfer">Transfer</button>
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red'>$error</p>";
}
if (isset($success)) {
    echo "<p style='color:green'>$success</p>";
}
?>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>

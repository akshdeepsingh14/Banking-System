<?php
session_start();
include "config/db.php";

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Apna Bank</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Welcome to Apna Bank</h2>
<?php if (isset($error)) : ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>

<p>
    Don't have an account yet? <a href="register.php">Create Account</a>
</p>

</body>
</html>

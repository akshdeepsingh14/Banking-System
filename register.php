<?php
include "config/db.php";

if (isset($_POST['register'])) {

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $dob        = $_POST['dob'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];

    // Checkbox check
    if (!isset($_POST['agree'])) {
        $error = "You must confirm your details";
    }
    // Password match check
    elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    }
    else {

        // AGE CHECK (18+)
        $dobDate = new DateTime($dob);
        $today   = new DateTime();
        $age     = $today->diff($dobDate)->y;

        if ($age < 18) {
            $error = "You must be at least 18 years old to create a bank account";
        }
        else {
            // Check email exists
            $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
            if (mysqli_num_rows($check) > 0) {
                $error = "Email already registered";
            } else {
                // Secure password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Account number
                $account = "BANK" . rand(100000, 999999);

                // Insert user
                mysqli_query(
                    $conn,
                    "INSERT INTO users 
                    (first_name, last_name, dob, phone, email, password, account_number, balance)
                    VALUES
                    ('$first_name', '$last_name', '$dob', '$phone', '$email', '$hashed_password', '$account', 0)"
                );

                header("Location: index.php");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register in Apna Bank</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<br>
<h2>Create Bank Account</h2>

<form method="POST" onsubmit="return validateForm() && validateAge()">

    <input type="text" name="first_name" placeholder="First Name" required>

    <input type="text" name="last_name" placeholder="Last Name" required>

    <input type="date" name="dob" required
        max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">

    <input type="tel" name="phone" placeholder="Phone Number" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Password" required>

    <input type="password" name="confirm_password" placeholder="Confirm Password" required>

    <label>
        <input type="checkbox" name="agree" required>
        I confirm that the above details are correct
    </label>

    <button type="submit" name="register">Register</button>

</form>
<p>Already have an account? <a href="index.php">Login here</a></p>
<?php
if (isset($error)) {
    echo "<p style='color:red'>$error</p>";
}
?>

</body>
</html>

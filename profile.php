<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['user_id'];

// Fetch user data
$data = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($data);

if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Ensure upload directory exists
if (!is_dir("uploads/profiles")) {
    mkdir("uploads/profiles", 0777, true);
}

// --- UPLOAD IMAGE ---
if (isset($_POST['upload'])) {
    if (!empty($_FILES['profile_image']['name'])) {

        $original = $_FILES['profile_image']['name'];
        $safeName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $original);
        $fileName = time() . "_" . $safeName;

        $target = "uploads/profiles/" . $fileName;
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png'];

        if (!in_array($ext, $allowed)) {
            $error = "Only JPG, JPEG, PNG allowed";
        } else {

            move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);

            if ($user['profile_image'] != 'default.png' &&
                file_exists("uploads/profiles/".$user['profile_image'])) {
                unlink("uploads/profiles/".$user['profile_image']);
            }

            mysqli_query($conn, "UPDATE users SET profile_image='$fileName' WHERE id='$id'");
            header("Refresh:0");
            exit();
        }
    } else {
        $error = "Please select an image";
    }
}

// --- DELETE IMAGE ---
if (isset($_POST['delete'])) {

    if ($user['profile_image'] != 'default.png' &&
        file_exists("uploads/profiles/".$user['profile_image'])) {
        unlink("uploads/profiles/".$user['profile_image']);
    }

    mysqli_query($conn, "UPDATE users SET profile_image='default.png' WHERE id='$id'");
    header("Refresh:0");
    exit();
}

// Fetch transactions
$transactions = mysqli_query(
    $conn,
    "SELECT * FROM transactions 
     WHERE user_id='$id' 
     ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <br>
    <title>Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Profile</h2>

<div class="profile-card">

    <!-- ===== TOP SECTION: IMAGE + DETAILS ===== -->
    <div class="profile-top">

        <!-- LEFT: IMAGE + UPLOAD/DELETE -->
        <div class="profile-left">
            <img id="profilePreview"
                 src="uploads/profiles/<?php echo $user['profile_image']; ?>"
                 class="profile-img">

            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_image" accept="image/*">
                <button name="upload">Upload / Change</button>
            </form>

            <form method="POST" style="margin-top:10px;">
                <button name="delete"
                    onclick="return confirm('Are you sure you want to delete your profile picture?')">
                    Delete Profile Picture
                </button>
            </form>
        </div>

        <!-- RIGHT: USER INFO -->
        <div class="profile-right">
            <p><b>First Name:</b> <?php echo $user['first_name']; ?></p>
            <p><b>Last Name:</b> <?php echo $user['last_name']; ?></p>
            <p><b>Date of Birth:</b> <?php echo $user['dob']; ?></p>
            <p><b>Phone:</b> <?php echo $user['phone']; ?></p>
            <p><b>Email:</b> <?php echo $user['email']; ?></p>
            <p><b>Account No:</b> <?php echo $user['account_number']; ?></p>
        </div>

    </div> <!-- /profile-top -->

    <hr>

    <!-- ===== TRANSACTIONS ===== -->
    <h3>Transaction History</h3>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Amount</th>
        </tr>

        <?php if (mysqli_num_rows($transactions) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($transactions)): ?>
                <tr>
                    <td><?php echo $row['created_at']; ?></td>
                    <td><?php echo ucfirst(str_replace("_", " ", $row['type'])); ?></td>
                    <td>
                        <?php
                        if ($row['type'] == 'deposit' || $row['type'] == 'transfer_in') {
                            echo "<span style='color:green'>+₹{$row['amount']}</span>";
                        } else {
                            echo "<span style='color:red'>-₹{$row['amount']}</span>";
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No transactions found</td>
            </tr>
        <?php endif; ?>
    </table>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>

    <?php
    if (isset($error)) {
        echo "<p style='color:red'>$error</p>";
    }
    ?>
</div>

<script src="js/script.js"></script>
</body>
</html>

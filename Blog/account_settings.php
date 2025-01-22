<?php
session_start();
include('db_connection.php'); // Include the DB connection file

// Ensure the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php"); // Redirect to login page if not logged in
//     exit;
// }

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch the user's account data from the database
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Check if user data exists
if (!$user) {
    echo "User not found.";
    exit;
}

// Handle account settings update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_account'])) {
        // Validate the form data
        $new_email = $_POST['email'];
        $new_password = $_POST['password'];

        // Update email and password in the database
        $update_sql = "UPDATE users SET email = '$new_email', password = '$new_password' WHERE id = '$user_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Account settings updated successfully!";
            header("Location: account_settings.php"); // Refresh the page to show updated settings
        } else {
            echo "Error updating account: " . mysqli_error($conn);
        }
    }

    // Handle account deletion
    if (isset($_POST['delete_account'])) {
        $delete_sql = "DELETE FROM users WHERE id = '$user_id'";
        if (mysqli_query($conn, $delete_sql)) {
            session_destroy(); // Destroy session after account deletion
            header("Location: logout.php"); // Redirect to a goodbye or logout page
        } else {
            echo "Error deleting account: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - BlogVault</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>

<div class="account-settings-container">
    <h2>Account Settings</h2>

    <form method="POST" action="account_settings.php">
        <!-- Update Account Form -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" placeholder="Enter new password" required>
        </div>

        <div class="form-group">
            <button type="submit" name="update_account" class="btn btn-update">Update Account</button>
        </div>
    </form>

    <!-- Delete Account Form -->
    <form method="POST" action="account-settings.php">
        <div class="form-group">
            <button type="submit" name="delete_account" class="btn btn-danger">Delete My Account</button>
        </div>
    </form>
</div>

</body>
</html>

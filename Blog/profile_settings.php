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

// Fetch the user's profile data from the database
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Check if user data exists
if (!$user) {
    echo "User not found.";
    exit;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update the user's profile in the database
    $update_sql = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "Profile updated successfully!";
        header("Location: profile-settings.php"); // Refresh the page to show updated profile
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - BlogVault</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>

<div class="profile-settings-container">
    <h2>Edit Profile</h2>

    <form method="POST" action="profile_settings.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter new password" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-update">Update Profile</button>
        </div>
    </form>
</div>

</body>
</html>

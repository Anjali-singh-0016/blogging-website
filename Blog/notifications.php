<?php
include('db_connection.php');
session_start();

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch notifications (assuming a `notifications` table exists)
$sql = "SELECT message, timestamp FROM notifications WHERE user_id = '$user_id' ORDER BY timestamp DESC";
$result = mysqli_query($conn, $sql);
?>

<h2>Your Notifications</h2>
<ul>
<?php while ($notification = mysqli_fetch_assoc($result)): ?>
    <li>
        <strong><?php echo htmlspecialchars($notification['message']); ?></strong> on <?php echo date('F j, Y', strtotime($notification['timestamp'])); ?>
    </li>
<?php endwhile; ?>
</ul>

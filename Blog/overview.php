
<?php
// Assume we have a function to get user data like blog counts, recent activity, etc.
include('db_connection.php'); // Include database connection file
session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");  // Redirect to login page if not logged in
//     exit();
// }

// Get the logged-in user's ID from session
$user_id = $_SESSION['user_id']; 

// Fetch user data from the database
$user_data = getUserData($conn, $user_id);
$blogs_count = getBlogsCount($conn, $user_id);
$comments_count = getCommentsCount($conn, $user_id);
$categories_count = getCategoriesCount($conn, $user_id);
$drafts_count = getDraftsCount($conn, $user_id);

// Fetch recent activity (e.g., blog posts, comments, etc.)
$recent_activity = getRecentActivity($conn, $user_id);

// Function to fetch user-related data from the database
function getUserData($conn, $user_id) {
    // Example database query to get user data (replace with your own logic)
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getBlogsCount($conn, $user_id) {
    $sql = "SELECT COUNT(*) FROM blogs WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_row($result)[0];
}

function getCommentsCount($conn, $user_id) {
    $sql = "SELECT COUNT(*) FROM comments WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_row($result)[0];
}

function getCategoriesCount($conn, $user_id) {
    $sql = "SELECT COUNT(*) FROM categories WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_row($result)[0];
}

function getDraftsCount($conn, $user_id) {
    $sql = "SELECT COUNT(*) FROM blogs WHERE user_id = '$user_id' AND status = 'draft'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_row($result)[0];
}

function getRecentActivity($conn, $user_id) {
    // Example: fetch recent blog posts or other actions
    $sql = "SELECT title, action_type, timestamp FROM activity WHERE user_id = '$user_id' ORDER BY timestamp DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);
    return $result;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogVault Dashboard</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<h2>Welcome to Your Dashboard, <?php //echo htmlspecialchars($user_data['name']); ?>!</h2>
<p>Here's a quick glance at your activity and some tools to get started:</p>


<!-- Recent Activity Section -->
<section class="recent-activity">
    <h3>Recent Activity</h3>
    <ul>
        <?php while($activity = mysqli_fetch_assoc($recent_activity)): ?>
            <li>
                <i class="fas fa-<?php echo $activity['action_type'] == 'edit' ? 'edit' : 'comments'; ?>"></i>
                You <?php echo $activity['action_type']; ?> the blog <strong>"<?php echo htmlspecialchars($activity['title']); ?>"</strong> on <?php echo date('F j, Y', strtotime($activity['timestamp'])); ?>.
            </li>
        <?php endwhile; ?>
    </ul>
</section>

<!-- Quick Stats Section -->
<section class="quick-stats">
    <h3>Quick Stats</h3>
    <div class="stats-container">
        <div class="stat-box">
            <h4>Total Blogs</h4>
            <p><?php echo $blogs_count; ?></p>
        </div>
        <div class="stat-box">
            <h4>Comments</h4>
            <p><?php echo $comments_count; ?></p>
        </div>
        <div class="stat-box">
            <h4>Categories</h4>
            <p><?php echo $categories_count; ?></p>
        </div>
        <div class="stat-box">
            <h4>Drafts</h4>
            <p><?php echo $drafts_count; ?></p>
        </div>
    </div>
</section>

<!-- Notifications Section -->
<section class="notifications">
    <h3>Notifications</h3>
    <p>No new notifications. <a href="notifications.php">View all notifications</a>.</p>
</section>

<!-- Quick Actions Section -->
<section class="quick-actions">
    <h3>Quick Actions</h3>
    <div class="actions-container">
        <a href="#" data-target="create_blog.php" class="action-btn"><i class="fas fa-plus-circle"></i> Create a New Blog</a>
        <a href="#" data-target="view_blog.php" class="action-btn"><i class="fas fa-eye"></i> View All Blogs</a>
        <a href="#" data-target="categories.php" class="action-btn"><i class="fas fa-folder-open"></i> Manage Categories</a>
        <a href="#" data-target="analytics.php" class="action-btn"><i class="fas fa-chart-line"></i> View Analytics</a>
    </div>
</section>

    <script src="./JS/dashboard.js">
    </script>
</body>
</html>

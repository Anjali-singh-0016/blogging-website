<?php
// analytics.php

session_start();
include('db_connection.php'); // Include your DB connection file

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Increment views for all blogs on view (this would be done in a separate blog viewing page, like single_blog.php)
if (isset($_GET['blog_id'])) {
    incrementViews($_GET['blog_id']); // Increment views for the specific blog
}

// Fetching the total views for all blogs
$total_views = getTotalViews($user_id);

// Fetching the total number of comments
$total_comments = getTotalComments($user_id);

// Fetching the most popular blog based on views
$most_popular_blog = getMostPopularBlog($user_id);

// Function to increment views of a blog
function incrementViews($blog_id) {
    global $conn;
    $sql = "UPDATE blogs SET views = views + 1 WHERE id = '$blog_id'";
    mysqli_query($conn, $sql);
}

// Function to get total views of all blogs
function getTotalViews($user_id) {
    global $conn; // Use the global connection variable
    $sql = "SELECT SUM(views) FROM blogs WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row[0] !== null ? $row[0] : 0; // Return 0 if null
}

// Function to get total comments across all blogs
function getTotalComments($user_id) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM comments WHERE blog_id IN (SELECT id FROM blogs WHERE user_id = '$user_id')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row[0] !== null ? $row[0] : 0; // Return 0 if null
}

// Function to get the most popular blog based on views
function getMostPopularBlog($user_id) {
    global $conn;
    $sql = "SELECT title, views FROM blogs WHERE user_id = '$user_id' ORDER BY views DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result) ?: ['title' => 'No blogs available', 'views' => 0]; // Default if no blogs
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - BlogVault</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>

<div class="analytics-container">
    <h2>Blog Analytics</h2>
    
    <!-- Total Views -->
    <div class="stat-box">
        <h4>Total Views</h4>
        <p><?php echo number_format($total_views); ?> Views</p>
    </div>

    <!-- Total Comments -->
    <div class="stat-box">
        <h4>Total Comments</h4>
        <p><?php echo number_format($total_comments); ?> Comments</p>
    </div>

    <!-- Most Popular Blog -->
    <div class="stat-box">
        <h4>Most Popular Blog</h4>
        <p><strong><?php echo htmlspecialchars($most_popular_blog['title']); ?></strong> with <?php echo number_format($most_popular_blog['views']); ?> views</p>
    </div>

    <!-- Placeholder for Graphs -->
    <div class="analytics-graphs">
        <h4>Engagement Graphs</h4>
        <p>Graphs will be added here to show trends over time (e.g., views per day/week, comment count, etc.)</p>
        <!-- You can later integrate graph libraries like Chart.js here -->
    </div>
</div>

</body>
</html>

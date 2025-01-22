<?php
// edit-blog.php

session_start();
include('db_connection.php'); // Include DB connection file

// Get the blog ID from the URL
$blog_id = $_GET['id'];

// Ensure the user is logged in
$user_id = $_SESSION['user_id'];

// Fetch the blog data for editing
$sql = "SELECT * FROM blogs WHERE id = '$blog_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$blog = mysqli_fetch_assoc($result);

// Check if the blog exists and is a draft
if ($blog['status'] == 'draft') {
    // Proceed to edit the blog
} else {
    // Redirect if not a draft
    header("Location: drafts.php");
}
?>

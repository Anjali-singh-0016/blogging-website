<?php
// publish-blog.php

session_start();
include('db_connection.php'); // Include DB connection file

// Get the blog ID from the URL
$blog_id = $_GET['id'];

// Ensure the user is logged in
$user_id = $_SESSION['user_id'];

// Update the blog status to 'published'
$sql = "UPDATE blogs SET status = 'published' WHERE id = '$blog_id' AND user_id = '$user_id'";
if (mysqli_query($conn, $sql)) {
    echo "Blog published successfully!";
    header("Location: drafts.php"); // Redirect to drafts page
} else {
    echo "Error publishing blog: " . mysqli_error($conn);
}
?>

// delete_comment.php
<?php 
session_start();
include('db_connection.php'); 

if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];
    
    // Delete the comment from the database
    $sql = "DELETE FROM comments WHERE id = '$comment_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Comment deleted successfully.";
        header('Location: comments.php'); // Redirect after deletion
    } else {
        echo "Error deleting comment.";
    }
}

?>
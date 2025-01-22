// approve_comment.php
<?php
session_start();
include('db_connection.php'); 

if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];
    
    // Update the comment status to 'approved' in the database
    $sql = "UPDATE comments SET status = 'approved' WHERE id = '$comment_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Comment approved successfully.";
        header('Location: comments.php'); // Redirect to the comment section after approval
    } else {
        echo "Error approving comment.";
    }
}
?>

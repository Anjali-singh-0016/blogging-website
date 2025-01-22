<?php
include('db_connection.php'); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = $_POST['comment_id'];
    $reply = $_POST['reply'];
    
    // Insert the reply into the database
    $sql = "INSERT INTO comment_replies (comment_id, reply, replied_by) 
            VALUES ('$comment_id', '$reply', 'admin')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Reply added successfully.";
        header('Location: comments.php'); // Redirect after reply
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error adding reply: " . mysqli_error($conn);
    }
}
?>

<?php
// Display a form to reply to the comment
if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];
?>
    <form method="POST" action="reply_comment.php">
        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
        <textarea name="reply" placeholder="Write your reply here..." required></textarea>
        <button type="submit" class="btn reply-btn">Submit Reply</button>
    </form>
<?php
}
?>
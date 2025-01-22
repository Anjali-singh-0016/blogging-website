<?php
include('db_connection.php'); // Include database connection file
session_start();
// Assuming you have a connection to the database ($conn)
$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
$comments = getComments($user_id); // Fetch comments based on the logged-in user

// Function to fetch comments from the database
function getComments($user_id) {
    global $conn;
    $sql = "SELECT c.id, c.content, b.title as blog_title, u.name as commenter_name
            FROM comments c
            JOIN blogs b ON c.blog_id = b.id
            JOIN users u ON c.user_id = u.id
            WHERE b.user_id = '$user_id'
            ORDER BY c.created_at DESC";
    $result = mysqli_query($conn, $sql);
    return $result;
}
?>

<html>
<head>
    <title>Comments - BlogVault</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>
    <!-- Comment Section -->
    <section class="comments-section">
        <h3>Your Blog Comments</h3>

        <!-- Check if there are comments -->
        <?php if(mysqli_num_rows($comments) > 0): ?>
            <table class="comments-table">
                <thead>
                    <tr>
                        <th>Commenter</th>
                        <th>Blog Title</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($comment = mysqli_fetch_assoc($comments)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($comment['commenter_name']); ?></td>
                            <td><?php echo htmlspecialchars($comment['blog_title']); ?></td>
                            <td><?php echo htmlspecialchars($comment['content']); ?></td>
                            <td>
                                <a href="approve_comment.php?comment_id=<?php echo $comment['id']; ?>" class="btn approve-btn">Approve</a>
                                <a href="delete_comment.php?comment_id=<?php echo $comment['id']; ?>" class="btn delete-btn">Delete</a>
                                <a href="reply_comment.php?comment_id=<?php echo $comment['id']; ?>" class="btn reply-btn">Reply</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </section>
</body>
</html>

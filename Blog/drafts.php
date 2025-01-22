<?php
// drafts.php

session_start();
include('db_connection.php'); // Include the DB connection file

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetching the drafts from the database
$drafts = getDrafts($user_id);

// Function to fetch drafts from the database
function getDrafts($user_id) {
    global $conn; // Use the global connection variable
    $sql = "SELECT * FROM blogs WHERE user_id = '$user_id' AND status = 'draft' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Blogs - BlogVault</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>

<div class="drafts-container">
    <h2>Your Draft Blogs</h2>

    <?php if (mysqli_num_rows($drafts) > 0): ?>
        <table class="drafts-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($draft = mysqli_fetch_assoc($drafts)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($draft['title']); ?></td>
                        <td><?php echo date('F j, Y', strtotime($draft['created_at'])); ?></td>
                        <td>
                            <a href="edit_blog.php?id=<?php echo $draft['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="publish_blog.php?id=<?php echo $draft['id']; ?>" class="btn btn-publish">Publish</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no drafts at the moment. Start writing your first blog!</p>
    <?php endif; ?>

</div>

</body>
</html>

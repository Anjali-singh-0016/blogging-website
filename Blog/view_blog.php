<?php
include('db_connection.php'); // Include database connection file
session_start();

$user_id = $_SESSION['user_id'];
$search_query = $_GET['search'] ?? ''; // Get search query if provided

// Fetch blogs from the database
$sql = "SELECT id, title, content, created_at, status FROM blogs 
        WHERE user_id = '$user_id' AND title LIKE '%$search_query%' 
        ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<html>
    <head>
        <title>View Blogs - BlogVault</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="./CSS/dashboard.css">
    </head>
    <body>
    <h2>Your Blogs</h2>
<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="Search blogs by title..." value="<?php echo htmlspecialchars($search_query); ?>">
    <button type="submit"><i class="fas fa-search"></i></button>
</form>

<table class="blogs-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($blog = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($blog['title']); ?></td>
                <td><?php echo htmlspecialchars($blog['category']); ?></td>
                <td><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></td>
                <td>
                    <?php if ($blog['status'] === 'published'): ?>
                        <span class="status published">Published</span>
                    <?php else: ?>
                        <span class="status draft">Draft</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="action-btn edit"><i class="fas fa-edit"></i> Edit</a>
                    <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this blog?');"><i class="fas fa-trash"></i> Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    </body>
</html>
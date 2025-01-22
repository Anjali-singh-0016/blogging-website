<?php
include('db_connection.php');
session_start();

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch user categories
$sql = "SELECT id, name FROM categories WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

// Handle category addition, editing, and deletion here
?>

<h2>Manage Categories</h2>
<form method="POST" action="add-category.php">
    <input type="text" name="category_name" placeholder="Category Name" required>
    <button type="submit">Add Category</button>
</form>

<ul>
    <?php while ($category = mysqli_fetch_assoc($result)): ?>
        <li><?php echo htmlspecialchars($category['name']); ?></li>
    <?php endwhile; ?>
</ul>

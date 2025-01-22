<?php
include('db_connection.php');
session_start();

// Fetch all categories for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM categories WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle category actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $category_name = trim($_POST['category_name']); // Get the category name from input

    if ($action === 'add' && !empty($category_name)) {
        // Insert new category into the database
        $add_sql = "INSERT INTO categories (user_id, name) VALUES (?, ?)";
        $add_stmt = $conn->prepare($add_sql);
        $add_stmt->bind_param("is", $user_id, $category_name);
        if ($add_stmt->execute()) {
            // Redirect back to the same page with a success message
            header("Location: manage_categories.php?success=Category added successfully!");
            exit;
        } else {
            // If there's an error, redirect back with an error message
            header("Location: manage_categories.php?error=Failed to add category.");
            exit;
        }
    } 
    // Other actions (edit/delete) go here...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>
<h2>Manage Categories</h2>

<!-- Display Success/Error Messages -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert success"><?php echo htmlspecialchars($_GET['success']); ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert error"><?php echo htmlspecialchars($_GET['error']); ?></div>
<?php endif; ?>

<!-- Add Category Form -->
<form method="POST" class="category-form" action="manage_categories.php">
    <input type="text" name="category_name" placeholder="Enter category name" required>
    <button type="submit" name="action" value="add" class="btn">Add Category</button>
</form>

<!-- Categories Table -->
<table class="category-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($category = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td>
                    <form method="POST" class="inline-form">
                        <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                        <input type="text" name="category_name" placeholder="Edit name" required>
                        <button type="submit" name="action" value="edit" class="btn btn-edit">Edit</button>
                        <button type="submit" name="action" value="delete" class="btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>

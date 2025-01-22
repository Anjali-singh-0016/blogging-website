<?php
session_start();
include('db_connection.php');

// Fetch categories for the dropdown
$categories_query = "SELECT id, name FROM categories WHERE user_id = ?";
$stmt = $conn->prepare($categories_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$categories_result = $stmt->get_result();
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="./CSS/dashboard.css">
    </head>
    <body>
    <div class="create-blog-container">
    <h2>Create a New Blog</h2>
    <form action="submit_blog.php" method="POST" enctype="multipart/form-data" class="create-blog-form">
        <!-- Blog Title -->
        <div class="form-group">
            <label for="blog-title">Blog Title:</label>
            <input type="text" id="blog-title" name="title" placeholder="Enter blog title" required>
        </div>

        <!-- Blog Content -->
        <div class="form-group">
            <label for="blog-content">Content:</label>
            <textarea id="blog-content" name="content" rows="10" placeholder="Write your blog here..." required></textarea>
        </div>

        <!-- Blog Category -->
        <div class="form-group">
            <label for="blog-category">Category:</label>
            <select id="blog-category" name="category_id" required>
                <option value="">Select a category</option>
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Blog Tags -->
        <div class="form-group">
            <label for="blog-tags">Tags (comma-separated):</label>
            <input type="text" id="blog-tags" name="tags" placeholder="e.g., technology, education">
        </div>

        <!-- Blog Image -->
        <div class="form-group">
            <label for="blog-image">Featured Image:</label>
            <input type="file" id="blog-image" name="image" accept="image/*">
        </div>

        <!-- Submit Options -->
        <div class="form-group actions">
            <button type="submit" name="save_as_draft" class="btn draft-btn">Save as Draft</button>
            <button type="submit" name="publish" class="btn publish-btn">Publish</button>
        </div>
    </form>
</div>

    </body>
</html>
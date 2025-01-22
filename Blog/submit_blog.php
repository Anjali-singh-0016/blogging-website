<?php
session_start();
include('db_connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Ensure user is logged in
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);
    $tags = trim($_POST['tags']);
    $status = isset($_POST['publish']) ? 'published' : 'draft';

    // Validate mandatory fields
    if (empty($title) || empty($content) || empty($category_id)) {
        $error_message = "Title, content, and category are required.";
        header("Location: dashboard.php?error=" . urlencode($error_message));
        exit;
    }

    // File upload handling
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $image_name = time() . '_' . basename($_FILES['image']['name']); // Unique image name
        $image_path = $target_dir . $image_name;

        // Create uploads directory if not exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_path;
        } else {
            $error_message = "Error uploading image.";
            header("Location: dashboard.php?error=" . urlencode($error_message));
            exit;
        }
    }

    // Insert blog data into the database
    $query = "INSERT INTO blogs (user_id, title, content, category_id, tags, image, status, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ississs", $user_id, $title, $content, $category_id, $tags, $image, $status);

    if ($stmt->execute()) {
        $success_message = "Blog successfully " . ($status === 'published' ? 'published!' : 'saved as draft!');
        header("Location: dashboard.php?success=" . urlencode($success_message));
        exit;
    } else {
        $error_message = "Failed to save the blog. Please try again.";
        header("Location: dashboard.php?error=" . urlencode($error_message));
        exit;
    }
}
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('db_connection.php'); // Include database connection
require_once('functions.php'); // Include custom helper functions

// Initialize response array
$response = [
    'status' => 'error',  // Default status is error
    'message' => '',      // Error message
    'redirect' => '',     // URL for redirect (if success)
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate user inputs
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Check for empty fields
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $response['message'] = "All fields are required!";
        echo json_encode($response); // Send response and exit
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format!";
        echo json_encode($response); // Send response and exit
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $response['message'] = "Passwords do not match!";
        echo json_encode($response); // Send response and exit
        exit();
    }

    // Check for existing email
    $query = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $response['message'] = "An account with this email already exists!";
        echo json_encode($response); // Send response and exit
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $insertQuery = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sss", $name, $email, $hashedPassword);

    if ($insertQuery->execute()) {
        // Registration successful
        $response['status'] = 'success';
        $response['message'] = "Account created successfully! Please login.";
        $response['redirect'] = 'login.php';  // Redirect to login page
        echo json_encode($response); // Send success response
        exit();
    } else {
        // Registration failed
        $response['message'] = "Something went wrong. Please try again.";
        echo json_encode($response); // Send error response
        exit();
    }
} else {
    $response['message'] = "Invalid request method.";
    echo json_encode($response); // Send error response
    exit();
}
?>

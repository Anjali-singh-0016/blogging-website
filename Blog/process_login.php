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
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($email) || empty($password)) {
        $response['message'] = "Email and Password are required!";
        echo json_encode($response); // Send response and exit
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Invalid email format!";
        echo json_encode($response); // Send response and exit
        exit();
    }

    // Check if user exists in the database
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user information in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            // Set success response and the redirect URL
            $response['status'] = 'success';
            $response['message'] = 'Login successful!';
            $response['redirect'] = 'dashboard.php'; // Set the redirect page URL

            echo json_encode($response); // Send success response
            exit();
        } else {
            $response['message'] = "Incorrect password!";
            echo json_encode($response); // Send response and exit
            exit();
        }
    } else {
        $response['message'] = "No account found with that email!";
        echo json_encode($response); // Send response and exit
        exit();
    }
} else {
    $response['message'] = 'Invalid request method!';
    echo json_encode($response); // Send response and exit
    exit();
}
?>

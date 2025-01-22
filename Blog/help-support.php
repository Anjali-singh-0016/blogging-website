<?php
session_start();
include('db_connection.php'); // Include DB connection file

// Ensure user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php"); // Redirect to login page if not logged in
//     exit;
// }

// Fetch FAQs from the database (if any)
$sql = "SELECT * FROM faqs ORDER BY created_at DESC";
$faqs_result = mysqli_query($conn, $sql);

// Handle Support Request Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_support'])) {
        $user_id = $_SESSION['user_id'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Insert the support request into the database
        $support_sql = "INSERT INTO support_requests (user_id, subject, message, status) VALUES ('$user_id', '$subject', '$message', 'Pending')";
        if (mysqli_query($conn, $support_sql)) {
            echo "Your support request has been submitted. We'll get back to you shortly.";
        } else {
            echo "Error submitting your request: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support - BlogVault</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>

<div class="help-support-container">
    <h2>Help & Support</h2>

    <!-- Display FAQs -->
    <div class="faqs-section">
        <h3>Frequently Asked Questions</h3>
        <?php
        if (mysqli_num_rows($faqs_result) > 0) {
            while ($faq = mysqli_fetch_assoc($faqs_result)) {
                echo "<div class='faq'>
                        <h4>" . htmlspecialchars($faq['question']) . "</h4>
                        <p>" . htmlspecialchars($faq['answer']) . "</p>
                    </div>";
            }
        } else {
            echo "<p>No FAQs available at the moment. Please feel free to submit your request below.</p>";
        }
        ?>
    </div>

    <!-- Support Request Form -->
    <div class="support-request-form">
        <h3>Submit a Support Request</h3>
        <form method="POST" action="help-support.php">
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" required placeholder="Enter the subject of your issue">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" required placeholder="Describe your issue"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="submit_support" class="btn btn-submit">Submit Request</button>
            </div>
        </form>
    </div>

</div>

</body>
</html>

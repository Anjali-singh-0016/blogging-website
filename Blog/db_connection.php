
<?php
$servername = "localhost";
$username = "root";
$password = "Anjali@sql"; // Your MySQL root password
$dbname = "blogvault";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
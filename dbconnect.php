<?php
// Database credentials
$servername = "localhost";  // Db host
$db_username = "root";          // Db username
$db_password = "";          // Db Password
$db_name = "SwiftaidDb";      // Db Name

// Create a connection
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Close the connection when done
?>

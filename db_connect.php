<?php
$servername = "localhost"; // Change this if your database is hosted remotely
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (leave empty)
$database = "elder_care_db"; // Ensure the correct database name WITHOUT extra spaces

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$servername = "localhost";
$db_username = "root"; // Database username
$db_password = ""; // Database password (keep empty for XAMPP)
$dbname = "elder_care_db"; // Your database name

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

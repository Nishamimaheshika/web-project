<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elder_care_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $request_date = $conn->real_escape_string($_POST['date']);
    $time_limit = (int)$_POST['time'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $adult_name = $conn->real_escape_string($_POST['adultName']);
    $adult_status = $conn->real_escape_string($_POST['status']);
    $employee_id = (int)$_POST['employee'];
    $total_amount = (float)str_replace("Rs. ", "", $_POST['total']);
    $created_at = date('Y-m-d H:i:s');

    // Fetch employee name
    $employee_query = "SELECT name FROM employees WHERE employee_id = $employee_id";
    $result = $conn->query($employee_query);
    $employee_name = ($result->num_rows > 0) ? $result->fetch_assoc()['name'] : '';

    // Handle file upload
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $upload_file = $upload_dir . basename($_FILES['healthReport']['name']);

    if (move_uploaded_file($_FILES['healthReport']['tmp_name'], $upload_file)) {
        $sql = "INSERT INTO care_requests (name, address, request_date, time_limit, phone, adult_name, adult_status, health_report, employee_id, employee_name, total_amount, created_at) 
                VALUES ('$name', '$address', '$request_date', $time_limit, '$phone', '$adult_name', '$adult_status', '$upload_file', $employee_id, '$employee_name', $total_amount, '$created_at')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New care request created successfully!'); window.location.href='users.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "'); window.location.href='users.php';</script>";
        }

    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>

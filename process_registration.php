<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $idNumber = $_POST['idNumber'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $postalCode = $_POST['postalCode'];
    $date = $_POST['date'];
    $signature = $_POST['signature'];

    // Certificate upload handling
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = basename($_FILES["grama_sevak_certificate"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only specific file formats
    $allowedTypes = array("pdf", "jpg", "jpeg", "png");
    if (!in_array($fileType, $allowedTypes)) {
        die("Error: Only PDF, JPG, JPEG, and PNG files are allowed.");
    }

    if (move_uploaded_file($_FILES["grama_sevak_certificate"]["tmp_name"], $targetFilePath)) {
        $sql = "INSERT INTO employees (name, address, idNumber, phone, email, province, district, postalCode, date, signature, grama_sevak_certificate) 
                VALUES ('$name', '$address', '$idNumber', '$phone', '$email', '$province', '$district', '$postalCode', '$date', '$signature', '$fileName')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Employee Registered Successfully!'); window.location.href='employee.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        die("Error uploading certificate. Please try again.");
    }
}
?>

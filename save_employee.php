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

    $sql = "INSERT INTO employees (name, address, idNumber, phone, email, province, district, postalCode, date, signature)
            VALUES ('$name', '$address', '$idNumber', '$phone', '$email', '$province', '$district', '$postalCode', '$date', '$signature')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Employee registered successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}
$conn->close();
?>

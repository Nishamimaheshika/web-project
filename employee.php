<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('11.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container {
            margin-bottom: 20px;
        }
        button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }
        button:hover {
            background-color: #34495e;
        }
        .form-container {
            display: none;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
    <script>
        function showSection(sectionId) {
            document.getElementById("registrationForm").style.display = "none";
            document.getElementById("registeredEmployees").style.display = "none";
            document.getElementById(sectionId).style.display = "block";
        }
    </script>
</head>
<body>

    <div class="container">
        <div class="button-container">
            <button onclick="showSection('registrationForm')">Employee Registration</button>
            <button onclick="showSection('registeredEmployees')">Registered Employees</button>
        </div>
    </div>

    <!-- Employee Registration Form -->
    <div class="form-container" id="registrationForm">
        <h2>Employee Registration</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Address:</label>
            <textarea name="address" required></textarea>
            <label>ID Number:</label>
            <input type="text" name="idNumber" required>
            <label>Phone:</label>
            <input type="tel" name="phone" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Province:</label>
            <input type="text" name="province" required>
            <label>District:</label>
            <input type="text" name="district" required>
            <label>Postal Code:</label>
            <input type="text" name="postalCode" required>
            <label>Grama Sevaka Certificate:</label>
            <input type="file" name="grama_sevaka_certificate" accept=".pdf, .jpg, .jpeg, .png" required>
            <label>Date:</label>
            <input type="date" name="date" required>
            <label>Signature (Enter Name Only):</label>
            <input type="text" name="signature" required>
            
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <!-- Registered Employees -->
   <div class="form-container" id="registeredEmployees">
        <h2>Registered Employees</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Province</th>
                    <th>Certificate</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT name, idNumber, phone, email, province, grama_sevak_certificate FROM employees";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['idNumber']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['province']}</td>
                                <td><a href='uploads/{$row['grama_sevak_certificate']}' target='_blank'>View</a></td>
                              </tr>";
                    }
                } else {
                    //echo "<tr><td colspan='6'>No employees registered yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
if (isset($_POST['submit'])) {
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

    // File Upload Handling
    $targetDir = "uploads/";
    $fileName = basename($_FILES["grama_sevak_certificate"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    
    if (move_uploaded_file($_FILES["grama_sevak_certificate"]["tmp_name"], $targetFilePath)) {
        $sql = "INSERT INTO employees (name, address, idNumber, phone, email, province, district, postalCode, date, signature, grama_sevak_certificate)
                VALUES ('$name', '$address', '$idNumber', '$phone', '$email', '$province', '$district', '$postalCode', '$date', '$signature', '$fileName')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Employee registered successfully!'); window.location.href='';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Error uploading certificate. Please try again.');</script>";
    }
}
?>

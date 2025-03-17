<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elder_care_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employees for dropdown
$employees = [];
$employee_query = "SELECT employee_id, name, phone FROM employees";
$result = $conn->query($employee_query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiving Service Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('11.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        button[type="submit"] {
            background-color: #007bff;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Caregiving Service Request</h2>
        <form id="careForm" enctype="multipart/form-data" action="save_care_request.php" method="POST" onsubmit="return handleSubmit(event)">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="2" required></textarea>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time Limit (Hours):</label>
            <input type="number" id="time" name="time" min="1" max="10" value="1" required onchange="calculateTotal()">

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="adultName">Adult's Name:</label>
            <input type="text" id="adultName" name="adultName" required>

            <label for="status">Adult's Current Status:</label>
            <textarea id="status" name="status" rows="2" required></textarea>

            <label for="healthReport">Attach Adult's Health Report (PDF, JPG, PNG):</label>
            <input type="file" id="healthReport" name="healthReport" accept=".pdf, .jpg, .png" required>

            <label for="patientType">Select Patient Type:</label>
            <select id="patientType" name="patientType" required onchange="calculateTotal()">
                <option value="">-- Select Patient Type --</option>
                <option value="2000">Bedridden Patients - LKR 2000/hour</option>
                <option value="1000">Middle-aged Patients - LKR 1000/hour</option>
                <option value="1500">General Medical Conditions - LKR 1500/hour</option>
            </select>

            <label for="employee">Employee Selection:</label>
            <select id="employee" name="employee" required>
                <option value="">-- Select Employee --</option>
                <?php foreach ($employees as $employee): ?>
                    <option value="<?php echo $employee['employee_id']; ?>" data-phone="<?php echo $employee['phone']; ?>">
                        <?php echo $employee['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="total">Total Amount (Rs.):</label>
            <input type="text" id="total" name="total" readonly>

            <button type="button" onclick="calculateTotal()">Calculate Amount</button>
            <button type="submit">Submit & Transfer</button>
        </form>
    </div>

    <script>
        function calculateTotal() {
            const time = document.getElementById('time').value;
            const patientType = document.getElementById('patientType').value;

            if (!patientType) {
                alert("Please select a patient type!");
                return;
            }

            const totalAmount = time * patientType;
            document.getElementById('total').value = `Rs. ${totalAmount}`;
            alert('Payment calculated successfully!');
        }

        function handleSubmit(event) {
            event.preventDefault(); // Prevent form from submitting normally

            // Simulating form submission delay
            setTimeout(() => {
                alert("Form submitted successfully! Redirecting to home page...");
                window.location.href = "index.php"; // Redirect to home page
            }, 1000);
        }
    </script>

</body>
</html>

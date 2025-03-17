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

// Fetch total patients
$patientQuery = "SELECT COUNT(*) AS total_patients FROM care_requests";
$patientResult = $conn->query($patientQuery);
$totalPatients = ($patientResult->num_rows > 0) ? $patientResult->fetch_assoc()['total_patients'] : 0;

// Fetch total employees
$employeeQuery = "SELECT COUNT(*) AS total_employees FROM employees";
$employeeResult = $conn->query($employeeQuery);
$totalEmployees = ($employeeResult->num_rows > 0) ? $employeeResult->fetch_assoc()['total_employees'] : 0;

// Fetch total earnings
$earningQuery = "SELECT SUM(total_amount) AS total_earnings FROM care_requests";
$earningResult = $conn->query($earningQuery);
$totalEarnings = ($earningResult->num_rows > 0) ? $earningResult->fetch_assoc()['total_earnings'] : 0;

// Fetch recent caregiving requests
$requestQuery = "SELECT name, date, time, total_amount FROM care_requests ORDER BY id DESC LIMIT 5";
$requestResult = $conn->query($requestQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            width: 80%;
            margin: 20px auto;
            text-align: center;
        }
        .dashboard-title {
            background: #2c3e50;
            color: white;
            padding: 15px;
            font-size: 24px;
            text-align: center;
            border-radius: 5px;
        }
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .stat-box {
            background: white;
            padding: 20px;
            width: 30%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .stat-box h2 {
            color: #333;
        }
        .recent-requests {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-title">Elder Care Service - Admin Dashboard</div>

    <div class="stats-container">
        <div class="stat-box">
            <h2>👴 Total Patients</h2>
            <p><?php echo $totalPatients; ?></p>
        </div>
        <div class="stat-box">
            <h2>👨‍⚕️ Total Employees</h2>
            <p><?php echo $totalEmployees; ?></p>
        </div>
        <div class="stat-box">
            <h2>💰 Total Earnings (Rs.)</h2>
            <p><?php echo number_format($totalEarnings, 2); ?></p>
        </div>
    </div>

    <div class="recent-requests">
        <h2>📋 Recent Care Requests</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Hours</th>
                <th>Total (Rs.)</th>
            </tr>
            <?php while ($row = $requestResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><?php echo number_format($row['total_amount'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>

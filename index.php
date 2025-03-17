<?php
session_start();

$host = 'localhost'; // Change if needed
$dbname = 'elder_care';
$user = 'root'; // Change if needed
$pass = ''; // Change if needed

$conn = new mysqli($host, $user, $pass, $dbname);


if ($_SERVER['elder_care'] == 'POST' && isset($_POST['login'])) {
    $role = trim($_POST['role']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
   
            $error = "Invalid password.";
            }
        else {
            $error = "User not found or incorrect role selected.";
        }
     else {
    }

<!DOCTYPE html>
<html>
<head>
    <title>Login & Signup - Elder Care System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('11.jpg') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p style='color:red;"; ?>
        <form method="post" action="">
             <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="employee">Employee</option>
            </select>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>
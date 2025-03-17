<?php
session_start();
require 'db_connect.php'; // Ensure this file is included

$error = ""; // Initialize error message

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $role = trim($_POST['role']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password) && !empty($role)) {
        
        // Special case: Admin login (Fixed username & password)
        if ($role === "admin") {
            if ($username === "attygala" && $password === "12345") {
                $_SESSION['user_id'] = 1;
                $_SESSION['role'] = "admin";
                $_SESSION['username'] = "attygala";

                header("Location: home.html"); // Redirect to admin dashboard
                exit();
            } else {
                $error = "Invalid admin credentials.";
            }
        } else {
            // Regular user and employee login
            $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? AND role = ?");
            if ($stmt) {
                $stmt->bind_param("ss", $username, $role);
                $stmt->execute();
                $stmt->store_result();
                
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $hashed_password);
                    $stmt->fetch();
                    
                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION['user_id'] = $id;
                        $_SESSION['role'] = $role;
                        $_SESSION['username'] = $username;
                        
                        header("Location: home.html"); // Redirect to home/dashboard
                        exit();
                    } else {
                        $error = "Invalid password.";
                    }
                } else {
                    $error = "User not found or incorrect role selected.";
                }
                $stmt->close();
            } else {
                $error = "Database query failed.";
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Elder Care System</title>
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
        input, select {
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
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
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

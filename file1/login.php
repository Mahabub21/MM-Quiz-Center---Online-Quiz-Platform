<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Please fill out both fields!";
        exit();
    }

    // Check in the 'users' table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: ../user/user-dashboard.php");
        exit();
    }

    // Check in the 'admins' table
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: ../admin/admin.php");
        exit();
    }

    // Invalid credentials
    echo "Invalid email or password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.5s ease-in-out;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            opacity: 0;
            animation: fadeIn 0.5s ease-in forwards;
        }

        label {
            margin: 10px 0 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="email"], input[type="password"] {
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            font-size: 14px;
        }

        /* Fade in animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <form method="POST" action="login.php">
            <label for="email">
                <i class="fas fa-envelope"></i> Email:
            </label>
            <input type="email" id="email" name="email" required>

            <label for="password">
                <i class="fas fa-lock"></i> Password:
            </label>
            <input type="password" id="password" name="password" required>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <p><a href="../forgot_password/forgot_password.php"><i class="fas fa-key"></i> Forgot Password?</a></p>
        <p>Don't have an account? <a href="register-login.php"><i class="fas fa-user-plus"></i> Register here</a></p>
        <p><a href="../index.php"><i class="fas fa-home"></i> HOME PAGE</a></p>
    </div>
</body>
</html>

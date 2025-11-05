<?php
session_start();
include 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') {
        // User Registration Logic
        $name = $_POST['name'];
        $class = $_POST['class'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];
        $birthday = $_POST['birthday'];
        $address = $_POST['address'];

        // Validate password length
        if (strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters long.'); window.history.back();</script>";
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->rowCount() > 0) {
                echo "<script>alert('Email already exists!'); window.history.back();</script>";
                exit();
            }

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (name, class, email, password, phone_number, birthday, address) 
                                    VALUES (:name, :class, :email, :password, :phone_number, :birthday, :address)");
            $stmt->execute([
                'name' => $name,
                'class' => $class,
                'email' => $email,
                'password' => $hashed_password,
                'phone_number' => $phone_number,
                'birthday' => $birthday,
                'address' => $address
            ]);

            echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }

    if ($action === 'login') {
        // Login Logic
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Check if user exists in the `admins` table
            $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                echo "<script>alert('Admin login successful!'); window.location.href = 'admin-dashboard.php';</script>";
                exit();
            }

            // Check if user exists in the `users` table
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                echo "<script>alert('User login successful!'); window.location.href = 'user-dashboard.php';</script>";
                exit();
            }

            // Invalid credentials
            echo "<script>alert('Invalid email or password!'); window.history.back();</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }
}
?>

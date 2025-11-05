<?php
include '../file/config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token
    $stmt = $conn->prepare("SELECT * FROM users WHERE password_reset_token = :token AND token_expiry > NOW()");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Update password in database
            $stmt = $conn->prepare("UPDATE users SET password = :password, password_reset_token = NULL, token_expiry = NULL WHERE id = :id");
            $stmt->execute(['password' => $new_password, 'id' => $user['id']]);

            echo "Your password has been reset successfully!";
            exit();
        }
    } else {
        echo "Invalid or expired token!";
        exit();
    }
} else {
    echo "No token provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>

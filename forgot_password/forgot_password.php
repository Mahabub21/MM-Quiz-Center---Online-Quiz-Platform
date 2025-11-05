<?php
include '../file1/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer library
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a reset token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store token in the database
        $stmt = $conn->prepare("UPDATE users SET password_reset_token = :token, token_expiry = :expiry WHERE email = :email");
        $stmt->execute(['token' => $token, 'expiry' => $expiry, 'email' => $email]);

        // Create a password reset link
        $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Your Gmail address
            $mail->Password = 'your_email_password'; // Your Gmail password or app password
            $mail->SMTPSecure = 'tls'; // Secure connection
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Your Website'); // Sender's email and name
            $mail->addAddress($email); // Recipient's email
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click the link to reset your password: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="forgot_password.php">
        <label for="email">Enter your email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Send Reset Link</button>
        <button type="submit"><a href="../file1/login.php">GO THE LOGIN</a></button>
    </form>
</body>
</html>




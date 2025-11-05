<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <link rel="stylesheet" href="style3.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
<div class="container">
    <h1>You have been logged out</h1>
    <p>Choose an option below:</p>
    <button onclick="window.location.href='login.php'">
        <i class="fas fa-sign-in-alt"></i> Login Again
    </button>
    <br>
    <br>
    
    <button onclick="window.location.href='../index.php';">
        <i class="fas fa-home"></i> Go to Home Page
    </button>
</div>

</body>
</html>

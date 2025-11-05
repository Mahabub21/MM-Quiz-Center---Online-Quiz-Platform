<?php
include '../file1/config.php';

session_start(); // Start session to retrieve user ID
$feedback_text = "";
$feedback_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $feedback_text = trim($_POST['feedback_text']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (empty($feedback_text)) {
        $feedback_error = "Feedback cannot be empty.";
    } else {
        try {
            $insert_query = "INSERT INTO feedback (user_id, feedback_text) VALUES (:user_id, :feedback_text)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':feedback_text', $feedback_text, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "<p class='success-message'>Feedback submitted successfully.</p>";
            } else {
                echo "<p class='error-message'>Error submitting feedback.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .container { margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .home-button { text-decoration: none; background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; }
        .home-button:hover { background-color: #0056b3; }
        .form-container { background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px; }
        button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error-message { color: #dc3545; }
        .success-message { color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Submit Your Feedback</h1>
            <a href="user-dashboard.php" class="home-button"><i class="fas fa-home"></i> Home</a>
        </div>

        <div class="form-container">
            <form method="POST" action="user_feedback.php">
                <label for="feedback_text">Your Feedback:</label>
                <textarea name="feedback_text" id="feedback_text" rows="5" placeholder="Enter your feedback here..."><?= htmlspecialchars($feedback_text); ?></textarea>
                <?php if ($feedback_error): ?>
                    <p class="error-message"><?= $feedback_error; ?></p>
                <?php endif; ?>
                <button type="submit" name="submit_feedback">Submit Feedback</button>
            </form>
        </div>
    </div>
</body>
</html>

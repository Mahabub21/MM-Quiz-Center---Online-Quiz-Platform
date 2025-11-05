<?php
// Include the database configuration
include '../file1/config.php';

try {
    // Check if the feedback table has the user_id column
    $check_column_query = "SHOW COLUMNS FROM feedback LIKE 'user_id'";
    $column_stmt = $conn->prepare($check_column_query);
    $column_stmt->execute();
    $has_user_id = $column_stmt->rowCount() > 0;

    // Prepare the SQL query based on the presence of the user_id column
    if ($has_user_id) {
        $feedback_query = "
            SELECT f.id, 
                   COALESCE(u.name, 'Guest') AS user_name, 
                   f.feedback_text, 
                   f.feedback_date 
            FROM feedback f
            LEFT JOIN users u ON f.user_id = u.id
            WHERE f.is_deleted = 0
            ORDER BY f.feedback_date DESC";
    } else {
        $feedback_query = "
            SELECT f.id, 
                   'Guest' AS user_name, 
                   f.feedback_text, 
                   f.feedback_date 
            FROM feedback f
            WHERE f.is_deleted = 0
            ORDER BY f.feedback_date DESC";
    }

    // Execute the query
    $stmt = $conn->prepare($feedback_query);
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $feedbacks = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .container { margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .home-button { text-decoration: none; background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; }
        .home-button:hover { background-color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #343a40; color: #fff; }
        .btn { padding: 8px 15px; border: none; cursor: pointer; }
        .btn-delete { background-color: #dc3545; color: white; }
        .btn:hover { opacity: 0.9; }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Feedback Management</h1>
            <a href="admin.php" class="home-button"><i class="fas fa-home"></i> Home</a>
        </div>

        <?php
        // Display success or error message if set in the URL query parameters
        if (isset($_GET['status'])) {
            if ($_GET['status'] === 'success') {
                echo "<p class='success-message'>Feedback deleted successfully.</p>";
            } elseif ($_GET['status'] === 'error') {
                echo "<p class='error-message'>Failed to delete feedback.</p>";
            }
        }
        ?>

        <?php if (!empty($feedbacks)): ?>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?= htmlspecialchars($feedback['user_name']); ?></td>
                            <td><?= htmlspecialchars($feedback['feedback_text']); ?></td>
                            <td><?= htmlspecialchars($feedback['feedback_date']); ?></td>
                            <td>
                                <!-- Delete Feedback Form -->
                                <form method="POST" action="delete_feedback.php">
                                    <input type="hidden" name="feedback_id" value="<?= $feedback['id']; ?>">
                                    <button class="btn btn-delete" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No feedback available.</p>
        <?php endif; ?>
    </div>
</body>
</html>

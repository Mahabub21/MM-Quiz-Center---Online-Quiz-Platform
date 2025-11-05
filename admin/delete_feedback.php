<?php
// Include the database configuration
include '../file1/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_id'])) {
    // Sanitize the input to ensure it's an integer
    $feedback_id = intval($_POST['feedback_id']);

    try {
        // Prepare the DELETE SQL statement to permanently remove the feedback
        $delete_query = "DELETE FROM feedback WHERE id = :feedback_id";
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect with success message
            header('Location:feedback.php?status=success');
            exit();
        } else {
            // Redirect with error message
            header('Location:feedback.php?status=error');
            exit();
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle invalid requests
    echo "Invalid request.";
}
?>

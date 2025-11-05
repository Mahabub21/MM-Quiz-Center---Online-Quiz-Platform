<?php
include '../file1/config.php'; // Include the database connection file

// Check if the `id` parameter is provided in the URL
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Convert the ID to an integer for security

    try {
        // Begin a transaction to ensure atomicity
        $conn->beginTransaction();

        // Delete related records from the exam_results table
        $deleteResultsQuery = "DELETE FROM exam_results WHERE user_id = :id";
        $deleteResultsStmt = $conn->prepare($deleteResultsQuery);
        $deleteResultsStmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $deleteResultsStmt->execute();

        // Now delete the user
        $deleteQuery = "DELETE FROM users WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if ($deleteStmt->execute()) {
            // Commit the transaction
            $conn->commit();
            // Redirect back with a success message
            header("Location: user_management.php?message=User+deleted+successfully");
        } else {
            // If the user deletion fails, rollback the transaction
            $conn->rollBack();
            header("Location: user_management.php?message=Error+deleting+user");
        }
    } catch (PDOException $e) {
        // If an error occurs, rollback the transaction
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back if no ID is provided
    header("Location: user_management.php?message=No+user+ID+provided");
}
exit();
?>

<?php
include '../file1/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = $_POST['feedback_id'];
    $admin_reply = $_POST['admin_reply'];

    try {
        // Update the feedback with the admin's reply
        $query = "UPDATE feedback SET admin_reply = :admin_reply WHERE id = :feedback_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':admin_reply', $admin_reply, PDO::PARAM_STR);
        $stmt->bindParam(':feedback_id', $feedback_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the feedback management page
        header('Location: feedback.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

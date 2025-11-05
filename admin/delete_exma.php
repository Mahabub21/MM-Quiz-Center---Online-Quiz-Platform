<?php
include '../file1/config.php'; // Correct path to include your database connection file

// Check if the category ID is passed
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Delete the category from the database
    try {
        $delete_query = "DELETE FROM categories WHERE category_id = :category_id";
        $stmt = $conn->prepare($delete_query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the categories page
        header("Location: admin_categories.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back to categories page if no ID is passed
    header("Location: admin_categories.php");
    exit();
}

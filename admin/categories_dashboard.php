<?php
include '../file1/config.php'; // Correct path

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $exam_name = $_POST['exam_name'] ?? ''; // New exam name input
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    if (!empty($name) && !empty($description) && !empty($exam_name)) {
        try {
            // Insert into categories table
            $query = "INSERT INTO categories (name, description, created_at, updated_at) 
                      VALUES (:name, :description, :created_at, :updated_at)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':updated_at', $updated_at);
            $stmt->execute();

            // Get the last inserted category id
            $category_id = $conn->lastInsertId();

            // Insert into exams table
            $exam_query = "INSERT INTO exams (exam_id, exam_name, description, is_active) 
                           VALUES (:exam_id, :exam_name, :description, 1)";
            $exam_stmt = $conn->prepare($exam_query);
            $exam_stmt->bindParam(':exam_id', $category_id);  // Category ID as exam_id
            $exam_stmt->bindParam(':exam_name', $exam_name);  // Exam name
            $exam_stmt->bindParam(':description', $description); // Exam description
            $exam_stmt->execute();

            $message = "Category and Exam added successfully!";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category and Exam Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, button {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            font-size: 14px;
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Category and Exam Management</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, 'Error') !== false ? 'error' : '' ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Category Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <label for="exam_name">Exam Name:</label>
            <input type="text" id="exam_name" name="exam_name" required>

            <button type="submit">Add Category and Exam</button>

           
        </form>
    </div>
</body>
</html>
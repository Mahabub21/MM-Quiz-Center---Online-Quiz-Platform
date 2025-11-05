<?php
include '../file1/config.php'; // Correct path to include your database connection file

// Fetch categories data
try {
    $subjects_query = "SELECT category_id AS subject_id, name AS subject_name FROM categories";
    $subjects_stmt = $conn->prepare($subjects_query);
    $subjects_stmt->execute();
    $subjects = $subjects_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Management - Categories</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        /* Navigation Bar */
        nav {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h1 {
            margin: 0;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Categories Table */
        .table-container {
            margin: 20px auto;
            width: 90%;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #343a40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .upload-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .upload-button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <nav>
        <h1>Exam Management - Categories</h1>
        <ul>
            <li><a href="admin.php">Back to Dashboard</a></li>
        </ul>
    </nav>

    <div class="table-container">
        <h2>Categories List</h2>
        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($subjects) > 0): ?>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?= htmlspecialchars($subject['subject_id']); ?></td>
                            <td><?= htmlspecialchars($subject['subject_name']); ?></td>
                            <td>
                                <a href="admin_upload.php" class="upload-button">Upload</a>
                                <a href="delete_category.php?id=<?= $subject['subject_id'] ?>" class="delete-button" 
                                   onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Quiz App. All Rights Reserved.</p>
    </footer>

</body>
</html>

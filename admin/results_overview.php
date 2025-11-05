<?php
include '../file1/config.php'; // Include your database connection

$search_query = ''; // Initialize search query
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    try {
        // Query to search by user name or result ID
        $results_query = "
            SELECT 
                r.result_id AS result_id, 
                u.name AS user_name, 
                e.exam_name AS exam_title, 
                r.score, 
                r.date_taken 
            FROM exam_results r
            JOIN users u ON r.user_id = u.id
            JOIN exams e ON r.exam_id = e.exam_id
            WHERE u.name LIKE :search OR r.result_id LIKE :search
            ORDER BY r.date_taken DESC";
        
        $stmt = $conn->prepare($results_query);
        $stmt->execute(['search' => "%$search_query%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    try {
        // Fetch all results if no search query
        $results_query = "
            SELECT 
                r.result_id AS result_id, 
                u.name AS user_name, 
                e.exam_name AS exam_title, 
                r.score, 
                r.date_taken 
            FROM exam_results r
            JOIN users u ON r.user_id = u.id
            JOIN exams e ON r.exam_id = e.exam_id
            ORDER BY r.date_taken DESC";

        $stmt = $conn->prepare($results_query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results Overview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .container {
            margin: 20px auto;
            width: 90%;
            text-align: center;
        }

        .search-bar {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        .search-bar button {
            width: 20%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        .back-button {
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Results Overview</h1>
        <a href="admin.php" class="back-button">Back to Dashboard</a>

        <!-- Search Bar -->
        <form class="search-bar" method="GET" action="">
            <input type="text" name="search" placeholder="Search by User Name or Result ID..." value="<?= htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Result ID</th>
                    <th>User Name</th>
                    <th>Exam Title</th>
                    <th>Score</th>
                    <th>Date Taken</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= htmlspecialchars($result['result_id']); ?></td>
                            <td><?= htmlspecialchars($result['user_name']); ?></td>
                            <td><?= htmlspecialchars($result['exam_title']); ?></td>
                            <td><?= htmlspecialchars($result['score']); ?></td>
                            <td><?= htmlspecialchars($result['date_taken']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No results found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

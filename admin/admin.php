<?php
include '../file1/config.php'; // Correct path
// Include the database connection file
// Count feedback
try {
    $feedback_count_query = "SELECT COUNT(*) AS total_feedbacks FROM feedback WHERE is_deleted = 0";
    $feedback_stmt = $conn->prepare($feedback_count_query);
    $feedback_stmt->execute();
    $feedback_count = $feedback_stmt->fetch(PDO::FETCH_ASSOC)['total_feedbacks'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch data counts
try {
    // Count registered users
    $user_count_query = "SELECT COUNT(*) AS total_users FROM users";
    $user_stmt = $conn->prepare($user_count_query);
    $user_stmt->execute();
    $user_count = $user_stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    // Count categories
    $category_count_query = "SELECT COUNT(*) AS total_categories FROM categories";
    $category_stmt = $conn->prepare($category_count_query);
    $category_stmt->execute();
    $category_count = $category_stmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

    // Count exams
    $exam_count_query = "SELECT COUNT(*) AS total_exams FROM exams";
    $exam_stmt = $conn->prepare($exam_count_query);
    $exam_stmt->execute();
    $exam_count = $exam_stmt->fetch(PDO::FETCH_ASSOC)['total_exams'];

    // Count results
    $results_count_query = "SELECT COUNT(*) AS total_results FROM exam_results";
    $results_stmt = $conn->prepare($results_count_query);
    $results_stmt->execute();
    $results_count = $results_stmt->fetch(PDO::FETCH_ASSOC)['total_results'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App - Admin Dashboard</title>
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

        /* Logout Button */
        .logout-button {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .logout-button:hover {
            background-color: #bd2130;
        }

        /* Dashboard Content */
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
            gap: 20px;
        }

        .dashboard-card {
            flex: 1 1 calc(33.33% - 20px);
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card i {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .dashboard-card h3 {
            margin: 10px 0;
            font-size: 20px;
        }

        .dashboard-card p {
            color: #6c757d;
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

        @media (max-width: 768px) {
            .dashboard-card {
                flex: 1 1 calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .dashboard-card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

    <nav>
        <h1>MM Quiz Center - Admin Dashboard</h1>
        <ul>
        <li><a href="../admin/user_management.php">User Management</a></li>
        <li><a href="../admin/categories_dashboard.php">Category Management</a></li>
        <li><a href="../admin/exam.php">Exam Management</a></li>
        <li><a href="results_overview.php">Results Overview</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        </ul>
        <button class="logout-button"><a href="logout.php">Logout</a></button>
    </nav>

    <div class="dashboard-container">
        <!-- User Management -->
        <div class="dashboard-card" id="user-management">
            <i class="fas fa-users"></i>
           <a href="../admin/user_management.php"><h3>User Management</h3></a>
            <p>View, edit, or delete registered users.</p>
            <p><strong>Total Users: </strong><?= $user_count; ?></p>
        </div>

        <!-- Category Management -->
        <div class="dashboard-card" id="category-management">
            <i class="fas fa-layer-group"></i>
           <a href="../admin/categories_dashboard.php" ><h3>Category Management</h3></a>
            <p>Add, modify, or delete categories for exams.</p>
            <p><strong>Total Categories: </strong><?= $category_count; ?></p>
        </div>

        <!-- Exam Management -->
        <div class="dashboard-card" id="exam-management">
            <i class="fas fa-file-alt"></i>
            <a href="../admin/exam.php"><h3>Exam Management</h3></a>
            
            
            <p>Create, edit, or delete exams and questions.</p>
            <p><strong>Total Exams: </strong><?= $exam_count; ?></p>
        </div>

        <!-- Results Overview -->
        <div class="dashboard-card" id="results-overview">
            <i class="fas fa-chart-bar"></i>
            
             <a href="results_overview.php"><h3>Results Overview</h3></a>
            <p>Summarize and review results across all users.</p>
            <p><strong>Total Results: </strong><?= $results_count; ?></p>
        </div>
<!-- Feedback Management -->
<div class="dashboard-card" id="feedback-management">
    <i class="fas fa-comments"></i>
    <a href="feedback.php"><h3>Feedback Management</h3></a>
    <p>Manage and respond to user feedback.</p>
    <p><strong>Total Feedbacks: </strong><?= $feedback_count; ?></p>
</div>

</div>

    </div>

    <footer>
        <p>&copy; 2024 MM Quiz Center. All Rights Reserved.</p>
    </footer>

</body>
</html>

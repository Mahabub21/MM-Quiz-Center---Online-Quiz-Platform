<?php
session_start();

// Database connection settings
$host = 'localhost';  // Your database host
$username = 'root';   // Your database username
$password = '';       // Your database password
$database = 'platform'; // Your database name

// Create a connection to the database using mysqli
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Query to get exam results for the logged-in user
$query = "SELECT er.*, e.exam_name FROM exam_results er
          JOIN exams e ON er.exam_id = e.exam_id
          WHERE er.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any results were returned
if ($result->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Exam Results</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Your Exam Results</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Exam Name</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Date Taken</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        // Check if 'status' key exists before printing
                        $status = isset($row['status']) ? htmlspecialchars($row['status']) : 'N/A'; // Default to 'N/A' if not found

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['exam_name']) . "</td>"; // Display exam name
                        echo "<td>" . htmlspecialchars($row['score']) . "</td>"; // Display score
                        echo "<td>" . $status . "</td>"; // Display status
                        echo "<td>" . htmlspecialchars($row['date_taken']) . "</td>"; // Display date taken
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="user-dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>No exam results found.</p>";
}

$conn->close();
?>

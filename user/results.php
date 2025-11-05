<?php
// Database configuration
$host = 'localhost';
$db = 'platform';
$user = 'root';
$pass = '';

// Establish database connection using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user details from the database (including profile photo)
$query = "SELECT name, profile_photo FROM users WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the user's data
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user's exam results
$query = "
    SELECT exams.exam_name, exam_results.score, exam_results.status 
    FROM exam_results
    JOIN exams ON exam_results.exam_id = exams.exam_id
    WHERE exam_results.user_id = :user_id
";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the exam results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Exam Results</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="profile">
        <!-- Display profile picture dynamically -->
        <?php if (!empty($user['profile_photo'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Picture"> <!-- Display uploaded profile picture -->
        <?php else: ?>
            <img src="../file1/default-profile-picture.jpg" alt="Profile Picture"> <!-- Default image if none uploaded -->
        <?php endif; ?>
        <p> <?php echo htmlspecialchars($user['name']); ?></p> <!-- Display user's name -->
    </div>
    <nav>
        <ul>
            <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="results.php"><i class="fas fa-chart-bar"></i> View Results</a></li>
            <li><a href="feedback.php"><i class="fas fa-comment-dots"></i> Feedback</a></li>
        </ul>
    </nav>
    <form method="POST" action="../file1/logout.php">
        <button type="submit" class="logout-button">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>

<!-- Main Content -->
<main class="content">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Your Exam Results</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($results)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Score</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['exam_name']); ?></td>
                                <td><?php echo htmlspecialchars($result['score']); ?></td>
                                <td><?php echo htmlspecialchars($result['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No exam results available.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>

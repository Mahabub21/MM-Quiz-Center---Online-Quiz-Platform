<?php
$host = 'localhost';
$db = 'platform';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../file1/login.php');
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$profilePhoto = !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'uploads/default-photo.png';

// Fetch exams
$exams_query = "SELECT * FROM exams WHERE is_active = 1";
$stmt = $conn->prepare($exams_query);
$stmt->execute();
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch exam results
$results_query = "SELECT r.*, e.exam_name FROM exam_results r JOIN exams e ON r.exam_id = e.exam_id WHERE r.user_id = ?";
$stmt = $conn->prepare($results_query);
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile">
                <!-- Display Profile Photo -->
                <img src="<?php echo $profilePhoto; ?>" alt="Profile Picture">
                <p><?php echo htmlspecialchars($user['name']); ?></p>
            </div>
            <nav>
                <ul>
                    <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="results.php"><i class="fas fa-chart-bar"></i> View Results</a></li>
                    <li><a href="user_feedback.php"><i class="fas fa-comment-dots"></i> Feedback</a></li>

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
            <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>

            <!-- Available Exams -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Available Exams</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($exams)): ?>
                        <ul class="list-group">
                            <?php foreach ($exams as $exam): ?>
                                <li class="list-group-item">
                                    <strong><?php echo htmlspecialchars($exam['exam_name']); ?></strong>
                                    <p><?php echo htmlspecialchars($exam['description']); ?></p>
                                    <a href="take_exam.php?exam_id=<?php echo $exam['exam_id']; ?>" class="btn btn-primary">Take Exam</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No active exams available.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Exam Results -->
           
        </main>
    </div>
</body>
</html>

</html>

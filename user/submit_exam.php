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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['exam_id'])) {
    $exam_id = $_POST['exam_id'];
    $user_id = $_SESSION['user_id'];

    // Get all questions for the exam
    $questions_query = "SELECT * FROM questions WHERE exam_id = ?";
    $stmt = $conn->prepare($questions_query);
    $stmt->bind_param('i', $exam_id);
    $stmt->execute();
    $questions_result = $stmt->get_result();

    $score = 0;
    $total_score = $questions_result->num_rows;

    while ($question = $questions_result->fetch_assoc()) {
        $question_id = $question['question_id'];
        $correct_answer = $question['correct_answer'];
        
        // Check the user's answer
        if (isset($_POST['answer_' . $question_id]) && $_POST['answer_' . $question_id] == $correct_answer) {
            $score++;
        }
    }

    // Insert the exam result
    $date_taken = date('Y-m-d H:i:s');
    $result_query = "INSERT INTO exam_results (user_id, exam_id, score, date_taken) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($result_query);
    $stmt->bind_param('iiis', $user_id, $exam_id, $score, $date_taken);
    $stmt->execute();

    // Update the status to 'Submitted' after exam completion
    $update_status_query = "UPDATE exam_results SET status = 'Submitted' WHERE user_id = ? AND exam_id = ?";
    $stmt = $conn->prepare($update_status_query);
    $stmt->bind_param('ii', $user_id, $exam_id);
    $stmt->execute();

    // Redirect or show result
    header('Location: exam_result.php?exam_id=' . $exam_id);
    exit;
} else {
    echo "Invalid exam submission.";
}
?>

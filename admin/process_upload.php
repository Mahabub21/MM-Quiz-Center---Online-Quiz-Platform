<?php
// Database connection
$host = '127.0.0.1';
$db = 'platform';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data exists
if (isset($_POST['exam_id'], $_POST['questions']) && is_array($_POST['questions'])) {
    $exam_id = (int)$_POST['exam_id'];
    $questions = $_POST['questions'];

    $errors = [];
    $success_count = 0;

    foreach ($questions as $index => $question) {
        // Validate inputs
        $question_text = $conn->real_escape_string($question['question_text']);
        $option_a = $conn->real_escape_string($question['option_a']);
        $option_b = $conn->real_escape_string($question['option_b']);
        $option_c = $conn->real_escape_string($question['option_c']);
        $option_d = $conn->real_escape_string($question['option_d']);
        $correct_answer = $conn->real_escape_string($question['correct_answer']);
        $time_limit = (int)$question['time_limit'];

        // Insert question
        $insert_sql = "INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer, time_limit)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("issssssi", $exam_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_answer, $time_limit);

        if ($stmt->execute()) {
            $success_count++;
        } else {
            $errors[] = "Error in question #" . ($index + 1) . ": " . $stmt->error;
        }
    }

    // Feedback
    echo "$success_count question(s) uploaded successfully.";
    if (!empty($errors)) {
        echo " Some errors occurred:<br>" . implode("<br>", $errors);
    }
} else {
    echo "Error: Exam ID or questions not provided.";
}

$conn->close();
?>

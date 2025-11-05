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

// Fetch available exams
$exam_query = "SELECT exam_id, exam_name FROM exams";
$exam_result = $conn->query($exam_query);

// Check if exams exist
if ($exam_result->num_rows == 0) {
    die("No exams available. Please add an exam first.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Upload Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .back-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .back-link i {
            margin-right: 8px;
        }
        .back-link:hover {
            color: #4CAF50;
        }
    </style>
</head>
<body>

<a href="exam.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    
    <h1>Upload Questions</h1>
    <form method="POST" action="process_upload.php">
        <!-- Exam Selection -->
        <label for="exam_id">Select Exam</label>
        <select name="exam_id" id="exam_id" required>
            <option value="">Select Exam</option>
            <?php
            while ($row = $exam_result->fetch_assoc()) {
                echo "<option value='" . $row['exam_id'] . "'>" . $row['exam_name'] . "</option>";
            }
            ?>
        </select>

        <!-- Questions -->
        <div id="question-container">
            <div class="question">
                <label for="question_text">Question</label>
                <textarea name="questions[0][question_text]" rows="3" required></textarea>

                <label for="option_a">Option A</label>
                <input type="text" name="questions[0][option_a]" required>

                <label for="option_b">Option B</label>
                <input type="text" name="questions[0][option_b]" required>

                <label for="option_c">Option C</label>
                <input type="text" name="questions[0][option_c]" required>

                <label for="option_d">Option D</label>
                <input type="text" name="questions[0][option_d]" required>

                <label for="correct_answer">Correct Answer</label>
                <select name="questions[0][correct_answer]" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>

                <label for="time_limit">Time Limit (in seconds)</label>
                <input type="number" name="questions[0][time_limit]" required>
            </div>
        </div>

        <!-- Add More Questions Button -->
        <button type="button" id="add-question">Add Another Question</button>

        <!-- Submit Button -->
        <button type="submit">Upload Questions</button>
    </form>

    <script>
        let questionIndex = 1;
        document.getElementById('add-question').addEventListener('click', () => {
            const container = document.getElementById('question-container');
            const questionHTML = `
                <div class="question">
                    <label for="question_text">Question</label>
                    <textarea name="questions[${questionIndex}][question_text]" rows="3" required></textarea>

                    <label for="option_a">Option A</label>
                    <input type="text" name="questions[${questionIndex}][option_a]" required>

                    <label for="option_b">Option B</label>
                    <input type="text" name="questions[${questionIndex}][option_b]" required>

                    <label for="option_c">Option C</label>
                    <input type="text" name="questions[${questionIndex}][option_c]" required>

                    <label for="option_d">Option D</label>
                    <input type="text" name="questions[${questionIndex}][option_d]" required>

                    <label for="correct_answer">Correct Answer</label>
                    <select name="questions[${questionIndex}][correct_answer]" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>

                    <label for="time_limit">Time Limit (in seconds)</label>
                    <input type="number" name="questions[${questionIndex}][time_limit]" required>
                </div>`;
            container.insertAdjacentHTML('beforeend', questionHTML);
            questionIndex++;
        });
    </script>
</body>
</html>


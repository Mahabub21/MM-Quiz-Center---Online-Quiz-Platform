<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam</title>

    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<style>/* General body and layout styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Container for the entire exam page */
.container {
    width: 80%;
    max-width: 900px;
    margin: 50px auto;
    background-color: white;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

/* Header styling */
h2 {
    font-size: 24px;
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

/* Question styling */
div {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

p {
    font-size: 18px;
    color: #333;
}

/* Radio buttons and labels styling */
input[type="radio"] {
    margin-right: 10px;
    margin-left: 10px;
}

label {
    font-size: 16px;
    color: #555;
}

/* Timer styling */
#timer {
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    color: #ff5722;
    margin-top: 20px;
}

/* Submit button styling */
#submit_button {
    display: block;
    width: 100%;
    padding: 15px;
    background-color: #4CAF50;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 30px;
}

#submit_button:hover {
    background-color: #45a049;
}

#submit_button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 15px;
    }

    h2 {
        font-size: 20px;
    }

    p {
        font-size: 16px;
    }

    #timer {
        font-size: 18px;
    }

    #submit_button {
        font-size: 16px;
    }
}
</style>
<body>
    <div class="container">
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

            // Get the exam ID from URL or POST request
            if (isset($_GET['exam_id'])) {
                $exam_id = $_GET['exam_id'];

                // Get all questions related to the exam, including time_limit from questions table
                $questions_query = "SELECT * FROM questions WHERE exam_id = ?";
                $stmt = $conn->prepare($questions_query);
                $stmt->bind_param('i', $exam_id);
                $stmt->execute();
                $questions_result = $stmt->get_result();

                // Check if questions exist
                if ($questions_result->num_rows > 0) {
                    // Fetch the first question to get the time_limit (assuming all questions have the same time limit)
                    $first_question = $questions_result->fetch_assoc();
                    $time_limit = $first_question['time_limit']; // Time limit in seconds
                    
                    // Move back to the beginning of the result set
                    $questions_result->data_seek(0);
                    ?>

                    <h2>Take Exam: <?php echo htmlspecialchars($exam_id); ?></h2>
                    <form method="POST" action="submit_exam.php" id="exam_form">
                        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">

                    <?php
                    // Output all questions
                    while ($question = $questions_result->fetch_assoc()) {
                        ?>
                        <div>
                            <p><?php echo htmlspecialchars($question['question_text']); ?></p>
                            <input type="radio" name="answer_<?php echo $question['question_id']; ?>" value="A" id="A_<?php echo $question['question_id']; ?>">
                            <label for="A_<?php echo $question['question_id']; ?>"><?php echo htmlspecialchars($question['option_a']); ?></label><br>

                            <input type="radio" name="answer_<?php echo $question['question_id']; ?>" value="B" id="B_<?php echo $question['question_id']; ?>">
                            <label for="B_<?php echo $question['question_id']; ?>"><?php echo htmlspecialchars($question['option_b']); ?></label><br>

                            <input type="radio" name="answer_<?php echo $question['question_id']; ?>" value="C" id="C_<?php echo $question['question_id']; ?>">
                            <label for="C_<?php echo $question['question_id']; ?>"><?php echo htmlspecialchars($question['option_c']); ?></label><br>

                            <input type="radio" name="answer_<?php echo $question['question_id']; ?>" value="D" id="D_<?php echo $question['question_id']; ?>">
                            <label for="D_<?php echo $question['question_id']; ?>"><?php echo htmlspecialchars($question['option_d']); ?></label><br>
                        </div>
                        <?php
                    }
                    ?>
                    <button type="submit" id="submit_button">Submit Exam</button>
                    </form>

                    <div id="timer"></div>

                    <script>
                        // Set the countdown timer
                        var timeLimit = <?php echo $time_limit; ?>; // time in seconds
                        var timerDisplay = document.getElementById("timer");
                        var submitButton = document.getElementById("submit_button");

                        function updateTimer() {
                            var minutes = Math.floor(timeLimit / 60);
                            var seconds = timeLimit % 60;
                            timerDisplay.innerHTML = "Time Remaining: " + minutes + "m " + seconds + "s";

                            if (timeLimit <= 0) {
                                // Time's up: submit the form automatically
                                document.getElementById("exam_form").submit();
                            } else {
                                timeLimit--;
                            }
                        }

                        // Update the timer every second
                        setInterval(updateTimer, 1000);

                        // Disable the submit button after the form is automatically submitted
                        function disableSubmitButton() {
                            submitButton.disabled = true;
                            submitButton.innerHTML = "Time's Up! Submitting Exam...";
                        }
                    </script>

                    <?php
                } else {
                    echo "No questions found for this exam.";
                }
            } else {
                echo "Invalid exam ID.";
            }
        ?>
    </div>
</body>
</html>

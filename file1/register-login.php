
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration & Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <section class="form-section">
            <H1>MM Quiz Center </H1><H3>YOUR WITS, LEARN WITH FUN!</H3> 
            <h2>Student Registration</h2>
            <form id="registrationForm" method="post" action="process.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="class">Class:</label>
                <input type="text" id="class" name="class" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" required>
                
                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" required onchange="displaySelectedDate()">
                
                <p id="birthdayDisplay"></p>
                
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3" required></textarea>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                    
                <button type="submit" name="action" value="register">Register</button>
            </form>
        </section>
    </div>

    <script>
        function displaySelectedDate() {
            const birthdayInput = document.getElementById('birthday').value;
            const displayElement = document.getElementById('birthdayDisplay');

            if (birthdayInput) {
                const date = new Date(birthdayInput);
                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                displayElement.textContent = `Selected Birthday: ${formattedDate}`;
            } else {
                displayElement.textContent = '';
            }
        }
    </script>
</body>
</html>

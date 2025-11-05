<?php
// Database configuration
$host = 'localhost';
$db = 'platform';
$user = 'root';
$pass = '';

// Establish database connection
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

$userId = $_SESSION['user_id'];

// Fetch user data
$query = "SELECT name, email, phone_number, birthday, address, profile_photo FROM users WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}

// Fallback for profile photo
$profilePhoto = !empty($user['profile_photo']) ? htmlspecialchars($user['profile_photo']) : 'uploads/default-photo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <div>
        <img src="<?php echo $profilePhoto; ?>?t=<?php echo time(); ?>" alt="Profile Photo" width="150">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
        <p><strong>Birthday:</strong> <?php echo htmlspecialchars($user['birthday']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
    </div>
    <div>
        <!-- Buttons with Font Awesome Icons -->
        <button onclick="window.location.href='edit_profile.php'">
            <i class="fas fa-user-edit"></i> Edit Profile
        </button>
        <button onclick="window.location.href='user-dashboard.php'">
            <i class="fas fa-tachometer-alt"></i> Go to Dashboard
        </button>
    </div>
</body>
<style>

/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
    flex-direction: column;
}

h1 {
    color: #34495e;
    margin-top: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

button {
    background-color: #34495e;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 5px 0;
    cursor: pointer;
    font-size: 14px;
    border-radius: 5px;
}

button:hover {
    background-color: whitesmoke;
    color: black;
}

input[type="text"],
input[type="email"],
input[type="date"],
textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    height: 100px;
    resize: none;
}

form {
    max-width: 600px;
    width: 100%;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Profile Image Styling */
img {
    display: block;
    margin: 0 auto 20px;
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 4px solid #34495e;
}

/* Profile Page Buttons */
.profile-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.profile-buttons button {
    flex: 1;
    padding: 10px;
}

.profile-data p {
    margin: 10px 0;
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 15px;
    }

    button {
        width: 100%;
    }

    .profile-buttons {
        flex-direction: column;
    }
}
</style>
</html>

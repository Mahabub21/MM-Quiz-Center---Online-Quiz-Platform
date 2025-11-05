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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch submitted data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone_number'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $address = $_POST['address'] ?? '';

    // Handle file upload
    $targetFilePath = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
        }
        $fileName = basename($_FILES['profile_picture']['name']);
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $targetFilePath = $uploadDir . uniqid() . '_' . $fileName;

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($fileTmpPath);

        if (in_array($fileType, $allowedTypes)) {
            if (!move_uploaded_file($fileTmpPath, $targetFilePath)) {
                echo "Failed to upload the profile picture.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            exit;
        }
    }

    // Update the database
    if ($targetFilePath) {
        $query = "UPDATE users SET name = :name, email = :email, phone_number = :phone, birthday = :birthday, address = :address, profile_photo = :profile_photo WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':birthday' => $birthday,
            ':address' => $address,
            ':profile_photo' => $targetFilePath,
            ':id' => $userId
        ]);
    } else {
        $query = "UPDATE users SET name = :name, email = :email, phone_number = :phone, birthday = :birthday, address = :address WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':birthday' => $birthday,
            ':address' => $address,
            ':id' => $userId
        ]);
    }

    // Redirect to profile page
    header("Location: profile.php");
    exit;
}

// Fetch current user data to pre-fill the form
$query = "SELECT name, email, phone_number, birthday, address, profile_photo FROM users WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            color: #34495e;
            text-align: center;
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
        input[type="file"],
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
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img {
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #34495e;
        }
    </style>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label><i class="fas fa-user"></i> Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        
        <label><i class="fas fa-envelope"></i> Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <label><i class="fas fa-phone"></i> Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
        
        <label><i class="fas fa-birthday-cake"></i> Birthday:</label>
        <input type="date" name="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" required>
        
        <label><i class="fas fa-map-marker-alt"></i> Address:</label>
        <textarea name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        
        <label><i class="fas fa-image"></i> Profile Picture:</label>
        <input type="file" name="profile_picture" accept="image/*">
        
        <?php if (!empty($user['profile_photo'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Picture" width="150">
        <?php endif; ?>
        
        <button type="submit"><i class="fas fa-save"></i> Update Profile</button>
        <button type="button" onclick="window.location.href='profile.php'"><i class="fas fa-times"></i> Cancel</button>
    </form>
</body>
</html>

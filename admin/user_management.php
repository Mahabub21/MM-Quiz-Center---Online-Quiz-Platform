<?php
include '../file1/config.php'; // Include the database connection file

// Fetch users from the database
try {
    $users_query = "SELECT * FROM users";
    $users_stmt = $conn->prepare($users_query);
    $users_stmt->execute();
    $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        nav {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav h1 {
            margin: 0;
            font-size: 24px;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .table-container {
            margin: 20px auto;
            width: 90%;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .action-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 5px;
        }
        .action-button:hover {
            background-color: #218838;
        }
        .delete-button {
            background-color: #dc3545;
        }
        .delete-button:hover {
            background-color: #bd2130;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .message {
            text-align: center;
            color: black;
            padding: 10px;
            margin: 10px 20px;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <h1>User Management</h1>
        <ul>
            <li><a href="admin.php">Back to Dashboard</a></li>
        </ul>
    </nav>

    <div class="table-container">
        <h2>Users List</h2>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['message'])): ?>
            <div class="message"><?= htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Email</th>
                    <th>Birthday</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['name']); ?></td>
                            <td><?= htmlspecialchars($user['class']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= htmlspecialchars($user['birthday']); ?></td>
                            <td><?= htmlspecialchars($user['phone_number']); ?></td>
                            <td><?= htmlspecialchars($user['address']); ?></td>
                            <td>
                                <a href="delete.php?id=<?= urlencode($user['id']); ?>" 
                                   class="action-button delete-button" 
                                   onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Quiz App. All Rights Reserved.</p>
    </footer>
</body>
</html>

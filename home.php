<?php
require_once 'auth.php';

// Check if user is logged in, redirect to login if not
redirectIfNotLoggedIn('login.php');

// Get current user data
$user = getCurrentUser();

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($user['name']); ?>!</h1>
    
    <h2>Your Details:</h2>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>User Type:</strong> <?php echo htmlspecialchars($user['user_type']); ?></p>
    
    <br>
    <a href="?action=logout">
        <button>Logout</button>
    </a>
</body>
</html>
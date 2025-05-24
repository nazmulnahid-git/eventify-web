<?php
require_once 'auth.php';

// Redirect if user is already logged in
redirectIfLoggedIn();

$errors = [];
$success = '';

// Store form data to repopulate on error
$full_name = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];

    // Process registration
    $result = registerAndLogin($full_name, $email, $password, $confirm);
    
    if ($result['success']) {
        // Registration successful - redirect to home page
        header("Location: home.php");
        exit();
    } else {
        // Registration failed - store errors
        $errors = $result['errors'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Eventify</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!--NavBar-->
<?php require_once 'navbar.php'; ?>

<!-- Registration Form -->
<div class="d-flex justify-content-center align-items-center bg-light vh-100 mx-3">
  <div class="card shadow-sm p-5" style="width: 100%; max-width: 500px;">
    <h1 class="text-center mb-4">Create an Account</h1>
    
    <?php if (isset($errors['general'])): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($errors['general']); ?>
      </div>
    <?php endif; ?>
    
    <form id="registerForm" action="register.php" method="POST">
      <!-- onsubmit="return validateRegister()"> -->

      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" 
               name="full_name" 
               class="form-control" 
               id="registerName" 
               placeholder="Enter your full name" 
               value="<?php echo htmlspecialchars($full_name); ?>"
               required>
        <?php if (isset($errors['full_name'])): ?>
          <div class="error-text"><?php echo htmlspecialchars($errors['full_name']); ?></div>
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" 
               name="email" 
               class="form-control" 
               id="registerEmail" 
               placeholder="Enter your email" 
               value="<?php echo htmlspecialchars($email); ?>"
               required>
        <?php if (isset($errors['email'])): ?>
          <div class="error-text"><?php echo htmlspecialchars($errors['email']); ?></div>
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" 
               name="password" 
               class="form-control" 
               id="registerPassword" 
               placeholder="Create a password" 
               required>
        <?php if (isset($errors['password'])): ?>
          <div class="error-text"><?php echo htmlspecialchars($errors['password']); ?></div>
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="password" 
               name="confirmPassword" 
               class="form-control" 
               id="registerConfirmPassword" 
               placeholder="Confirm your password" 
               required>
        <?php if (isset($errors['confirmPassword'])): ?>
          <div class="error-text"><?php echo htmlspecialchars($errors['confirmPassword']); ?></div>
        <?php endif; ?>
      </div>
      
      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    
    <div class="text-center mt-3">
      <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-5 mt-auto">
  <div class="container">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 Eventify. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
<?php
require_once 'auth.php';

// Redirect if user is already logged in
redirectIfLoggedIn();

$errors = [];
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  // Basic validation
  if (empty($email)) {
    $errors['email'] = "Email is required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Please enter a valid email address.";
  }

  if (empty($password)) {
    $errors['password'] = "Password is required.";
  }

  // If no validation errors, attempt login
  if (empty($errors)) {
    $result = loginUser($email, $password);

    if ($result['success']) {
      $currentUser = getCurrentUser();
      if ($currentUser['user_type'] === 'OWNER' || $currentUser['user_type'] === 'ADMIN') {
        // Redirect to admin dashboard if user is not a regular user
        header("Location: dashboard.php");
        exit();
      } else {
        // Redirect to home page for regular users
        header("Location: home.php");
        exit();
      }
    } else {
      // Login failed
      $errors['general'] = $result['error'];
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Eventify</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <!--NavBar-->
  <?php require_once 'navbar.php'; ?>

  <!-- Login Form -->
  <div class="d-flex justify-content-center align-items-center bg-light vh-100 mx-3">
    <div class="card shadow-sm p-5" style="width: 100%; max-width: 500px;">
      <h1 class="text-center mb-4">Login</h1>

      <?php if (isset($errors['general'])): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($errors['general']); ?>
        </div>
      <?php endif; ?>

      <form id="loginForm" action="login.php" method="POST">
        <div class="mb-3">
          <label for="loginEmail" class="form-label">Email Address</label>
          <input type="email"
            name="email"
            class="form-control"
            id="loginEmail"
            placeholder="Enter your email"
            value="<?php echo htmlspecialchars($email); ?>"
            required>
          <?php if (isset($errors['email'])): ?>
            <div class="error-text"><?php echo htmlspecialchars($errors['email']); ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="loginPassword" class="form-label">Password</label>
          <input type="password"
            name="password"
            class="form-control"
            id="loginPassword"
            placeholder="Enter your password"
            required>
          <?php if (isset($errors['password'])): ?>
            <div class="error-text"><?php echo htmlspecialchars($errors['password']); ?></div>
          <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      <div class="text-center mt-3">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
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
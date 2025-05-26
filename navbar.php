<?php
require_once 'auth.php';
// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  logoutUser();
  header("Location: login.php");
  exit();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Eventify</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= ($currentPage === 'index.php') ? 'active' : '' ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($currentPage === 'about.php') ? 'active' : '' ?>" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($currentPage === 'services.php') ? 'active' : '' ?>" href="services.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>" href="contact.php">Contact</a>
        </li>

        <?php require_once 'auth.php';
        if (isLoggedIn()): ?>
          <li class="nav-item">
            <a class="nav-link <?= ($currentPage === 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
          </li>
        <?php endif; ?>

        <?php require_once 'auth.php';
        if (isLoggedIn() && $_SESSION['user_type'] === 'USER'): ?>
          <li class="nav-item">
            <a href="?action=logout" class="nav-link btn btn-outline-primary ms-2 px-3">
              <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
          </li>
        <?php endif; ?>


        <?php require_once 'auth.php';
        if (!isLoggedIn()): ?>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-primary ms-2 px-3" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-white ms-2 px-3" href="register.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<?php
require_once 'auth.php';

// Check if user is logged in, redirect to login if not
redirectIfNotLoggedIn('login.php');
redirectIfNotAdminOrOnwer('home.php');

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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="layout.css">
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <title>Dashboard</title>
</head>

<body>
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image d-flex align-items-center justify-content-center" style="font-weight: bold; font-size: 20px;">
          E
        </span>
        <div class="text logo-text">
          <span class="name">Dashboard</span>
          <span class="profession">Admin Panel</span>
        </div>
      </div>
      <i class='bx bx-chevron-right toggle'></i>
    </header>


    <div class="menu-bar">
      <ul class="menu-links p-0">
        <li class="nav-link">
          <a href="?page=dashboard">
            <i class='bx bx-home-alt icon'></i>
            <span class="text nav-text">Dashboard</span>
          </a>
        </li>
        <!-- <li class="nav-link">
          <a href="?page=analytics">
            <i class='bx bx-pie-chart-alt icon'></i>
            <span class="text nav-text">Analytics</span>
          </a>
        </li> -->
        <li class="nav-link">
          <a href="?page=services">
            <i class='bx bx-briefcase icon'></i>
            <span class="text nav-text">Services</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="?page=events">
            <i class='bx bx-calendar-event icon'></i>
            <span class="text nav-text">Events</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="?page=categories">
            <i class='bx bx-category icon'></i>
            <span class="text nav-text">Categories</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="?page=settings">
            <i class='bx bx-cog icon'></i>
            <span class="text nav-text">Settings</span>
          </a>
        </li>
      </ul>

      <div class="bottom-content">
        <li>
          <a href="?action=logout">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>
      </div>
    </div>
  </nav>

  <section class="home">
    <?php
    $page = $_GET['page'] ?? 'dashboard'; // default to dashboard
    ?>
    <?php if ($page === 'dashboard') : ?>
      <div class="text text-dark fw-bold">Dashboard</div>
      <?php require_once './pages/dashboard.php'; ?>

    <?php elseif ($page === 'services') : ?>
      <div class="text text-dark fw-bold">Services</div>
      <?php require_once './pages/services.php'; ?>
    <?php elseif ($page === 'analytics') : ?>
      <div class="text text-dark fw-bold">Analytics</div>
      <?php require_once './pages/analytics.php';
      ?>
    <?php elseif ($page === 'events') : ?>
      <div class="text text-dark fw-bold">Events</div>
      <?php require_once './pages/events.php'; ?>
    <?php elseif ($page === 'categories') : ?>
      <div class="text text-dark fw-bold">Categories</div>
      <?php require_once './pages/categories.php'; ?>
    <?php elseif ($page === 'settings') : ?>
      <div class="text text-dark fw-bold">Settings</div>
      <?php require_once './pages/settings.php'; ?>
    <?php endif; ?>
  </section>

  <script>
    const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");

    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
  </script>
  <script src="script.js"></script>
</body>

</html>
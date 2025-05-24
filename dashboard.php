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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="layout.css">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <title>Dashboard</title>
</head>

<body>
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <img src="logo.png" alt="Logo">
        </span>
        <div class="text logo-text">
          <span class="name">Dashboard</span>
          <span class="profession">Admin Panel</span>
        </div>
      </div>
      <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
      <ul class="menu-links">
        <li class="nav-link">
          <a href="#">
            <i class='bx bx-home-alt icon'></i>
            <span class="text nav-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="#">
            <i class='bx bx-pie-chart-alt icon'></i>
            <span class="text nav-text">Analytics</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="#">
            <i class='bx bx-briefcase icon'></i>
            <span class="text nav-text">Services</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="#">
            <i class='bx bx-calendar-event icon'></i>
            <span class="text nav-text">Events</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="#">
            <i class='bx bx-category icon'></i>
            <span class="text nav-text">Categories</span>
          </a>
        </li>
        <li class="nav-link">
          <a href="#">
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
    <div class="text">Dashboard</div>
    <div style="text-align: center; margin: 0 auto; width: 500px;">
      <h1>Welcome to the Dashboard</h1>
    </div>
  </section>

  <script>
    const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");

    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    });
  </script>
</body>

</html>
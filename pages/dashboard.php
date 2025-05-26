<?php
require_once 'auth.php';
redirectIfNotLoggedIn();

$userId = $_SESSION['user_id'];
$currentUser = getCurrentUser($userId);

// Function to get dashboard statistics
function getDashboardStats()
{
  global $conn;

  $stats = [
    'total_events' => 0,
    'total_services' => 0,
    'total_orders' => 0,
    'total_revenue' => 0
  ];

  // Total events
  $stmt = $conn->prepare("SELECT COUNT(id) as count FROM events");
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stats['total_events'] = $row['count'] ?? 0;
  $stmt->close();

  // Total services
  $stmt = $conn->prepare("SELECT COUNT(id) as count FROM services");
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stats['total_services'] = $row['count'] ?? 0;
  $stmt->close();

  // Total orders
  $stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders");
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stats['total_orders'] = $row['count'] ?? 0;
  $stmt->close();

  // Total revenue from completed orders
  $stmt = $conn->prepare("
      SELECT SUM(price) as revenue 
      FROM orders 
      WHERE status = 'completed' 
      AND (service_id IS NOT NULL OR event_id IS NOT NULL)
  ");
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stats['total_revenue'] = $row['revenue'] ?? 0;
  $stmt->close();

  return $stats;
}

// Fetch data
$dashboardStats = getDashboardStats();
?>


<div class="container-fluid px-4 py-4">
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div> </div>
        <div class="d-flex align-items-center">
          <span class="badge bg-success px-3 py-2 fs-6">
            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
            Online
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Dashboard Statistics Overview -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-lg">
        <div class="card-header bg-light border-bottom py-3">
          <div class="d-flex align-items-center">
            <i class="bi bi-graph-up me-2" style="color: #ff6b6b;"></i>
            <h5 class="mb-0 text-dark fw-semibold">Business Overview</h5>
          </div>
        </div>
        <div class="card-body p-4">
          <div class="row">
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(255, 107, 107, 0.1);">
                <i class="bi bi-calendar-event display-4" style="color: #ff6b6b;"></i>
                <h3 class="mt-3 mb-1 fw-bold" style="color: #ff6b6b;"><?= number_format($dashboardStats['total_events']) ?></h3>
                <h6 class="mb-0 text-muted">Total Events</h6>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(0, 123, 255, 0.1);">
                <i class="bi bi-gear display-4 text-primary"></i>
                <h3 class="mt-3 mb-1 fw-bold text-primary"><?= number_format($dashboardStats['total_services']) ?></h3>
                <h6 class="mb-0 text-muted">Total Services</h6>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(40, 167, 69, 0.1);">
                <i class="bi bi-bag-check display-4 text-success"></i>
                <h3 class="mt-3 mb-1 fw-bold text-success"><?= number_format($dashboardStats['total_orders']) ?></h3>
                <h6 class="mb-0 text-muted">Total Orders</h6>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(255, 193, 7, 0.1);">
                <i class="bi bi-currency-dollar display-4 text-warning"></i>
                <h3 class="mt-3 mb-1 fw-bold text-warning">$<?= number_format($dashboardStats['total_revenue'], 2) ?></h3>
                <h6 class="mb-0 text-muted">Total Revenue</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
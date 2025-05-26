<?php
require_once 'auth.php';

// Check if user is logged in, redirect to login if not
redirectIfNotLoggedIn();

// Get current user data
$user = getCurrentUser();

// Redirect admin/owner users to admin dashboard
if ($user && in_array($user['user_type'], ['ADMIN', 'OWNER'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
    header("Location: login.php");
    exit();
}

// Sample data for user dashboard (in a real app, this would come from database)
$userEvents = [
    [
        'id' => 1,
        'title' => 'Summer Wedding',
        'date' => '2025-07-15',
        'time' => '16:00',
        'location' => 'Garden Venue, NYC',
        'status' => 'confirmed',
        'type' => 'Wedding'
    ],
    [
        'id' => 2,
        'title' => 'Birthday Celebration',
        'date' => '2025-06-20',
        'time' => '19:00',
        'location' => 'Private Hall, Brooklyn',
        'status' => 'pending',
        'type' => 'Birthday'
    ],
    [
        'id' => 3,
        'title' => 'Corporate Meeting',
        'date' => '2025-05-30',
        'time' => '10:00',
        'location' => 'Business Center, Manhattan',
        'status' => 'completed',
        'type' => 'Corporate'
    ]
];

$upcomingEvents = array_filter($userEvents, function($event) {
    return strtotime($event['date']) >= strtotime('today') && $event['status'] !== 'completed';
});

$recentActivity = [
    'Event "Summer Wedding" confirmed by our team',
    'Payment received for "Birthday Celebration"',
    'New message from event coordinator',
    'Event proposal sent for review'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Eventify</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <?php $currentPage = 'home.php'; require_once 'navbar.php'; ?>

    <!-- Dashboard Header -->
    <div class="bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-1">Welcome back, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>
                    <p class="mb-0 opacity-75">Manage your events and stay updated with your bookings</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-4">
          <div class="row">
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(255, 107, 107, 0.1);">
                <i class="bi bi-calendar-event display-4" style="color: #ff6b6b;"></i>
                <h3 class="mt-3 mb-1 fw-bold" style="color: #ff6b6b;"><?= number_format($dashboardStats['total_events']) ?></h3>
                <h6 class="mb-0 text-muted">Upcoming Events</h6>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(0, 123, 255, 0.1);">
                <i class="bi bi-gear display-4 text-primary"></i>
                <h3 class="mt-3 mb-1 fw-bold text-primary"><?= number_format($dashboardStats['total_services']) ?></h3>
                <h6 class="mb-0 text-muted">Pending Services</h6>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(40, 167, 69, 0.1);">
                <i class="bi bi-bag-check display-4 text-success"></i>
                <h3 class="mt-3 mb-1 fw-bold text-success"><?= number_format($dashboardStats['total_orders']) ?></h3>
                <h6 class="mb-0 text-muted">Completed</h6>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="text-center p-4 rounded h-100" style="background-color: rgba(255, 193, 7, 0.1);">
                <i class="bi bi-currency-dollar display-4 text-warning"></i>
                <h3 class="mt-3 mb-1 fw-bold text-warning">$<?= number_format($dashboardStats['total_revenue'], 2) ?></h3>
                <h6 class="mb-0 text-muted">Total Orders</h6>
              </div>
            </div>
          </div>
        </div>

    <!-- Dashboard Content -->

        <div class="row p-5">
            <!-- Upcoming Events -->
            <div class="col-lg-8 mb-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold">My Upcoming Events</h4>
                            <a href="book_event.php" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Book New Event
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($userEvents)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No events yet</h5>
                                <p class="text-muted">Start planning your first event with us!</p>
                                <a href="contact.php" class="btn btn-primary">Get Started</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($userEvents as $event): ?>
                                <div class="border-bottom px-4 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-start">
                                                <div class="event-date-small me-3 text-center">
                                                    <div class="month"><?php echo date('M', strtotime($event['date'])); ?></div>
                                                    <div class="day"><?php echo date('d', strtotime($event['date'])); ?></div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($event['title']); ?></h6>
                                                    <p class="text-muted mb-1 small">
                                                        <i class="fas fa-clock me-1"></i><?php echo date('g:i A', strtotime($event['time'])); ?>
                                                        <span class="mx-2">•</span>
                                                        <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($event['location']); ?>
                                                    </p>
                                                    <span class="badge bg-<?php 
                                                        echo $event['status'] === 'confirmed' ? 'success' : 
                                                             ($event['status'] === 'pending' ? 'warning' : 'secondary'); 
                                                    ?> text-capitalize"><?php echo $event['status']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- User Profile Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center">
                        <div class="avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                            <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                        </div>
                        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($user['full_name']); ?></h5>
                        <p class="text-muted mb-3"><?php echo htmlspecialchars($user['email']); ?></p>
                        <button class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-user-edit me-1"></i>Edit Profile
                        </button>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h6 class="mb-0 fw-bold">Recent Activity</h6>
                    </div>
                    <div class="card-body p-0">
                        <?php foreach ($recentActivity as $index => $activity): ?>
                            <div class="px-3 py-2 <?php echo $index < count($recentActivity) - 1 ? 'border-bottom' : ''; ?>">
                                <div class="d-flex align-items-start">
                                    <div class="activity-dot bg-primary rounded-circle me-2 mt-2" style="width: 8px; height: 8px;"></div>
                                    <div>
                                        <p class="mb-0 small"><?php echo htmlspecialchars($activity); ?></p>
                                        <small class="text-muted"><?php echo rand(1, 5); ?> hours ago</small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h6 class="mb-0 fw-bold">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            
                            <a href="book_services.php" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>View Services
                            </a>
                            <a href="contact.php" class="btn btn-outline-primary">
                                <i class="fas fa-headset me-2"></i>Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <?php require_once 'footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

    <style>
        .stat-icon {
            width: 60px;
            height: 60px;
        }
        
        .event-date-small {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 8px;
            min-width: 50px;
        }
        
        .event-date-small .month {
            display: block;
            font-size: 10px;
            font-weight: bold;
            color: #6c757d;
            text-transform: uppercase;
        }
        
        .event-date-small .day {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #495057;
            line-height: 1;
        }
        
        .avatar {
            width: 80px;
            height: 80px;
            font-size: 32px;
        }
        
        .activity-dot {
            width: 8px;
            height: 8px;
            flex-shrink: 0;
        }
        
        .card {
            transition: transform 0.2s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .btn-group-sm .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.775rem;
            }
        }
    </style>
</body>
</html>
<?php
require_once  'auth.php';
redirectIfNotLoggedIn();


$userId = $_SESSION['user_id'];
$message = '';
$error = '';

// Update user profile
function updateUserProfile($userId, $fullName, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param("ssi", $fullName, $email, $userId);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

// Update user password
function updateUserPassword($userId, $newPassword) {
    global $conn;
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

// Verify current password
function verifyCurrentPassword($userId, $currentPassword) {
    global $conn;
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    return $user ? password_verify($currentPassword, $user['password']) : false;
}

$currentUser = getCurrentUser($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $fullName = trim($_POST['fullName'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($fullName === '') {
            $error = 'Full name cannot be empty.';
        } elseif ($email === '') {
            $error = 'Email cannot be empty.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            // Check if email already exists for another user
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $error = 'Email address is already in use by another user.';
            } else {
                $result = updateUserProfile($userId, $fullName, $email);
                if ($result['success']) {
                    $message = 'Profile updated successfully.';
                    $_SESSION['user_name'] = $fullName; // Update session if you store name there
                    $currentUser = getCurrentUser($userId); // Refresh user data
                } else {
                    $error = 'Failed to update profile: ' . $result['error'];
                }
            }
        }
    } elseif ($action === 'change_password') {
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if ($currentPassword === '') {
            $error = 'Current password is required.';
        } elseif ($newPassword === '') {
            $error = 'New password cannot be empty.';
        } elseif (strlen($newPassword) < 6) {
            $error = 'New password must be at least 6 characters long.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'New password and confirmation do not match.';
        } elseif (!verifyCurrentPassword($userId, $currentPassword)) {
            $error = 'Current password is incorrect.';
        } else {
            $result = updateUserPassword($userId, $newPassword);
            if ($result['success']) {
                $message = 'Password changed successfully.';
            } else {
                $error = 'Failed to change password: ' . $result['error'];
            }
        }
    }
}
?>

<div class="container-fluid px-4 py-4">
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0 text-dark fw-bold">Account Settings</h2>
                    <p class="text-muted mb-0">Manage your profile and security settings</p>
                </div>
                <!-- <div class="d-flex align-items-center">
                    <span class="badge bg-primary px-3 py-2 fs-6">
                        <?= htmlspecialchars($currentUser['user_type']) ?>
                    </span>
                </div> -->
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header py-3" style="background-color: #ff6b6b;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-fill me-2 fs-5 text-white"></i>
                        <h5 class="mb-0 text-white">Profile Information</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="mb-3">
                            <label for="fullName" class="form-label fw-semibold text-dark">
                                <i class="bi bi-person me-2" style="color: #ff6b6b;"></i>Full Name
                            </label>
                            <input type="text" id="fullName" name="fullName" 
                                class="form-control form-control-lg border-2" 
                                value="<?= htmlspecialchars($currentUser['full_name']) ?>" 
                                placeholder="Enter your full name..." required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-dark">
                                <i class="bi bi-envelope me-2" style="color: #ff6b6b;"></i>Email Address
                            </label>
                            <input type="email" id="email" name="email" 
                                class="form-control form-control-lg border-2" 
                                value="<?= htmlspecialchars($currentUser['email']) ?>" 
                                placeholder="Enter your email..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-calendar me-2" style="color: #ff6b6b;"></i>Account Created
                            </label>
                            <p class="form-control-plaintext text-muted">
                                <?= date('F j, Y g:i A', strtotime($currentUser['created_at'])) ?>
                            </p>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-clock me-2" style="color: #ff6b6b;"></i>Last Updated
                            </label>
                            <p class="form-control-plaintext text-muted">
                                <?= date('F j, Y g:i A', strtotime($currentUser['updated_at'])) ?>
                            </p>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background-color: #ff6b6b; border-color: #ff6b6b; color: white;">
                                <i class="bi bi-check-circle me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Settings Card -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header py-3" style="background-color: #ff6b6b;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-lock-fill me-2 fs-5 text-white"></i>
                        <h5 class="mb-0 text-white">Security Settings</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="change_password">
                        
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label fw-semibold text-dark">
                                <i class="bi bi-lock me-2" style="color: #ff6b6b;"></i>Current Password
                            </label>
                            <input type="password" id="currentPassword" name="currentPassword" 
                                class="form-control form-control-lg border-2" 
                                placeholder="Enter current password..." required>
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label fw-semibold text-dark">
                                <i class="bi bi-key me-2" style="color: #ff6b6b;"></i>New Password
                            </label>
                            <input type="password" id="newPassword" name="newPassword" 
                                class="form-control form-control-lg border-2" 
                                placeholder="Enter new password..." required>
                            <div class="form-text">Password must be at least 6 characters long.</div>
                        </div>

                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label fw-semibold text-dark">
                                <i class="bi bi-key-fill me-2" style="color: #ff6b6b;"></i>Confirm New Password
                            </label>
                            <input type="password" id="confirmPassword" name="confirmPassword" 
                                class="form-control form-control-lg border-2" 
                                placeholder="Confirm new password..." required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background-color: #dc3545; border-color: #dc3545; color: white;">
                                <i class="bi bi-shield-check me-2"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Information Overview -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-light border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle me-2" style="color: #ff6b6b;"></i>
                        <h5 class="mb-0 text-dark fw-semibold">Account Overview</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 rounded" style="background-color: rgba(255, 107, 107, 0.1);">
                                <i class="bi bi-person-badge display-6" style="color: #ff6b6b;"></i>
                                <h6 class="mt-2 mb-1">User ID</h6>
                                <p class="mb-0 text-muted">#<?= $currentUser['id'] ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 rounded" style="background-color: rgba(0, 123, 255, 0.1);">
                                <i class="bi bi-shield display-6 text-primary"></i>
                                <h6 class="mt-2 mb-1">Account Type</h6>
                                <span class="badge bg-primary px-2 py-1"><?= htmlspecialchars($currentUser['user_type']) ?></span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 rounded" style="background-color: rgba(40, 167, 69, 0.1);">
                                <i class="bi bi-calendar-check display-6 text-success"></i>
                                <h6 class="mt-2 mb-1">Member Since</h6>
                                <p class="mb-0 text-muted"><?= date('M Y', strtotime($currentUser['created_at'])) ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 rounded" style="background-color: rgba(255, 193, 7, 0.1);">
                                <i class="bi bi-clock-history display-6 text-warning"></i>
                                <h6 class="mt-2 mb-1">Last Activity</h6>
                                <p class="mb-0 text-muted"><?= date('M j', strtotime($currentUser['updated_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
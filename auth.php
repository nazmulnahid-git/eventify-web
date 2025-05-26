<?php
require_once 'config.php';

/**
 * Validate full name
 */
function validateFullName($full_name)
{
    if (empty($full_name)) {
        return "Full name is required.";
    }
    if (strlen($full_name) < 2) {
        return "Full name must be at least 2 characters long.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $full_name)) {
        return "Full name can only contain letters and spaces.";
    }
    return null;
}

/**
 * Validate email address
 */
function validateEmail($email)
{
    if (empty($email)) {
        return "Email is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid email address.";
    }
    return null;
}

/**
 * Validate password
 */
function validatePassword($password)
{
    if (empty($password)) {
        return "Password is required.";
    }
    if (strlen($password) < 6) {
        return "Password must be at least 6 characters long.";
    }
    // if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/", $password)) {
    //     return "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
    // }
    return null;
}

/**
 * Validate confirm password
 */
function validateConfirmPassword($password, $confirm)
{
    if (empty($confirm)) {
        return "Please confirm your password.";
    }
    if ($password !== $confirm) {
        return "Passwords do not match.";
    }
    return null;
}

/**
 * Check if email already exists in database
 */
function emailExists($email)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Register a new user
 */
function registerUser($full_name, $email, $password)
{
    global $conn;

    $errors = [];

    // Validate all fields
    $nameError = validateFullName($full_name);
    if ($nameError) $errors['full_name'] = $nameError;

    $emailError = validateEmail($email);
    if ($emailError) $errors['email'] = $emailError;

    $passwordError = validatePassword($password);
    if ($passwordError) $errors['password'] = $passwordError;

    // Check if email exists (only if email validation passed)
    if (!$emailError && emailExists($email)) {
        $errors['email'] = "Email is already registered.";
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    // Hash password and insert user
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();
        return ['success' => true, 'message' => 'Registration successful'];
    } else {
        $stmt->close();
        return ['success' => false, 'errors' => ['general' => 'Error registering user. Please try again.']];
    }
}

/**
 * Validate registration form with confirm password
 */
function validateRegistration($full_name, $email, $password, $confirm)
{
    $errors = [];

    // Validate all fields
    $nameError = validateFullName($full_name);
    if ($nameError) $errors['full_name'] = $nameError;

    $emailError = validateEmail($email);
    if ($emailError) $errors['email'] = $emailError;

    $passwordError = validatePassword($password);
    if ($passwordError) $errors['password'] = $passwordError;

    $confirmError = validateConfirmPassword($password, $confirm);
    if ($confirmError && !$passwordError) $errors['confirmPassword'] = $confirmError;

    // Check if email exists (only if email validation passed)
    if (!$emailError && emailExists($email)) {
        $errors['email'] = "Email is already registered.";
    }

    return $errors;
}

/**
 * Process user registration
 */
function processRegistration($full_name, $email, $password, $confirm)
{
    // Validate all fields first
    $errors = validateRegistration($full_name, $email, $password, $confirm);

    // If there are validation errors, return them
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    // Hash password and insert user
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();
        return ['success' => true, 'message' => 'Registration successful'];
    } else {
        $stmt->close();
        return ['success' => false, 'errors' => ['general' => 'Error registering user. Please try again.']];
    }
}

/**
 * Login user and create session
 */
function loginUser($email, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $stmt->close();
            // Create session
            createUserSession($user);
            return ['success' => true, 'user' => $user];
        }
    }

    $stmt->close();
    return ['success' => false, 'error' => 'Invalid email or password'];
}

/**
 * Create user session
 */
function createUserSession($user)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_type'] = $user['user_type'] ?? 'USER';
    $_SESSION['is_logged_in'] = true;
}

/**
 * Register user and create session
 */
function registerAndLogin($full_name, $email, $password, $confirm)
{
    // Process registration first
    $result = processRegistration($full_name, $email, $password, $confirm);

    if ($result['success']) {
        // Get the newly created user data
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $userResult = $stmt->get_result();

        if ($userResult->num_rows === 1) {
            $user = $userResult->fetch_assoc();
            createUserSession($user);
        }
        $stmt->close();
    }

    return $result;
}

/**
 * Check if user is logged in
 */
function isLoggedIn()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
}

/**
 * Get current user information
 */
function getCurrentUser()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'full_name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'user_type' => $_SESSION["user_type"] ?? 'USER', // Default to 'USER' if not set
        ];
    }

    return null;
}

/**
 * Logout user and destroy session
 */
function logoutUser()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();
}

/**
 * Redirect if user is already logged in (for login/register pages)
 */
function redirectIfLoggedIn()
{
    if (isLoggedIn()) {
        $currentUser = getCurrentUser();
        if ($currentUser['user_type'] === 'OWNER' || $currentUser['user_type'] === 'ADMIN') {
            // Redirect to admin dashboard if user is not a regular user
            header("Location: dashboard.php");
        } else {
            // Redirect to home page for regular users
            header("Location: home.php");
        }
        exit();
    }
}

/**
 * Redirect if user is not logged in (for protected pages)
 */
function redirectIfNotLoggedIn()
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

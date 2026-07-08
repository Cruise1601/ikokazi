<?php
/**
 * User Registration API
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/functions.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode($response);
    exit();
}

// Get input
$full_name = sanitize_input($_POST['full_name'] ?? '');
$email = sanitize_input($_POST['email'] ?? '');
$phone = sanitize_input($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$role = sanitize_input($_POST['role'] ?? ROLE_SEEKER);

// Validate input
$errors = [];

if (empty($full_name)) {
    $errors['full_name'] = 'Full name is required';
}

if (!is_valid_email($email)) {
    $errors['email'] = 'Valid email is required';
}

if (!is_valid_phone($phone)) {
    $errors['phone'] = 'Valid phone number is required';
}

if (strlen($password) < PASSWORD_MIN_LENGTH) {
    $errors['password'] = 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters';
}

if ($password !== $password_confirm) {
    $errors['password_confirm'] = 'Passwords do not match';
}

if (!in_array($role, [ROLE_SEEKER, ROLE_EMPLOYER])) {
    $errors['role'] = 'Invalid role selected';
}

if (!empty($errors)) {
    $response['errors'] = $errors;
    echo json_encode($response);
    exit();
}

// Check if email exists
try {
    $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $response['message'] = 'Email already registered';
        echo json_encode($response);
        exit();
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
    echo json_encode($response);
    exit();
}

// Hash password
$hashed_password = hash_password($password);

// Create user
try {
    $pdo->beginTransaction();
    
    $stmt = $pdo->prepare(
        'INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([$full_name, $email, $phone, $hashed_password, $role]);
    
    $user_id = $pdo->lastInsertId();
    
    // Create seeker or employer profile
    if ($role === ROLE_SEEKER) {
        $stmt = $pdo->prepare(
            'INSERT INTO seeker_profiles (seeker_id, user_id) VALUES (?, ?)'
        );
        $stmt->execute([$user_id, $user_id]);
    } else if ($role === ROLE_EMPLOYER) {
        $stmt = $pdo->prepare(
            'INSERT INTO employer_profiles (user_id, company_name) VALUES (?, ?)'
        );
        $stmt->execute([$user_id, $full_name]);
    }
    
    $pdo->commit();
    
    $response['success'] = true;
    $response['message'] = 'Registration successful. Please log in.';
    $response['redirect'] = '/ikokazi/login';
    
} catch (PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Registration failed: ' . $e->getMessage();
}

echo json_encode($response);
?>

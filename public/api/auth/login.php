<?php
/**
 * User Login API
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
$email = sanitize_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    $response['message'] = 'Email and password are required';
    echo json_encode($response);
    exit();
}

if (!is_valid_email($email)) {
    $response['message'] = 'Invalid email format';
    echo json_encode($response);
    exit();
}

// Get user
try {
    $stmt = $pdo->prepare(
        'SELECT user_id, full_name, email, password, role, is_active FROM users WHERE email = ? LIMIT 1'
    );
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() === 0) {
        $response['message'] = 'Invalid email or password';
        echo json_encode($response);
        exit();
    }
    
    $user = $stmt->fetch();
    
    if (!$user['is_active']) {
        $response['message'] = 'Account is inactive';
        echo json_encode($response);
        exit();
    }
    
    // Verify password
    if (!verify_password($password, $user['password'])) {
        $response['message'] = 'Invalid email or password';
        echo json_encode($response);
        exit();
    }
    
    // Set session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    
    $response['success'] = true;
    $response['message'] = 'Login successful';
    $response['redirect'] = '/ikokazi/dashboard';
    
} catch (PDOException $e) {
    $response['message'] = 'Login error: ' . $e->getMessage();
}

echo json_encode($response);
?>

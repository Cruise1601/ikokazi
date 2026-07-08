<?php
/**
 * Helper Functions
 * IKO KAZI - Localized Job Marketplace
 */

/**
 * Hash password using bcrypt
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password against hash
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Validate email format
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone number (Kenya format)
 */
function is_valid_phone($phone) {
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    return preg_match('/^\+?254[0-9]{9}$|^0[0-9]{9}$/', $phone);
}

/**
 * Sanitize user input
 */
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Format currency (KES)
 */
function format_currency($amount) {
    return 'KES ' . number_format($amount, 2);
}

/**
 * Format date
 */
function format_date($date, $format = 'Y-m-d H:i') {
    return date($format, strtotime($date));
}

/**
 * Check if user is authenticated
 */
function is_authenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check user role
 */
function has_role($role) {
    return is_authenticated() && isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header('Location: ' . $url);
    exit();
}

/**
 * Get current user ID
 */
function get_current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get error message
 */
function get_error_message($key) {
    return $_SESSION['errors'][$key] ?? null;
}

/**
 * Set error message
 */
function set_error_message($key, $message) {
    if (!isset($_SESSION['errors'])) {
        $_SESSION['errors'] = [];
    }
    $_SESSION['errors'][$key] = $message;
}

/**
 * Clear error messages
 */
function clear_errors() {
    unset($_SESSION['errors']);
}

/**
 * Get success message
 */
function get_success_message() {
    $message = $_SESSION['success'] ?? null;
    unset($_SESSION['success']);
    return $message;
}

/**
 * Set success message
 */
function set_success_message($message) {
    $_SESSION['success'] = $message;
}
?>

<?php
/**
 * Database Configuration
 * IKO KAZI - Localized Job Marketplace
 */

// Database credentials
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'iko_kazi');
define('DB_PORT', getenv('DB_PORT') ?: 3306);

// Application settings
define('APP_URL', getenv('APP_URL') ?: 'http://localhost/ikokazi');
define('APP_ENV', getenv('APP_ENV') ?: 'development');

// Session settings
define('SESSION_LIFETIME', 3600); // 1 hour
define('SESSION_SECURE', false); // Set to true in production with HTTPS

// File upload settings
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('CV_UPLOAD_DIR', __DIR__ . '/../uploads/cvs/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx']);

// Create PDO connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO(
        $dsn,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Create upload directories if they don't exist
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}
if (!is_dir(CV_UPLOAD_DIR)) {
    mkdir(CV_UPLOAD_DIR, 0755, true);
}
?>

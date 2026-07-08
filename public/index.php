<?php
/**
 * Main Application Entry Point
 * IKO KAZI - Localized Job Marketplace
 */

session_start();

// Load configuration
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/functions.php';

// Set timezone
date_default_timezone_set('Africa/Nairobi');

// Router
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = str_replace('/ikokazi', '', $request_uri);
$request_method = $_SERVER['REQUEST_METHOD'];

// Define routes
$routes = [
    'GET' => [
        '/' => 'public/pages/home.php',
        '/about' => 'public/pages/about.php',
        '/register' => 'public/pages/register.php',
        '/login' => 'public/pages/login.php',
        '/logout' => 'public/pages/logout.php',
        '/dashboard' => 'public/pages/dashboard.php',
        '/profile' => 'public/pages/profile.php',
        '/jobs' => 'public/pages/jobs/index.php',
        '/jobs/view' => 'public/pages/jobs/view.php',
        '/applications' => 'public/pages/applications/index.php',
        '/admin' => 'public/pages/admin/dashboard.php',
        '/contact' => 'public/pages/contact.php',
    ],
    'POST' => [
        '/register' => 'public/api/auth/register.php',
        '/login' => 'public/api/auth/login.php',
        '/jobs/create' => 'public/api/jobs/create.php',
        '/jobs/update' => 'public/api/jobs/update.php',
        '/jobs/delete' => 'public/api/jobs/delete.php',
        '/applications/create' => 'public/api/applications/create.php',
        '/applications/update' => 'public/api/applications/update.php',
        '/profile/update' => 'public/api/profile/update.php',
    ]
];

// Route handler
if (isset($routes[$request_method][$request_uri])) {
    require_once __DIR__ . '/../' . $routes[$request_method][$request_uri];
} else {
    // 404 page
    http_response_code(404);
    require_once __DIR__ . '/pages/404.php';
}
?>

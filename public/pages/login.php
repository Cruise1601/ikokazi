<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo generate_csrf_token(); ?>">
    <title>Login - IKO KAZI</title>
    <link rel="stylesheet" href="/ikokazi/public/css/styles.css">
    <link rel="stylesheet" href="/ikokazi/public/css/responsive.css">
</head>
<body>
    <header>
        <nav class="container flex-between">
            <a href="/ikokazi/" class="logo">🏢 IKO KAZI</a>
            <ul class="nav-links">
                <li><a href="/ikokazi/register">Register</a></li>
            </ul>
        </nav>
    </header>

    <main style="padding: 2rem 1rem; min-height: 80vh;">
        <div class="container" style="max-width: 500px;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Login</h2>
                </div>

                <form id="loginForm" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>

                <p style="text-align: center; margin-top: 1rem;">
                    Don't have an account? <a href="/ikokazi/register">Register here</a>
                </p>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 IKO KAZI. All rights reserved.</p>
        </div>
    </footer>

    <script src="/ikokazi/public/js/main.js"></script>
    <script>
        handleFormSubmit('loginForm', '/ikokazi/api/auth/login.php');
    </script>
</body>
</html>

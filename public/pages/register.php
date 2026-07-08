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
    <title>Register - IKO KAZI</title>
    <link rel="stylesheet" href="/ikokazi/public/css/styles.css">
    <link rel="stylesheet" href="/ikokazi/public/css/responsive.css">
</head>
<body>
    <header>
        <nav class="container flex-between">
            <a href="/ikokazi/" class="logo">🏢 IKO KAZI</a>
            <ul class="nav-links">
                <li><a href="/ikokazi/login">Login</a></li>
            </ul>
        </nav>
    </header>

    <main style="padding: 2rem 1rem; min-height: 80vh;">
        <div class="container" style="max-width: 500px;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Create Account</h2>
                </div>

                <form id="registerForm" method="POST">
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" placeholder="+254 or 0..." required>
                    </div>

                    <div class="form-group">
                        <label for="role">I am a *</label>
                        <select id="role" name="role" required>
                            <option value="seeker">Job Seeker</option>
                            <option value="employer">Employer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required>
                        <small>At least 8 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirm Password *</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>

                <p style="text-align: center; margin-top: 1rem;">
                    Already have an account? <a href="/ikokazi/login">Login here</a>
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
        handleFormSubmit('registerForm', '/ikokazi/api/auth/register.php');
    </script>
</body>
</html>

<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/functions.php';

// Check authentication
if (!is_authenticated()) {
    redirect('/ikokazi/login');
}

$user_id = get_current_user_id();
$role = $_SESSION['role'];

// Get user data
try {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    die('Error fetching user: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo generate_csrf_token(); ?>">
    <title>Dashboard - IKO KAZI</title>
    <link rel="stylesheet" href="/ikokazi/public/css/styles.css">
    <link rel="stylesheet" href="/ikokazi/public/css/responsive.css">
</head>
<body data-authenticated="true">
    <header>
        <nav class="container flex-between">
            <a href="/ikokazi/" class="logo">🏢 IKO KAZI</a>
            <ul class="nav-links">
                <li><a href="/ikokazi/">Home</a></li>
                <li><a href="/ikokazi/jobs">Browse Jobs</a></li>
                <li><a href="/ikokazi/profile">Profile</a></li>
                <li><?php echo $_SESSION['full_name']; ?></li>
                <li><a href="/ikokazi/logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main style="padding: 2rem 1rem;">
        <div class="container">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
            
            <?php if ($role === ROLE_SEEKER): ?>
                <!-- Job Seeker Dashboard -->
                <div class="grid grid-2" style="margin-top: 2rem;">
                    <div class="card">
                        <h2>My Applications</h2>
                        <p>Track your job applications and interview status.</p>
                        <a href="/ikokazi/applications" class="btn btn-primary" style="margin-top: 1rem;">View Applications</a>
                    </div>
                    <div class="card">
                        <h2>My CV</h2>
                        <p>Upload and manage your curriculum vitae.</p>
                        <a href="/ikokazi/profile" class="btn btn-primary" style="margin-top: 1rem;">Update Profile</a>
                    </div>
                    <div class="card">
                        <h2>Browse Jobs</h2>
                        <p>Search for jobs in your area.</p>
                        <a href="/ikokazi/jobs" class="btn btn-primary" style="margin-top: 1rem;">Find Jobs</a>
                    </div>
                    <div class="card">
                        <h2>Saved Jobs</h2>
                        <p>Jobs you've saved for later.</p>
                        <a href="/ikokazi/profile?tab=saved" class="btn btn-primary" style="margin-top: 1rem;">View Saved</a>
                    </div>
                </div>
            <?php elseif ($role === ROLE_EMPLOYER): ?>
                <!-- Employer Dashboard -->
                <div class="grid grid-2" style="margin-top: 2rem;">
                    <div class="card">
                        <h2>Post a Job</h2>
                        <p>Create a new job listing.</p>
                        <a href="/ikokazi/jobs/create" class="btn btn-primary" style="margin-top: 1rem;">Post Job</a>
                    </div>
                    <div class="card">
                        <h2>My Jobs</h2>
                        <p>Manage your job listings.</p>
                        <a href="/ikokazi/jobs/manage" class="btn btn-primary" style="margin-top: 1rem;">View Jobs</a>
                    </div>
                    <div class="card">
                        <h2>Applications</h2>
                        <p>Review applications from job seekers.</p>
                        <a href="/ikokazi/applications/review" class="btn btn-primary" style="margin-top: 1rem;">View Applications</a>
                    </div>
                    <div class="card">
                        <h2>Company Profile</h2>
                        <p>Update your company information.</p>
                        <a href="/ikokazi/profile" class="btn btn-primary" style="margin-top: 1rem;">Update Profile</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 IKO KAZI. All rights reserved.</p>
        </div>
    </footer>

    <script src="/ikokazi/public/js/main.js"></script>
</body>
</html>

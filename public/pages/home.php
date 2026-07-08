<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/functions.php';

// Get featured jobs
try {
    $stmt = $pdo->prepare(
        'SELECT j.*, ep.company_name FROM jobs j 
         JOIN employer_profiles ep ON j.employer_id = ep.employer_id 
         WHERE j.status = ? 
         ORDER BY j.created_at DESC 
         LIMIT 6'
    );
    $stmt->execute([JOB_STATUS_ACTIVE]);
    $featured_jobs = $stmt->fetchAll();
} catch (PDOException $e) {
    $featured_jobs = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo generate_csrf_token(); ?>">
    <title>IKO KAZI - Local Job Marketplace</title>
    <link rel="stylesheet" href="/ikokazi/public/css/styles.css">
    <link rel="stylesheet" href="/ikokazi/public/css/responsive.css">
</head>
<body data-authenticated="<?php echo is_authenticated() ? 'true' : 'false'; ?>">
    <header>
        <nav class="container flex-between">
            <a href="/ikokazi/" class="logo">🏢 IKO KAZI</a>
            <ul class="nav-links">
                <li><a href="/ikokazi/">Home</a></li>
                <li><a href="/ikokazi/jobs">Browse Jobs</a></li>
                <li><a href="/ikokazi/about">About</a></li>
                <?php if (is_authenticated()): ?>
                    <li><a href="/ikokazi/dashboard">Dashboard</a></li>
                    <li><a href="/ikokazi/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/ikokazi/login">Login</a></li>
                    <li><a href="/ikokazi/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section style="background: linear-gradient(135deg, #2563eb 0%, #10b981 100%); color: white; padding: 4rem 1rem; text-align: center;">
            <div class="container">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Find Local Jobs Near You</h1>
                <p style="font-size: 1.25rem; margin-bottom: 2rem;">Connect with trusted employers in your area. No fake jobs, just real opportunities.</p>
                
                <form action="/ikokazi/jobs" method="GET" style="display: flex; gap: 0.5rem; max-width: 600px; margin: 0 auto;">
                    <input type="text" name="search" placeholder="Job title or company" style="flex: 1;">
                    <select name="location" style="width: 200px;">
                        <option value="">All Locations</option>
                        <option value="nairobi">Nairobi</option>
                        <option value="mombasa">Mombasa</option>
                        <option value="kisumu">Kisumu</option>
                        <option value="nakuru">Nakuru</option>
                        <option value="eldoret">Eldoret</option>
                    </select>
                    <button type="submit" class="btn btn-secondary">Search</button>
                </form>
            </div>
        </section>

        <!-- Featured Jobs -->
        <section style="padding: 3rem 1rem;">
            <div class="container">
                <h2 style="margin-bottom: 2rem;">Featured Jobs</h2>
                
                <?php if (empty($featured_jobs)): ?>
                    <p class="text-center">No jobs available yet. Check back soon!</p>
                <?php else: ?>
                    <div class="grid grid-3">
                        <?php foreach ($featured_jobs as $job): ?>
                            <div class="card">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p style="color: var(--text-color);"><strong><?php echo htmlspecialchars($job['company_name']); ?></strong></p>
                                <p style="font-size: 0.875rem; color: #6b7280;"><?php echo htmlspecialchars($job['location_tag']); ?></p>
                                <p style="margin: 1rem 0;"><?php echo substr(htmlspecialchars($job['description']), 0, 100) . '...'; ?></p>
                                <p><strong>Pay: </strong><?php echo ucfirst($job['pay_type']); ?></p>
                                <div style="margin-top: 1rem;">
                                    <a href="/ikokazi/jobs/view?job_id=<?php echo $job['job_id']; ?>" class="btn btn-primary btn-small">View Details</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="text-center" style="margin-top: 2rem;">
                    <a href="/ikokazi/jobs" class="btn btn-primary">View All Jobs</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section style="background-color: var(--light-color); padding: 3rem 1rem;">
            <div class="container">
                <h2 style="text-align: center; margin-bottom: 2rem;">Why Choose IKO KAZI?</h2>
                
                <div class="grid grid-3">
                    <div class="card text-center">
                        <h3 style="font-size: 2rem; color: var(--primary-color);">✓</h3>
                        <h4>Verified Jobs</h4>
                        <p>All job listings are verified to eliminate fake opportunities and protect job seekers.</p>
                    </div>
                    <div class="card text-center">
                        <h3 style="font-size: 2rem; color: var(--primary-color);">📍</h3>
                        <h4>Local Focus</h4>
                        <p>Find opportunities in your area, supporting local businesses and communities.</p>
                    </div>
                    <div class="card text-center">
                        <h3 style="font-size: 2rem; color: var(--primary-color);">🔒</h3>
                        <h4>Secure & Safe</h4>
                        <p>Your information is protected with industry-standard security measures.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 IKO KAZI. All rights reserved.</p>
            <p><a href="/ikokazi/">Home</a> | <a href="/ikokazi/about">About</a> | <a href="/ikokazi/contact">Contact</a></p>
        </div>
    </footer>

    <script src="/ikokazi/public/js/main.js"></script>
</body>
</html>

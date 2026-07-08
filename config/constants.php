<?php
/**
 * Application Constants
 * IKO KAZI - Localized Job Marketplace
 */

// User roles
define('ROLE_SEEKER', 'seeker');
define('ROLE_EMPLOYER', 'employer');
define('ROLE_ADMIN', 'admin');

// Job status
define('JOB_STATUS_ACTIVE', 'active');
define('JOB_STATUS_CLOSED', 'closed');
define('JOB_STATUS_ARCHIVED', 'archived');

// Application status
define('APP_STATUS_PENDING', 'pending');
define('APP_STATUS_INTERVIEWING', 'interviewing');
define('APP_STATUS_REJECTED', 'rejected');
define('APP_STATUS_ACCEPTED', 'accepted');

// Pay types
define('PAY_TYPE_DAILY', 'daily');
define('PAY_TYPE_WEEKLY', 'weekly');
define('PAY_TYPE_MONTHLY', 'monthly');

// Password settings
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_HASH_ALGO', 'bcrypt');

// Common locations (Kenya-focused)
$COMMON_LOCATIONS = [
    'nairobi' => 'Nairobi',
    'mombasa' => 'Mombasa',
    'kisumu' => 'Kisumu',
    'nakuru' => 'Nakuru',
    'eldoret' => 'Eldoret',
    'kericho' => 'Kericho',
    'nyeri' => 'Nyeri',
    'muranga' => 'Muranga',
    'kiambu' => 'Kiambu',
    'machakos' => 'Machakos',
];
?>

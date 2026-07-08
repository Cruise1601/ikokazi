<?php
/**
 * User Logout
 */

session_start();

// Destroy session
session_destroy();

// Redirect to home
header('Location: /ikokazi/');
exit();
?>

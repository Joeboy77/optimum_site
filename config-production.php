<?php
// Production Database Configuration
// Replace these values with your actual production database details

$con = mysqli_connect("localhost", "your_db_username", "your_db_password") or die("Unable to connect");
mysqli_select_db($con, "your_production_db_name");

// Enable error logging in production (disable display_errors)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Set timezone
date_default_timezone_set('UTC');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
?>
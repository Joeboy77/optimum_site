<?php

// Database configuration with environment variable support (Docker/CI/Railway)

// Support Railway-style DATABASE_URL: mysql://user:pass@host:port/dbname
$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl) {
    $parsed = parse_url($databaseUrl);
    $dbHost = $parsed['host'] ?? 'localhost';
    $dbUser = $parsed['user'] ?? '';
    $dbPass = $parsed['pass'] ?? '';
    $dbName = ltrim($parsed['path'] ?? '', '/');
    $dbPort = isset($parsed['port']) ? (int)$parsed['port'] : 3306;
} else {
    $dbHost = getenv('DB_HOST') ?: 'sql312.infinityfree.com';
    $dbUser = getenv('DB_USER') ?: 'if0_40045890';
    $dbPass = getenv('DB_PASS') ?: 'Joseph66715';
    $dbName = getenv('DB_NAME') ?: 'if0_40045890_optimim';
    $dbPort = (int)(getenv('DB_PORT') ?: 3306);
}

$con = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
if (!$con) {
    die('Unable to connect');
}

// Enable error logging (hide display in production by default)
ini_set('display_errors', getenv('DISPLAY_ERRORS') ?: 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');
// Touch error log to ensure it exists in container
if (!file_exists(__DIR__ . '/error.log')) {
    @file_put_contents(__DIR__ . '/error.log', "");
}

// Set timezone
date_default_timezone_set('UTC');

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Local Development example (legacy, kept for reference)
// $con = mysqli_connect("localhost", "root", "password", "optimumsite") or die("Unable to connect");
?>


<?php
// Script to prepare your OES system for free hosting deployment
// Run this script locally before uploading to free hosting

echo "<h2>OES System Deployment Preparation</h2>";

// Check if we're in the right directory
if (!file_exists('oes')) {
    die("❌ Error: Please run this script from the root directory of your OES project");
}

echo "✅ Found OES directory<br>";

// Create upload directories if they don't exist
$upload_dirs = [
    'oes/uploads',
    'oes/uploads/exams',
    'oes/student/uploads',
    'oes/staff/uploads'
];

foreach ($upload_dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✅ Created directory: $dir<br>";
    } else {
        echo "✅ Directory exists: $dir<br>";
    }
}

// Create .htaccess for security
$htaccess_content = "# Security and Performance Settings
Options -Indexes
DirectoryIndex index.php

# Prevent access to sensitive files
<Files ~ \"\\.(sql|log|txt|md)$\">
    Order allow,deny
    Deny from all
</Files>

# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Cache static files
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css \"access plus 1 year\"
    ExpiresByType application/javascript \"access plus 1 year\"
    ExpiresByType image/png \"access plus 1 year\"
    ExpiresByType image/jpg \"access plus 1 year\"
    ExpiresByType image/jpeg \"access plus 1 year\"
</IfModule>";

file_put_contents('.htaccess', $htaccess_content);
echo "✅ Created .htaccess file<br>";

// Create production config template
$config_template = '<?php
// Production Database Configuration
// Replace these values with your actual free hosting database details

$con = mysqli_connect("localhost", "your_db_username", "your_db_password") or die("Unable to connect");
mysqli_select_db($con, "your_db_name");

// Enable error logging in production (disable display_errors)
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/error.log");

// Set timezone
date_default_timezone_set("UTC");

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
?>';

file_put_contents('config-production.php', $config_template);
echo "✅ Created production config template<br>";

// Create database export script
$export_script = '<?php
// Database Export Script
// Run this to export your local database for import to free hosting

include "config.php";

$filename = "oes_database_export_" . date("Y-m-d_H-i-s") . ".sql";
$file = fopen($filename, "w");

// Get all tables
$tables = [];
$result = mysqli_query($con, "SHOW TABLES");
while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    // Get table structure
    $result = mysqli_query($con, "SHOW CREATE TABLE `$table`");
    $row = mysqli_fetch_array($result);
    fwrite($file, "DROP TABLE IF EXISTS `$table`;\n");
    fwrite($file, $row[1] . ";\n\n");
    
    // Get table data
    $result = mysqli_query($con, "SELECT * FROM `$table`");
    while ($row = mysqli_fetch_array($result)) {
        $values = array_map(function($value) use ($con) {
            return "'" . mysqli_real_escape_string($con, $value) . "'";
        }, $row);
        fwrite($file, "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n");
    }
    fwrite($file, "\n");
}

fclose($file);
echo "✅ Database exported to: $filename<br>";
echo "📁 Upload this file to your free hosting phpMyAdmin<br>";
?>';

file_put_contents('export-database.php', $export_script);
echo "✅ Created database export script<br>";

echo "<br><h3>🎉 Preparation Complete!</h3>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Run <code>export-database.php</code> to export your database</li>";
echo "<li>Create a ZIP file of your entire project</li>";
echo "<li>Follow the free hosting deployment guide</li>";
echo "<li>Upload the ZIP file to your free hosting</li>";
echo "<li>Import the database using phpMyAdmin</li>";
echo "<li>Update config.php with your hosting database credentials</li>";
echo "</ol>";

echo "<p><strong>Files created:</strong></p>";
echo "<ul>";
echo "<li>.htaccess (security and performance)</li>";
echo "<li>config-production.php (production config template)</li>";
echo "<li>export-database.php (database export script)</li>";
echo "</ul>";
?>
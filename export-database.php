<?php
// Database Export Script
// Run this to export your local database for import to free hosting

include "config.php";

echo "<h2>🗄️ Exporting Database...</h2>";

$filename = "oes_database_export_" . date("Y-m-d_H-i-s") . ".sql";
$file = fopen($filename, "w");

if (!$file) {
    die("❌ Error: Could not create export file");
}

echo "✅ Created export file: $filename<br>";

// Get all tables
$tables = [];
$result = mysqli_query($con, "SHOW TABLES");
if (!$result) {
    die("❌ Error: " . mysqli_error($con));
}

while ($row = mysqli_fetch_array($result)) {
    $tables[] = $row[0];
}

echo "📋 Found " . count($tables) . " tables to export<br>";

foreach ($tables as $table) {
    echo "📤 Exporting table: $table<br>";
    
    // Get table structure
    $result = mysqli_query($con, "SHOW CREATE TABLE `$table`");
    if (!$result) {
        echo "⚠️ Warning: Could not get structure for table $table<br>";
        continue;
    }
    
    $row = mysqli_fetch_array($result);
    fwrite($file, "-- Table structure for table `$table`\n");
    fwrite($file, "DROP TABLE IF EXISTS `$table`;\n");
    fwrite($file, $row[1] . ";\n\n");
    
    // Get table data
    $result = mysqli_query($con, "SELECT * FROM `$table`");
    if (!$result) {
        echo "⚠️ Warning: Could not get data for table $table<br>";
        continue;
    }
    
    $rowCount = mysqli_num_rows($result);
    echo "   📊 Found $rowCount rows<br>";
    
    if ($rowCount > 0) {
        fwrite($file, "-- Data for table `$table`\n");
        
        while ($row = mysqli_fetch_array($result)) {
            $values = array_map(function($value) use ($con) {
                if ($value === null) {
                    return 'NULL';
                }
                return "'" . mysqli_real_escape_string($con, $value) . "'";
            }, $row);
            fwrite($file, "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n");
        }
        fwrite($file, "\n");
    }
}

fclose($file);

echo "<br>🎉 <strong>Database export completed!</strong><br>";
echo "📁 File created: <strong>$filename</strong><br>";
echo "📏 File size: " . number_format(filesize($filename) / 1024, 2) . " KB<br>";
echo "<br>📋 <strong>Next steps:</strong><br>";
echo "1. Set up your free hosting account<br>";
echo "2. Create MySQL database on hosting<br>";
echo "3. Import this file using phpMyAdmin<br>";
?>
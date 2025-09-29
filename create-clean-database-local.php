<?php
// Create Clean Database Export - Tables Only + Essential Data (Local)
echo "<h2>🗄️ Creating Clean Database Export (Local)...</h2>";

// Local database connection
$conn = new mysqli("localhost", "root", "Joseph66715", "optimumsite");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Output file path
$outputDir = __DIR__ . '/';
$outputFile = 'oes_database_CLEAN_' . date('Y-m-d_H-i-s') . '.sql';
$outputPath = $outputDir . $outputFile;

echo "📋 Creating clean database export...<br>";

// Get all table names
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sql = '';
echo "📋 Found " . count($tables) . " tables to export<br>";

foreach ($tables as $table) {
    echo "📤 Exporting table structure: " . $table . "<br>";
    
    // Get table structure
    $result = $conn->query("SHOW CREATE TABLE " . $table);
    $row = $result->fetch_row();
    $sql .= "\n\n" . $row[1] . ";\n\n";
    
    // Only add essential data for specific tables
    if ($table === 'registration') {
        // Add only admin user
        $sql .= "-- Essential data for table `$table`\n";
        $sql .= "INSERT INTO `$table` (indexnumber, firstname, lastname, email, username, password, status, position) VALUES ";
        $sql .= "('ADMIN001', 'Admin', 'User', 'admin@example.com', 'admin', 'admin123', 'Staff', 'Admin');\n\n";
        echo "   ✅ Added admin user<br>";
    }
    elseif ($table === 'courses') {
        // Add basic courses
        $sql .= "-- Essential data for table `$table`\n";
        $sql .= "INSERT INTO `$table` (programType, course_name, programTypeID, course_code) VALUES ";
        $sql .= "('Computer Science', 'System Design', 1, 'C001'), ";
        $sql .= "('Computer Science', 'Programming', 1, 'C002');\n\n";
        echo "   ✅ Added basic courses<br>";
    }
    elseif ($table === 'programtype') {
        // Add basic program types
        $sql .= "-- Essential data for table `$table`\n";
        $sql .= "INSERT INTO `$table` (programType) VALUES ";
        $sql .= "('Computer Science'), ";
        $sql .= "('Information Technology');\n\n";
        echo "   ✅ Added basic program types<br>";
    }
    else {
        // No data for other tables
        echo "   📝 Table structure only (no data)<br>";
    }
}

// Save to file
file_put_contents($outputPath, $sql);

$fileSize = round(filesize($outputPath) / 1024, 2); // in KB

echo "<br>🎉 <strong>Clean database export completed!</strong><br>";
echo "📁 File created: <strong>" . basename($outputFile) . "</strong><br>";
echo "📏 File size: " . $fileSize . " KB<br><br>";
echo "📋 <strong>What's included:</strong><br>";
echo "• All table structures (CREATE TABLE statements)<br>";
echo "• Admin user (username: admin, password: admin123)<br>";
echo "• Basic courses and program types<br>";
echo "• NO duplicate data or problematic INSERT statements<br><br>";
echo "✅ <strong>This file should import without any errors!</strong><br>";

$conn->close();
?>
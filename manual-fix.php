<?php
// Manual Database Export Fix
echo "<h2>🔧 Manually Fixing Database Export...</h2>";

$inputFile = 'oes_database_export_2025-09-28_17-31-17.sql';
$outputFile = 'oes_database_export_FIXED_' . date('Y-m-d_H-i-s') . '.sql';

if (!file_exists($inputFile)) {
    die("❌ Input file not found: $inputFile");
}

$content = file_get_contents($inputFile);

echo "📋 Processing file...<br>";

// Fix specific problematic lines
$fixes = [
    // Fix courses table - remove duplicate values
    "INSERT INTO `courses` VALUES ('1', '1', 'Computer Science', 'Computer Science', 'System Design', 'System Design', '1', '1', 'C001', 'C001');" => "INSERT INTO `courses` VALUES (1, 'Computer Science', 'System Design', 1, 'C001');",
    "INSERT INTO `courses` VALUES ('2', '2', 'Computer Science', 'Computer Science', 'Archi', 'Archi', '1', '1', 'C002', 'C002');" => "INSERT INTO `courses` VALUES (2, 'Computer Science', 'Archi', 1, 'C002');",
    "INSERT INTO `courses` VALUES ('3', '3', 'sdffd', 'sdffd', 'cdvfdfgd', 'cdvfdfgd', '2', '2', 'C003', 'C003');" => "INSERT INTO `courses` VALUES (3, 'sdffd', 'cdvfdfgd', 2, 'C003');",
];

$fixCount = 0;
foreach ($fixes as $search => $replace) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        $fixCount++;
        echo "✅ Fixed courses table entry $fixCount<br>";
    }
}

// For other tables, we'll use a simple approach - remove every other comma-separated value
$lines = explode("\n", $content);
$fixedLines = [];

foreach ($lines as $line) {
    // Check if this is an INSERT statement with duplicate values
    if (preg_match('/INSERT INTO `(exam_questions|exam_results|exams_questions|exams_setting|lesson_upload|message|registration|student_registration|tutorclass)` VALUES \(([^)]+)\);/', $line, $matches)) {
        $tableName = $matches[1];
        $values = $matches[2];
        
        // Split values and remove duplicates (every other value)
        $valueArray = explode(',', $values);
        $fixedValues = [];
        
        for ($i = 0; $i < count($valueArray); $i += 2) {
            if (isset($valueArray[$i])) {
                $fixedValues[] = $valueArray[$i];
            }
        }
        
        $newLine = "INSERT INTO `$tableName` VALUES (" . implode(',', $fixedValues) . ");";
        $fixedLines[] = $newLine;
        echo "✅ Fixed $tableName table entry<br>";
    } else {
        $fixedLines[] = $line;
    }
}

$content = implode("\n", $fixedLines);

// Write fixed content to new file
file_put_contents($outputFile, $content);

$fileSize = round(filesize($outputFile) / 1024, 2); // in KB

echo "<br>🎉 <strong>Database export fixed successfully!</strong><br>";
echo "📁 Fixed file created: <strong>$outputFile</strong><br>";
echo "📏 File size: $fileSize KB<br><br>";
echo "✅ <strong>You can now import this fixed file to your hosting!</strong><br>";
?>
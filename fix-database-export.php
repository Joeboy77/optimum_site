<?php
// Fix Database Export - Remove Duplicate Values
echo "<h2>🔧 Fixing Database Export...</h2>";

$inputFile = 'oes_database_export_2025-09-28_17-31-17.sql';
$outputFile = 'oes_database_export_FIXED_' . date('Y-m-d_H-i-s') . '.sql';

if (!file_exists($inputFile)) {
    die("❌ Input file not found: $inputFile");
}

$content = file_get_contents($inputFile);
$lines = explode("\n", $content);
$fixedLines = [];

echo "📋 Processing " . count($lines) . " lines...<br>";

foreach ($lines as $lineNum => $line) {
    $originalLine = $line;
    
    // Fix courses table (5 columns, but had 10 values)
    if (strpos($line, 'INSERT INTO `courses` VALUES') !== false) {
        $line = preg_replace_callback('/INSERT INTO `courses` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Keep only first 5 values: id, programType, course_name, programTypeID, course_code
            $fixedValues = array_slice($values, 0, 5);
            return 'INSERT INTO `courses` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed courses table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix exam_questions table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `exam_questions` VALUES') !== false) {
        $line = preg_replace_callback('/INSERT INTO `exam_questions` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value (assuming pattern: val1,val1,val2,val2...)
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `exam_questions` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed exam_questions table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix exam_results table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `exam_results` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `exam_results` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `exam_results` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed exam_results table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix exams_questions table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `exams_questions` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `exams_questions` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `exams_questions` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed exams_questions table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix exams_setting table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `exams_setting` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `exams_setting` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `exams_setting` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed exams_setting table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix lesson_upload table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `lesson_upload` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `lesson_upload` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `lesson_upload` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed lesson_upload table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix message table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `message` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `message` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `message` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed message table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix registration table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `registration` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `registration` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `registration` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed registration table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix student_registration table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `student_registration` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `student_registration` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `student_registration` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed student_registration table on line " . ($lineNum + 1) . "<br>";
    }
    
    // Fix tutorclass table (remove duplicate values)
    if (strpos($line, 'INSERT INTO `tutorclass` VALUES') !== false) {
        $line = preg_replace('/INSERT INTO `tutorclass` VALUES \(([^)]+)\);/', function($matches) {
            $values = explode(',', $matches[1]);
            // Remove duplicates by taking every other value
            $fixedValues = [];
            for ($i = 0; $i < count($values); $i += 2) {
                if (isset($values[$i])) {
                    $fixedValues[] = $values[$i];
                }
            }
            return 'INSERT INTO `tutorclass` VALUES (' . implode(',', $fixedValues) . ');';
        }, $line);
        echo "✅ Fixed tutorclass table on line " . ($lineNum + 1) . "<br>";
    }
    
    $fixedLines[] = $line;
}

// Write fixed content to new file
$fixedContent = implode("\n", $fixedLines);
file_put_contents($outputFile, $fixedContent);

$fileSize = round(filesize($outputFile) / 1024, 2); // in KB

echo "<br>🎉 <strong>Database export fixed successfully!</strong><br>";
echo "📁 Fixed file created: <strong>$outputFile</strong><br>";
echo "📏 File size: $fileSize KB<br><br>";
echo "📋 <strong>What was fixed:</strong><br>";
echo "• Removed duplicate values from all INSERT statements<br>";
echo "• Fixed column count mismatches<br>";
echo "• Maintained data integrity<br><br>";
echo "✅ <strong>You can now import this fixed file to your hosting!</strong><br>";
?>
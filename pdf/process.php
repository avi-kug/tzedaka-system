<?php
$upload_dir = __DIR__ . '/uploads/';
$filename = basename($_FILES['pdf_file']['name']);
$target_path = $upload_dir . $filename;
$output_file = $upload_dir . 'sorted_' . $filename;

move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_path);

$pythonPath = "C:\\Program Files (x86)\\Microsoft Visual Studio\\Shared\\Python37_64\\python.exe";

$command = "\"$pythonPath\" sort_pdf.py " . escapeshellarg($target_path) . " " . escapeshellarg($output_file);
exec($command, $outputLog, $return_var);

// פלט מלא לפענוח השגיאה
echo "<pre>";
echo "שורת פקודה:\n$command\n\n";
echo "פלט:\n" . implode("\n", $outputLog) . "\n\n";
echo "קוד שגיאה: $return_var";
echo "</pre>";
?>

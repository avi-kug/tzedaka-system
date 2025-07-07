<?php
require 'vendor/autoload.php';
include 'db.php';
include 'fields.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// כותרות

$headers = array_values($fields);
$sheet->fromArray($headers, NULL, 'A1');

// נתונים
$result = $pdo->query("SELECT * FROM people");
$rowNumber = 2;
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $sheet->fromArray([
        $row['amarkal'], $row['gizbar'], $row['last_name'], $row['husband_name'],
        $row['id_number'], $row['wife_id_number'], $row['address'], $row['floor'],
        $row['city'], $row['phone'], $row['husband_mobile'], $row['wife_name'],
        $row['wife_mobile'], $row['email']
    ], NULL, 'A' . $rowNumber++);
}

// הורדה לדפדפן
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="people.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
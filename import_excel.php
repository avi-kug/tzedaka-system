<?php
require 'vendor/autoload.php';
include 'db.php';
include 'fields.php'; 
use PhpOffice\PhpSpreadsheet\IOFactory;



if (isset($_FILES['excel_file']['tmp_name'])) {
    $filePath = $_FILES['excel_file']['tmp_name'];
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    file_put_contents('tmp_import.json', json_encode($rows));

    echo '<form id="mappingForm" method="POST">';
    echo '<div class="table-responsive"><table class="table table-bordered text-center small-text mapping-table">';
    
    // מיפוי
    echo '<tr>';
    foreach ($rows[0] as $colIdx => $colName) {
        echo '<th><select name="map['.$colIdx.']" class="form-select form-select-sm">';
        echo '<option value="">בחר שדה</option>';
       foreach ($fields as $fieldKey => $label) {
       $selected = (trim($colName) === trim($label)) ? 'selected' : '';
       echo '<option value="'.$fieldKey.'" '.$selected.'>'.$label.'</option>';}

        echo '</select></th>';
    }
    echo '</tr>';

    // שורת כותרת
    echo '<tr>';
    foreach ($rows[0] as $colName) {
        echo '<th class="bg-light">'.htmlspecialchars($colName).'</th>';
    }
    echo '</tr>';

    // שורות לדוגמה
    for ($i=1; $i < min(6, count($rows)); $i++) {
        echo '<tr>';
        foreach ($rows[$i] as $cell) {
            echo '<td>'.htmlspecialchars($cell).'</td>';
        }
        echo '</tr>';
    }

    echo '</table></div>';
    echo '<button type="submit" class="btn btn-success mt-2">ייבא נתונים</button>';
    echo '</form>';
}
?>

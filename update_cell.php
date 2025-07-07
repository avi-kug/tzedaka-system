<?php
include 'db.php';
include 'fields.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);
    $column = $_POST["column"];
    $value = $_POST["value"];

    $allowed_columns = array_keys($fields);
    if (!in_array($column, $allowed_columns)) {
        http_response_code(400);
        echo "עמודה לא תקינה";
        exit;
    }

    $stmt = $pdo->prepare("UPDATE people SET `$column` = ? WHERE id = ?");

    if ($stmt->execute()) {
        echo "עודכן בהצלחה";
    } else {
        http_response_code(500);
        echo "שגיאה בעדכון";
    }
    $stmt->close();
    $pdo->close();
}
?>

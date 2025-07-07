<?php
include 'db.php';
include 'fields.php';
session_start();

$id = intval($_POST['id']);
$fields = array_keys($fields);

$updates = [];
$params = [];
$types = "";

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $updates[] = "$field = ?";
        $params[] = $_POST[$field];
        $types .= "s";
    }
}

$params[] = $id;
$types .= "i";

$stmt = $pdo->prepare("UPDATE people SET " . implode(",", $updates) . " WHERE id = ?");

if ($stmt->execute($params)) {
    $_SESSION['success'] = "הנתונים עודכנו בהצלחה.";
} else {
    $_SESSION['error'] = "שגיאה בעדכון הנתונים.";
}

header("Location: view.php");
exit;

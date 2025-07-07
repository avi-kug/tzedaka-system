<?php
include 'db.php';
session_start();

// אם אתה עובד עם AJAX, החזר JSON:
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['last_name']) && !isset($_POST["ids"])) {
    $last_name = trim($_POST["last_name"]);
    if (empty($last_name)) {
        echo json_encode(['success' => false, 'error' => "יש למלא שם משפחה"]);
        exit;
    } else {
        $stmt = $pdo->prepare("INSERT INTO people (
            amarkal, gizbar, last_name, husband_name, id_number, wife_id_number,
            address, floor, city, phone, husband_mobile, wife_name, wife_mobile, email, alfone
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $params = [
            $_POST["amarkal"], $_POST["gizbar"], $last_name, $_POST["husband_name"],
            $_POST["id_number"], $_POST["wife_id_number"], $_POST["address"],
            $_POST["floor"], $_POST["city"], $_POST["phone"], $_POST["husband_mobile"],
            $_POST["wife_name"], $_POST["wife_mobile"], $_POST["email"], $_POST["alfone"]
        ];

        if ($stmt->execute($params)) {
            echo json_encode(['success' => true]);
        } else {
            // החזר שגיאת SQL אם יש
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['success' => false, 'error' => "שגיאה בהכנסת הנתונים: " . $errorInfo[2]]);
        }
        exit;
    }
}

// אם לא POST מתאים
echo json_encode(['success' => false, 'error' => "Invalid request"]);
exit;
?>
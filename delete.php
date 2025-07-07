<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    include 'db.php';

    $id = (int) $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM people WHERE id =:id");

    if ($stmt->execute(['id' => $id])) {
        http_response_code(200);
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }

    exit;
} else {
    http_response_code(400);
    echo "Invalid request";
}
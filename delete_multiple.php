<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    include 'db.php';

    $ids = array_filter($_POST['selected_ids'], 'is_numeric'); // רק מספרים
    if (empty($ids)) {
        header('Location: index.php?error=empty_ids');
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("DELETE FROM people WHERE id IN ($placeholders)");

    if ($stmt->execute($ids)) {
        header('Location: index.php?success=1');
        exit;
    } else {
        header('Location: index.php?error=delete_failed');
        exit;
    }
} else {
    header('Location: index.php?error=1');
    exit;
}
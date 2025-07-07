<?php
include 'db.php';
include 'session_messages.php';
include 'fields.php';
// בדיקת קיום מזהה
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);



// שליפת הנתונים מהרשומה
$stmt = $pdo->prepare("SELECT * FROM people WHERE id = ?");
$stmt->execute([$id]);
$person = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$person) {
    $_SESSION['error'] = "הרשומה לא נמצאה.";
    header("Location: index.php");
    exit;
}

// שמירת נתונים אחרי עריכה
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateFields = [];
    $values = [];

    foreach ($fields as $field => $label) {
        $value = $_POST[$field] ?? '';
        $updateFields[] = "$field = ?";
        $values[] = $value;
    }

    $sql = "UPDATE people SET " . implode(', ', $updateFields) . " WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $values[] = $id;
    $stmt->execute($values);

    $_SESSION['success'] = "הרשומה עודכנה בהצלחה.";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>עריכת רשומה</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">עריכת נתונים</h2>

    <form method="POST">
        <div class="row g-3">
            <?php foreach ($fields as $field => $label): ?>
                <div class="col-md-6">
                    <label class="form-label"><?= $label ?></label>
                    <input type="text" name="<?= $field ?>" class="form-control"
                           value="<?= htmlspecialchars($person[$field]) ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-4 text-end">
            <a href="index.php" class="btn btn-secondary">ביטול</a>
            <button type="submit" class="btn btn-primary">שמור שינויים</button>
        </div>
    </form>
</div>
</body>
</html>

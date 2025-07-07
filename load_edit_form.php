<?php
include 'db.php';
include 'fields.php';

// בדיקה אם ID נשלח
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>שגיאה: לא התקבל מזהה</div>";
    exit;
}

$id = intval($_GET['id']);

// שליפת הנתון מהמסד
$stmt = $pdo->prepare("SELECT * FROM people WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "<div class='alert alert-danger'>רשומה לא נמצאה</div>";
    exit;
}

?>

<form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <div class="row g-2">
        <?php foreach ($fields as $name => $label): ?>
            <div class="col-md-6">
                <label class="form-label"><?= $label ?></label>
                <input type="text" name="<?= $name ?>" class="form-control" value="<?= htmlspecialchars($row[$name]) ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary">עדכן</button>
    </div>
</form>

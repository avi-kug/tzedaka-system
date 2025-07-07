<?php
include 'db.php';

// טבלת יעד לבחירה
$tableName = $_GET['table'] ?? 'main';

// קבלת כל העמודות האפשריות
$allStmt = $pdo->query("SELECT column_key, label FROM columns_settings ORDER BY label");
$allFields = $allStmt->fetchAll(PDO::FETCH_KEY_PAIR);

// קבלת העמודות המסומנות בפועל לטבלה
$visStmt = $pdo->prepare("SELECT column_key FROM columns_per_table WHERE table_name = ? AND is_visible = 1");
$visStmt->execute([$tableName]);
$visibleFields = array_column($visStmt->fetchAll(), 'column_key');

// שמירת טופס
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['fields'] ?? [];

    // מחיקה קיימת
    $pdo->prepare("DELETE FROM columns_per_table WHERE table_name = ?")->execute([$tableName]);

    // הוספה חדשה
    $insert = $pdo->prepare("INSERT INTO columns_per_table (table_name, column_key, is_visible) VALUES (?, ?, 1)");
    foreach ($selected as $columnKey) {
        $insert->execute([$tableName, $columnKey]);
    }

    header("Location: manage_columns.php?table=" . urlencode($tableName) . "&saved=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>ניהול עמודות - <?= htmlspecialchars($tableName) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
  <h3 class="mb-4">⚙ ניהול עמודות לטבלה: <?= htmlspecialchars($tableName) ?></h3>

  <form method="get" class="mb-4">
    <label>בחר טבלה:</label>
    <select name="table" onchange="this.form.submit()" class="form-select w-auto d-inline-block ms-2">
      <option value="main" <?= $tableName == 'main' ? 'selected' : '' ?>>ראשי (main)</option>
      <option value="hok" <?= $tableName == 'hok' ? 'selected' : '' ?>>הו״ק (hok)</option>
      <option value="kupot" <?= $tableName == 'kupot' ? 'selected' : '' ?>>קופות (kupot)</option>
    </select>
  </form>

  <?php if (isset($_GET['saved'])): ?>
    <div class="alert alert-success">✅ השינויים נשמרו בהצלחה</div>
  <?php endif; ?>

  <form method="post">
    <div class="row">
      <?php foreach ($allFields as $key => $label): ?>
        <div class="col-md-4 mb-2">
          <label class="form-check-label">
            <input type="checkbox" name="fields[]" class="form-check-input me-1"
                   value="<?= htmlspecialchars($key) ?>"
                   <?= in_array($key, $visibleFields) ? 'checked' : '' ?>>
            <?= htmlspecialchars($label) ?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-3">💾 שמור</button>
  </form>
</div>

</body>
</html>

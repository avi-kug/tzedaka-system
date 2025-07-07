<?php
include 'db.php';
$tableName = 'hok';
$stmt = $pdo->prepare("SELECT cs.column_key, cs.label 
                       FROM columns_per_table cpt 
                       JOIN columns_settings cs ON cpt.column_key = cs.column_key 
                       WHERE cpt.table_name = ? AND cpt.is_visible = 1
                       ORDER BY cs.label");
$stmt->execute([$tableName]);
$fields_to_show = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);ob_start();

$pageTitle = 'הוראות קבע';

// שליפת נתונים לפי חיפוש
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $sql = "SELECT * FROM people WHERE 
        last_name LIKE ? OR 
        husband_name LIKE ? OR 
        id_number LIKE ? OR 
        wife_id_number LIKE ? OR 
        address LIKE ? OR 
        floor LIKE ? OR 
        city LIKE ? OR 
        phone LIKE ? OR 
        husband_mobile LIKE ? OR 
        wife_name LIKE ? OR 
        wife_mobile LIKE ? OR";

    $stmt = $pdo->prepare($sql);
    $searchParam = "%" . $search . "%";
    $stmt->bind_param(str_repeat('s', 12), 
       $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam,
        $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam
    );
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $pdo->query("SELECT * FROM people");
}

$result = $pdo->query("SELECT 
    last_name,
    husband_name,
    id_number,
    wife_id_number,
    floor,
    address,
    city,
    phone,
    husband_mobile,
    koach_harabim_amount,
    koach_harabim_note,
    achim_lachesed_amount,
    achim_lachesed_note
    FROM people");

$koachHarabimData = [];
$achimLechesedData = [];

while ($row = $result->fetch()) {
    if (!empty($row['koach_harabim_amount']) || !empty($row['koach_harabim_note'])) {
        $koachHarabimData[] = $row;
    }

    if (!empty($row['achim_lachesed_amount']) || !empty($row['achim_lachesed_note'])) {
        $achimLechesedData[] = $row;
    }
}

?>
<div class="nav-tabs-container" dir="rtl">
  <ul class="nav nav-tabs custom-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="#achim_lechesed" data-bs-toggle="tab">אחים לחסד</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#koach_harabim" data-bs-toggle="tab">כח הרבים</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#alfon" data-bs-toggle="tab">אלפון</a>
    </li>
  </ul>
</div>


    <div class="tab-content">
  <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="main-tab">
    <div class="card shadow-sm p-3 mb-4 mt-2 fixed-card-size">

    <!-- תוכן הטאבים -->
    <div class="d-flex flex-wrap gap-2 mb-3 justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFormModal">
            הוסף חדש
        </button>
        <a href="export_excel.php" class="btn btn-success">⬇ יצוא לאקסל</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
            ⬆ יבוא מאקסל
        </button>
        <button type="button" id="deleteSelectedBtn" class="btn btn-danger" disabled>
            🗑 מחק מסומנים
        </button>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                הצג/הסתר עמודות
            </button>
            <ul class="dropdown-menu">
        <?php foreach ($fields_to_show as $key => $label): ?>
        <li>
        <label class="dropdown-item"> 
        <input type="checkbox" class="toggle-column me-2" data-column="<?= htmlspecialchars($key) ?>" checked />
        <?= htmlspecialchars($label) ?>
        </label>
        </li>
        <?php endforeach; ?>
        </ul>
        </div>
    </div>
    

    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="achim_lechesed" role="tabpanel">
            <h3 class="mb-3">אחים לחסד</h3>
            <div class="table-responsive table-scroll">
            <table class="table table-bordered table-striped table-fixed mb-0">
                    <thead>
                        <tr>
                           <?php foreach ($fields_to_show as $key => $label): ?>
            <th><?= htmlspecialchars($label) ?></th>
        <?php endforeach; ?>
        <th>סכום אחים לחסד</th>
        <th>הערות אחים לחסד</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($achimLechesedData as $row): ?>
    <tr>
        <?php foreach ($fields_to_show as $key => $label): ?>
            <td><?= htmlspecialchars($row[$key] ?? '') ?></td>
        <?php endforeach; ?>
        <td><?= htmlspecialchars($row['achim_lachesed_amount'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['achim_lachesed_note'] ?? '') ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="koach_harabim" role="tabpanel">
            <h3 class="mb-3">כח הרבים</h3>
            <div class="table-responsive table-scroll">
            <table class="table table-bordered table-striped table-fixed mb-0">
                    <thead>
                        <tr>
                            <?php foreach ($fields_to_show as $key => $label): ?>
                                <th><?= htmlspecialchars($label) ?></th>
                            <?php endforeach; ?>
                            <th>סכום כח הרבים</th>
                            <th>הערות כח הרבים</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($koachHarabimData as $row): ?>
                        <tr>
                                  <?php foreach ($fields_to_show as $key => $label): ?>
            <td><?= htmlspecialchars($row[$key] ?? '') ?></td>
        <?php endforeach; ?>
        <td><?= htmlspecialchars($row['achim_lachesed_amount'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['achim_lachesed_note'] ?? '') ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
                </table>
            </div>
        </div>
</div>
        
        <div class="tab-pane fade" id="alfon" role="tabpanel">אלפון</div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
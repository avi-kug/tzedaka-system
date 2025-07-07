<?php
include 'db.php';
include 'fields.php'; // אם יש לך מערך $fields מוגדר כאן

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
        wife_mobile LIKE ? OR
        alfone LIKE ? OR
        email LIKE ?";

  $stmt = $pdo->prepare($sql);
    $searchParam = "%" . $search . "%";
    $params = array_fill(0, 13, $searchParam);
    $stmt->execute($params);
    $result = $stmt;
} else {

$stmt = $pdo->query("SELECT * FROM people ORDER BY id DESC");
}
$result = $stmt ?? null;

?>

<div class="d-flex justify-content-between mb-2">
    <div id="selectedCount" class="mb-2 text-success fw-bold"></div><!--הצגת מספר השורות שנבחרו-->
<div id="totalRows" class="mb-2 text-primary fw-bold"></div> <!--הצגת מספר השורות הכולל-->
</div>

<!-- טופס מחיקת מספר רשומות -->
<form id="deleteMultipleForm" method="POST" action="delete_multiple.php">
    <div class="table-scroll">
        <table class="table table-bordered table-striped table-fixed mb-0" id="peopleTable">
            <thead>
                <tr>
                    <th class="sticky-col start-col">
                        <input type="checkbox" id="selectAll" class="rowCheckbox" />
                    </th>
                        <?php foreach ($fields as $key => $label): ?>
                        <th class="col-<?= htmlspecialchars($key) ?> sortable" data-column="<?= htmlspecialchars($key) ?>">
                            <?= htmlspecialchars($label) ?>
                        </th>
                    <?php endforeach; ?>
                    <th class="sticky-col end-col fixed-width-btn">פעולות</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result): ?>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="sticky-col start-col">
                            <input type="checkbox" class="rowCheckbox" name="selected_ids[]" value="<?= (int)$row['id'] ?>" />
                        </td>
                        <?php foreach (array_keys($fields) as $field): ?>
                            <td
                                class="col-<?= htmlspecialchars($field) ?>"
                                title="<?= htmlspecialchars($row[$field]) ?>"
                                data-id="<?= (int)$row['id'] ?>"
                                data-column="<?= htmlspecialchars($field) ?>"
                            >
                                <?= htmlspecialchars($row[$field]) ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="sticky-col end-col">
                            <button type="button" class="btn btn-sm btn-warning" onclick="openEditModal(<?= (int)$row['id'] ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(<?= (int)$row['id'] ?>); return false;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>

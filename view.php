<?php
include 'db.php';
include 'yevu-modal.php';
include 'fields.php';

/*if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}*/


ob_start();

$pageTitle = 'פרטים מלאים';

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
        wife_mobile LIKE ?";

  $stmt = $pdo->prepare($sql);
    $searchParam = "%" . $search . "%";
    $params = array_fill(0, 11, $searchParam);
    $stmt->execute($params);
    $result = $stmt;
} else {
    $result = $pdo->query("SELECT * FROM people");
}


?>

 <div class="nav-tabs-container" dir="rtl">
  <ul class="nav nav-tabs custom-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="">פרטים מלאים</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href=""></a>
    
    </li>
  </ul>
</div>

  <!-- אפשר להוסיף כאן עוד כרטיסיות -->
<div class="tab-content">
  <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="main-tab">
    <div class="card shadow-sm p-3 mb-4 mt-2 fixed-card-size">
      <!-- כאן כל התוכן שלך: חיפוש, כפתורים, טבלה וכו' -->
      
            
            
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3" dir="rtl">
    <form id="searchForm" method="get" action="view.php" class="search-form-flex">
        <input
            type="text"
            name="search"
            class="form-control me-2"
            placeholder="חפש לפי שם או פרטים..."
            value="<?= htmlspecialchars($search) ?>"
        />
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i>
        </button>
    </form>

<!-- כאן כל התוכן של הדף (כמו טפסים, טבלאות וכו') -->
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
        <?php foreach ($fields as $key => $label): ?>
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
    </div>
                <div id="get_table">
    <?php include 'get_table.php';?>
                </div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
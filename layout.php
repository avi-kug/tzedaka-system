<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle ?? 'ניהול מערכת') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>
    
<div class="page-wrapper d-flex">
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content flex-grow-1" id="mainContent">
        <?php include 'session_messages.php'; ?>
        <?php include 'add_modal.php'; ?>
        <?php include 'edit_modal.php'; ?>
        <?= $content ?? '' ?>
    </div>
</div>
</div>

<script src="yevu.js"></script>
<script src="add.js"></script>
<script src="script.js?v=99999"></script>
<script src="inline-edit.js"></script>
<script src="delete.js"></script>
<script src="edit_modal.js"></script>
<script src="column-toggle.js"></script>
<script src="sorting-columns.js"></script>
<script src="column-width.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
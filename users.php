<?php
require 'session_messages.php';
$pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// הוספת משתמש חדש
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $permissions_pages = isset($_POST['permissions_pages']) ? implode(',', $_POST['permissions_pages']) : '';
    $default_page = $_POST['default_page'];

    $stmt = $pdo->prepare("INSERT INTO users (username, full_name, password, permissions, default_page, permissions_pages) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $full_name, $password, 'user', $default_page, $permissions_pages]);

    header("Location: users.php");
    exit;
}

// מחיקת משתמש
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: users.php");
    exit;
}

// שליפת כל המשתמשים
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// עמודים לבחירה
$sidebar_pages = [
    'index.php' => 'דף ראשי',
    'view.php' => 'פרטים מלאים',
    'hok.php' => 'הוראות קבע',
    'cash.php' => 'מזומן',
    'users.php' => 'משתמשים'
];
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ניהול משתמשים</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">ניהול משתמשים</h2>

    <form method="POST" class="row g-2 bg-white p-3 rounded shadow-sm mb-4">
        <input type="hidden" name="add_user" value="1">
        <div class="col-md-3">
            <input type="text" name="full_name" class="form-control" placeholder="שם מלא" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="username" class="form-control" placeholder="שם משתמש" required>
        </div>
        <div class="col-md-3">
            <input type="password" name="password" class="form-control" placeholder="סיסמה" required>
        </div>
        <div class="col-md-3">
            <select name="default_page" class="form-select" required>
                <option value="">דף ברירת מחדל</option>
                <?php foreach ($sidebar_pages as $file => $label): ?>
                    <option value="<?= $file ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-12">
            <label>הרשאות גישה לדפים (ניתן לבחור כמה):</label>
            <select name="permissions_pages[]" class="form-select" multiple required>
                <?php foreach ($sidebar_pages as $file => $label): ?>
                    <option value="<?= $file ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-12">
            <button class="btn btn-success w-100">הוסף משתמש</button>
        </div>
    </form>

    <table class="table table-bordered bg-white shadow-sm">
        <thead>
            <tr>
                <th>שם מלא</th>
                <th>שם משתמש</th>
                <th>דף ברירת מחדל</th>
                <th>דפים מורשים</th>
                <th>פעולות</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['default_page']) ?></td>
                    <td><?= htmlspecialchars($user['permissions_pages']) ?></td>
                    <td>
                        <a href="users.php?delete=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('למחוק משתמש?')">מחק</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

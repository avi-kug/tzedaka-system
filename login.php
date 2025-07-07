<?php
session_start();
require 'db.php'; // קובץ חיבור למסד הנתונים

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['permissions'] = $user['permissions']; // נשתמש בזה לדפי הרשאות

            header("Location: view.php"); // דף הבית שלך
            exit;
        } else {
            $error = 'שם משתמש או סיסמה שגויים';
        }
    } else {
        $error = 'נא למלא את כל השדות';
    }
}
?>

<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>התחברות</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="card shadow p-4" style="min-width: 300px; max-width: 400px;">
    <h4 class="text-center mb-3">התחברות</h4>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">שם משתמש</label>
            <input type="text" class="form-control" name="username" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">סיסמה</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">התחבר</button>
    </form>
</div>
</body>
</html>

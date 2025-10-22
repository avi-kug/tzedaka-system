<?php
// התחלת סשן אם לא קיים
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// בדוק לפי המפתח שאתה מגדיר ב־login.php
if (empty($_SESSION['user_id'])) {
    $_SESSION['error'] = 'אנא התחבר כדי להמשיך.';
    header('Location: login.php');
    exit;
}
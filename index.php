<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}
$pageTitle = 'דף ראשי';
ob_start();
?>

        <div class="card shadow-sm p-3 mb-4 mt-2 fixed-card-size">
<div class="welcome-text" style="font-size:2rem;text-align:center;margin-top:2rem;">
    ברוכים הבאים לצדקה וחסד אמשינוב
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
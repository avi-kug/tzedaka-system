<?php
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
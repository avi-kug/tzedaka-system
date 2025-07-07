<?php
session_start();
$success = $_SESSION['success'] ?? "";
$error = $_SESSION['error'] ?? "";
unset($_SESSION['success'], $_SESSION['error']);
?>

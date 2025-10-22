<?php
if (session_status() == PHP_SESSION_NONE) 
session_start();
$success = $_SESSION['success'] ?? "";
$error = $_SESSION['error'] ?? "";
unset($_SESSION['success'], $_SESSION['error']);
?>

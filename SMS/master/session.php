<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ((!isset($_SESSION['user_id']) && !isset($_SESSION['register_no'])) || !isset($_SESSION['role_id'])) {
    header("Location: /sms/index.php");
    exit(); 
}

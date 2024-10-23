<?php
session_start();
include('master/config.php');

$error_msg = '';
$success_msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];  

    
    $query = "SELECT password FROM login WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($password);  
    $stmt->fetch();
    $stmt->close();

    $query_hash_current_password = "SELECT PASSWORD(?)";
    $stmt2 = $connection->prepare($query_hash_current_password);
    $stmt2->bind_param("s", $current_password);
    $stmt2->execute();
    $stmt2->bind_result($hashed_current_password);  
    $stmt2->fetch();
    $stmt2->close();


    if ($hashed_current_password === $password) { 
        if ($new_password === $confirm_password) {

            $update_query = "UPDATE login SET password = PASSWORD(?) WHERE user_id = ?";
            $update_stmt = $connection->prepare($update_query);
            $update_stmt->bind_param("si", $new_password, $user_id);
            if ($update_stmt->execute()) {
                $_SESSION['success_msg'] = "Password successfully updated."; 
            } else {
                $_SESSION['error_msg'] = "Error updating password."; 
            }
            $update_stmt->close();
        } else {
            $_SESSION['error_msg'] = "New passwords do not match."; 
        }
    } else {
        $_SESSION['error_msg'] = "Current password is incorrect."; 
    }

    header("Location: profile.php?password_changed=1");
    exit();
}
?>

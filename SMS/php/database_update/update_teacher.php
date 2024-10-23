<?php 
include '../../master/config.php';
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
    $delete_query = 'delete from login where user_id="'.$id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $department_id = $_POST['department_id'];
    $gender = $_POST['gender'];
    $designation = $_POST['designation'];
    $role_id = $_POST['role_id'];
    $name = $_POST['name'];
    $update_query = 'update login set email_id="'.$email.'" where user_id="'.$user_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update login set department_id="'.$department_id.'" where user_id="'.$user_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update login set gender="'.$gender.'" where user_id="'.$user_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update login set designation="'.$designation.'" where user_id="'.$user_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update login set role_id="'.$role_id.'" where user_id="'.$user_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update login set name="'.$name.'" where user_id="'.$user_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}
    

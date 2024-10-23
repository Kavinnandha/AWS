<?php include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $hod_mapping_id = $_POST['delete_id'];
    $delete_query = 'delete from hod_mapping where hod_mapping_id="'.$hod_mapping_id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $hod_mapping_id = $_POST['hod_mapping_id'];
    $department_id = $_POST['department_id'];
    $user_id = $_POST['user_id'];
    $update_query = 'update hod_mapping set department_id="'.$department_id.'" where hod_mapping_id="'.$hod_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update hod_mapping set user_id="'.$user_id.'" where hod_mapping_id="'.$hod_mapping_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

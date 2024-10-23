<?php
include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $year_id = $_POST['delete_id'];
    $delete_query = 'delete from academic_year where academic_year_id="'.$year_id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $year_id = $_POST['year_id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $update_query = 'update academic_year set name="'.$name.'" where academic_year_id="'.$year_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update academic_year set type="'.$type.'" where academic_year_id="'.$year_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update academic_year set status="'.$status.'" where academic_year_id="'.$year_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

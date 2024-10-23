<?php include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $batch_id = $_POST['delete_id'];
    $delete_query = 'delete from batch where batch_id="'.$batch_id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}
else{
    $batch_id = $_POST['batch_id'];
    $batch_name = $_POST['batch_name'];
    $current_semester = $_POST['current_semester'];
    $update_query = 'update batch set batch_name="'.$batch_name.'" where batch_id="'.$batch_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update batch set current_semester="'.$current_semester.'" where batch_id="'.$batch_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

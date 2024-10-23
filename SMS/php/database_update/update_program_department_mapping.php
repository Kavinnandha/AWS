<?php include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $mapping_id = $_POST['delete_id'];
    $delete_query = 'delete from mapping_program_department where mapping_id="'.$mapping_id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $mapping_id = $_POST['mapping_id'];
    $department_id = $_POST['department_id'];
    $programme_id = $_POST['programme_id'];
    $update_query = 'update mapping_program_department set department_id="'.$department_id.'" where mapping_id="'.$mapping_id.'"';
echo $update_query;
    mysqli_query($connection,$update_query);
    $update_query = 'update mapping_program_department set programme_id="'.$department_id.'" where mapping_id="'.$mapping_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

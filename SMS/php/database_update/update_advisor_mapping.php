<?php 
include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $advisor_mapping_id = $_POST['delete_id'];
    $delete_query = 'delete from advisor_mapping where advisor_mapping_id = "'.$advisor_mapping_id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $advisor_mapping_id = $_POST['advisor_mapping_id'];
    $user_id = $_POST['user_id'];
    $mapping_id = $_POST['mapping_id'];
    $batch_id = $_POST['batch_id'];
    $section_id = $_POST['section_id'];
    $update_query = 'update advisor_mapping set user_id="'.$user_id.'" where advisor_mapping_id="'.$advisor_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update advisor_mapping set mapping_id="'.$mapping_id.'" where advisor_mapping_id="'.$advisor_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update advisor_mapping set batch_id="'.$batch_id.'" where advisor_mapping_id="'.$advisor_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update advisor_mapping set section_id="'.$section_id.'" where advisor_mapping_id="'.$advisor_mapping_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

<?php 

include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
    $delete_query = 'delete from course where course_id="'.$id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $type_id = $_POST['type_id'];
    $update_query = 'update course set name="'.$course_name.'" where course_id="'.$course_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update course set type_id="'.$type_id.'" where course_id="'.$course_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

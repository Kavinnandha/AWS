<?php include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $course_mapping_id = $_POST['delete_id'];
    $delete_query = 'delete from mapping_course_department_batch where course_mapping_id="'.$course_mapping_id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $course_mapping_id = $_POST['course_mapping_id'];
    $mapping_id = $_POST['mapping_id'];
    $batch_id = $_POST['batch_id'];
    $semester = $_POST['semester'];
    $section_id = $_POST['section_id'];
    $update_query = 'update mapping_course_department_batch set mapping_id="'.$mapping_id.'" where course_mapping_id="'.$course_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update mapping_course_department_batch set batch_id="'.$batch_id.'" where course_mapping_id="'.$course_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update mapping_course_department_batch set semester="'.$semester.'" where course_mapping_id="'.$course_mapping_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update mapping_course_department_batch set section_id="'.$section_id.'" where course_mapping_id="'.$course_mapping_id.'"';
    mysqli_query($connection,$update_query);

}

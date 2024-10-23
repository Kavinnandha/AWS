<?php include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $new_id = $_POST['delete_id'];
    $delete_query = 'delete from mapping_teacher_course where new_id="'.$new_id.'"';
    if(mysqli_query($connection,$delete_query)){
            echo "success";
    }else{
            echo "error";
    }
}else{
    $new_id = $_POST['new_id'];
    $user_id = $_POST['user_id'];
    $course_mapping_id = $_POST['course_mapping_id'];
    $section_id = $_POST['section_id'];
    $update_query = 'update mapping_teacher_course set user_id="'.$user_id.'" where new_id="'.$new_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update mapping_teacher_course set course_mapping_id="'.$course_mapping_id.'" where new_id="'.$new_id.'"';
    mysqli_query($connection,$update_query);
    $update_query = 'update mapping_teacher_course set section_id="'.$section_id.'" where new_id="'.$new_id.'"';
    mysqli_query($connection,$update_query);
    echo "success";
}

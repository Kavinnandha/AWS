<?php
include '../../master/config.php';
$user_id = $_POST['user_id'];
$course_mapping_id = $_POST['course_mapping_id'];
$section_id = $_POST['section_id'];
$check_duplicate = 'select user_id,course_mapping_id,section_id from mapping_teacher_course where user_id="'.$user_id.'" and course_mapping_id="'.$course_mapping_id.'" and section_id = "'.$section_id.'"';
$duplicates = mysqli_query($connection,$check_duplicate);
if($duplicates->num_rows > 0){
echo "<script>alert('Duplicate entry detected, please check the details again.');window.location.href='../../master/database_upload/create_teacher_course_mapping.php'</script>";
}else{
$insert_details = 'insert into mapping_teacher_course(user_id,course_mapping_id,section_id) values("'.$user_id.'","'.$course_mapping_id.'","'.$section_id.'")';
$queryEXE = mysqli_query($connection,$insert_details);
echo "<script>alert('Teacher Course mapping details have been successfully inserted.');window.location.href='../../master/database_upload/create_teacher_course_mapping.php'</script>";
}
?>

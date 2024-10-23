<?php
include '../master/config.php';
session_start();
$batch_id = $_POST['batch_id'];
$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];
$section_id = $_POST['section_id'];
$department_id = $_POST['department_id'];
$get_new_id = 'select mtc.new_id from mapping_teacher_course mtc join mapping_course_department_batch mcdb on mcdb.course_mapping_id=mtc.course_mapping_id where mcdb.batch_id="'.$batch_id.'" and mtc.user_id="'.$user_id.'" and mcdb.course_id="'.$course_id.'" and mtc.section_id="'.$section_id.'"';
$queryEXE = mysqli_query($connection,$get_new_id);
$result = mysqli_fetch_array($queryEXE);
echo json_encode($result);
?>

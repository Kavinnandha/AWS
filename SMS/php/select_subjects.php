<?php
include '../master/config.php';
session_start();
if(isset($_POST['batch_id'])){
	$batch_id = $_POST['batch_id'];
	$user_id = $_SESSION['user_id'];
	$subject_details = 'SELECT distinct c.course_id, c.name FROM course c JOIN mapping_course_department_batch mcdb ON mcdb.course_id = c.course_id JOIN mapping_teacher_course mtc ON mtc.course_mapping_id = mcdb.course_mapping_id WHERE mcdb.batch_id = "' .$batch_id. '" AND mtc.user_id = "' .$user_id. '"';
	$queryEXE = mysqli_query($connection,$subject_details);
	if ($queryEXE->num_rows>0) {
        $subjects = array();
        while($row = mysqli_fetch_array($queryEXE)){
            $subjects[] = $row;
        }
	}
	$retrieve_new_id = 'select mtc.new_id from mapping_teacher_course mtc join mapping_course_department_batch mcdb on mcdb.course_mapping_id=mtc.course_mapping_id where mcdb.batch_id="'.$batch_id.'" and mtc.user_id= "'.$user_id.'"';
	$queryEXE= mysqli_query($connection,$retrieve_new_id);
	if($queryEXE->num_rows>0){
		$row = mysqli_fetch_array($queryEXE);
		$new_id = $row[0];
	}
	echo json_encode($subjects);
}
?>

<?php
include '../master/config.php';
session_start();
if(isset($_POST['section_id'])){
        $batch_id = $_POST['batch_id'];
        $user_id = $_SESSION['user_id'];
        $section_id = $_POST['section_id'];
        $department_id = $_POST['department_id'];
        $select_mapping_id = 'select mapping_id from mapping_program_department where department_id = "'.$department_id.'"';
        $map_select = mysqli_query($connection,$select_mapping_id);
        $mapping_id = mysqli_fetch_row($map_select)[0];
    $subject_details = 'SELECT register_no,name from student_information where batch_id = "' .$batch_id. '" and section_id = "' .$section_id. '" and mapping_id="'.$mapping_id.'"';
	$attendance_details = 'SELECT value,description from attendance_type where type_id !=4';
        $queryEXE = mysqli_query($connection,$subject_details);
        if ($queryEXE->num_rows>0) {
        $details = array('students' => array(),'attendance_type' => array());
        while($row = mysqli_fetch_assoc($queryEXE)){
            $details['students'][] = $row;
	}
	$queryEXE = mysqli_query($connection,$attendance_details);
	while($row = mysqli_fetch_assoc($queryEXE)){
		$details['attendance_type'][] = $row;
	}
        echo json_encode($details);
        }
}
?>


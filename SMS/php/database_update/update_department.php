<?php
include '../../master/config.php';
if(isset($_POST['department_id']) and isset($_POST['department_name'])){
	$department_id = $_POST['department_id'];
	$department_name = $_POST['department_name'];
	$query = 'update department set name="'.$department_name.'" where department_id="'.$department_id.'"';
	if(mysqli_query($connection,$query)){
		echo "success";
	}else{
		echo "error";
	}
}else{
	$department_id = $_POST['department_id'];
	$query = 'delete from department where department_id="'.$department_id.'"';
	if(mysqli_query($connection,$query)){
		echo "success";
	}else{
		echo "error";
	}
}
?>

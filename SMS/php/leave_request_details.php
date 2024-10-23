<?php
@include '../master/config.php';
@session_start();
if(isset($_POST['reason'])){
	if(isset($_SESSION['user_id'])){
		$reference_id = $_SESSION['user_id'];
	}else{

		$reference_id = $_SESSION['register_no'];
	}
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$no_of_days = $_POST['no_of_days'];
	$type_id = $_POST['type_id'];
	$reason = $_POST['reason'];
	$out_time = $_POST['out_time'];
	$in_time = $_POST['in_time'];
	$status_id = 0;
	$check_overlapping = 'select count(*) from leave_record WHERE start_date <= "'.$end_date.'" AND end_date >= "'.$start_date.'" and reference_id="'.$reference_id.'"';
	$queryEXE = mysqli_query($connection,$check_overlapping);
	$overlap = mysqli_fetch_row($queryEXE)[0];
	if($overlap > 0){
		echo '<script>alert("Leave dates are overlapping! please check and try again")</script>';
		echo '<script>window.location.href = "../my/homepage.php"</script>';

	}else{
		$insert_leave_request = 'insert into leave_record(reference_id,start_date,end_date,no_of_days,type_id,reason,out_time,in_time,status_id) values ("'.$reference_id.'","'.$start_date.'","'.$end_date.'","'.$no_of_days.'","'.$type_id.'","'.$reason.'","'.$out_time.'","'.$in_time.'","'.$status_id.'")';
		$queryEXE = mysqli_query($connection,$insert_leave_request);
		echo '<script>alert("Leave reqest submitted!")</script>';
		if(isset($_SESSION['user_id'])){
			echo '<script>window.location.href = "../request_leave.php"</script>';
		}else{
			echo '<script>window.location.href = "../my/homepage.php"</script>';
		}
	}
}
@include 'master/config.php';
$get_leave_type = 'select type_id,description from attendance_type where type_id != 1';
$queryEXE = mysqli_query($connection,$get_leave_type);
$leave_type = '';
while($row = mysqli_fetch_array($queryEXE)){
	$leave_type.='<option value="'.$row['type_id'].'">'.$row['description'].'</option>';
}

?>

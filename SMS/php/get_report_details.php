<?php
include 'master/config.php';
$user_id = $_SESSION['user_id'];
$department = '<select id="department-dropdown" name="department" class="form-select" aria-label="Default select example" required>';
$department.='<option selected value="">select department</option>';
$department_details = 'select d.department_id,d.name from department d join login l on l.department_id=d.department_id where l.user_id="'.$user_id.'"';
$queryEXE = mysqli_query($connection,$department_details);
if($queryEXE->num_rows>0){
	while($query_result = mysqli_fetch_array($queryEXE)){
		$department.='<option value="'.$query_result["department_id"].'">'.$query_result['name'].'</option>';
	}
}
$department.='</select>';
$batch = '<select id="batch-dropdown" name="batch" class="form-select" aria-label="Default select example" required>';
$batch.='<option selected value="">select batch</option>';
$batch_details = 'select batch_id,batch_name from batch';
$queryEXE = mysqli_query($connection,$batch_details);
if($queryEXE->num_rows>0){
	while($query_result = mysqli_fetch_array($queryEXE)){
		$batch.='<option value="'.$query_result["batch_id"].'">'.$query_result["batch_name"].'</option>';
	}
}
$batch.='</select>';
$academic_year_details = 'select academic_year_id,name from academic_year';
$academic_year = '<select id="year-dropdown" name="academic_year" class="form-select" aria-label="default select example" required>';
$academic_year.='<option selected value="">select year</option>';
$queryEXE = mysqli_query($connection,$academic_year_details);
if($queryEXE->num_rows>0){
	while($query_result = mysqli_fetch_array($queryEXE)){
		$academic_year.= '<option value="'.$query_result["academic_year_id"].'">'.$query_result["name"].'</option>';
	}
}
$academic_year.='</select>';
?>

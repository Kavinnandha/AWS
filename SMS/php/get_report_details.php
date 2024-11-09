<?php
include 'master/config.php';
$user_id = $_SESSION['user_id'];
$department = '<select id="department-dropdown" name="department" class="form-select" aria-label="Default select example" required>';
$department.='<option selected value="">select department</option>';
$department_details = 'select distinct d.department_id,d.name from department d join login l on l.department_id=d.department_id';
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

	$select_subjects =  'select b.batch_id,b.batch_name,d.department_id,d.name as department_name,c.course_id,c.name as course_name,s.section_id,s.section_name from login l '.
'join mapping_teacher_course mtc on mtc.user_id=l.user_id '.
'join section s on s.section_id=mtc.section_id '.
'join mapping_course_department_batch mcdb on mcdb.course_mapping_id=mtc.course_mapping_id '.
'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
'join course c on c.course_id=mcdb.course_id '.
'join batch b on b.batch_id = mcdb.batch_id '.
'join department d on d.department_id=mpd.department_id '.
'where l.user_id="'.$user_id.'"';
	$main_dropdown = '<select id="main-dropdown" name="main" class="form-select" aria-label="Default select example">';
	$main_dropdown.='<option>select details</option>';
	$queryEXE = mysqli_query($connection,$select_subjects);
	if($queryEXE->num_rows > 0){
		while($row = mysqli_fetch_array($queryEXE)){
			$main_dropdown.='<option value="'.$row["batch_id"].','.$row["department_id"].','.$row["course_id"].','.$row["section_id"].'">'.$row["batch_name"].' - '.$row["department_name"].' - '.$row["course_name"].' - '.$row["section_name"].'</option>';
		
		}
	}
    $main_dropdown.='</select>';

	$academic_year = '<select id="year-dropdown" name="academic-year" class="form-select" aria-label="Default select example">';
	$year_details = 'select academic_year_id,name,type from academic_year';
	$queryEXE = mysqli_query($connection,$year_details);
	if($queryEXE->num_rows>0){
		while($query_result = mysqli_fetch_array($queryEXE)){
			$academic_year.='<option value="'.$query_result["academic_year_id"].'">'.$query_result["name"].' - '.$query_result["type"].'</option>';
		}
	}
	$academic_year.='</select>';

$select_advisor_class = 'select d.name,d.name as department_name,d.department_id,b.batch_name,b.batch_id,s.section_id,s.section_name from advisor_mapping am join mapping_program_department mpd on mpd.mapping_id=am.mapping_id join department d on d.department_id = mpd.department_id join batch b on b.batch_id = am.batch_id join section s on s.section_id = am.section_id where am.user_id="'.$user_id.'"';
$queryEXE = mysqli_query($connection,$select_advisor_class);
$row = mysqli_fetch_array($queryEXE);
$advisor_class_details = $row['batch_name'].' - '.$row['department_name'].' - '.$row['section_name'];

$hod_department = '<select name="department" class="form-select" aria-label="Default select example" required>';
$hod_department.='<option selected value="">select department</option>';
$hod_department_details = 'select distinct d.department_id,d.name from department d join hod_mapping hm on hm.department_id=d.department_id where hm.user_id="'.$user_id.'"';
$queryEXE = mysqli_query($connection,$hod_department_details);
if($queryEXE->num_rows>0){
	while($query_result = mysqli_fetch_array($queryEXE)){
		$hod_department.='<option value="'.$query_result["department_id"].'">'.$query_result['name'].'</option>';
	}
}
$hod_department.='</select>';

$advisor_value = '<input type="hidden" name="department" value="'.$row['department_id'].'">';
$advisor_value.='<input type="hidden" name="batch" value="'.$row['batch_id'].'">';
$advisor_value.='<input type="hidden" name="section" value="'.$row['section_id'].'">';

?>

<?php
include 'master/config.php';
include 'master/session.php';
	$uid = $_SESSION['user_id'];
	
	$select_subjects =  'select b.batch_id,b.batch_name,d.department_id,d.name as department_name,c.course_id,c.name as course_name,s.section_id,s.section_name from login l '.
'join mapping_teacher_course mtc on mtc.user_id=l.user_id '.
'join section s on s.section_id=mtc.section_id '.
'join mapping_course_department_batch mcdb on mcdb.course_mapping_id=mtc.course_mapping_id '.
'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
'join course c on c.course_id=mcdb.course_id '.
'join batch b on b.batch_id = mcdb.batch_id '.
'join department d on d.department_id=mpd.department_id '.
'where l.user_id="'.$uid.'"';
	$main_dropdown = '<select id="main-dropdown" name="main" class="form-select" aria-label="Default select example">';
	$main_dropdown.='<option value="">select details</option>';
	$queryEXE = mysqli_query($connection,$select_subjects);
	if($queryEXE->num_rows > 0){
		while($row = mysqli_fetch_array($queryEXE)){
			$main_dropdown.='<option value="'.$row["batch_id"].','.$row["department_id"].','.$row["course_id"].','.$row["section_id"].'">'.$row["batch_name"].' - '.$row["department_name"].' - '.$row["course_name"].' - '.$row["section_name"].'</option>';
		
		}
	}
	$main_dropdown.='</select>';
	$academic_year = '<select id="year-dropdown" name="academic-year" class="form-select" aria-label="Default select example">';
	$year_details = 'select academic_year_id,name,type from academic_year where status="ACTIVE"';
	$queryEXE = mysqli_query($connection,$year_details);
	if($queryEXE->num_rows>0){
		while($query_result = mysqli_fetch_array($queryEXE)){
			$academic_year.='<option value="'.$query_result["academic_year_id"].'">'.$query_result["name"].' - '.$query_result["type"].'</option>';
		}
	}
	$academic_year.='</select>';
?>

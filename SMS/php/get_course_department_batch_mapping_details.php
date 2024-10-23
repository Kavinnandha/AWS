<?php

$select_course_department_batch_mapping = 'select mcdb.course_mapping_id,mcdb.course_id,mcdb.mapping_id,mcdb.batch_id,c.name as course_name,p.programme_name,d.name as department_name,b.batch_name,mcdb.semester from mapping_course_department_batch mcdb join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id join batch b on b.batch_id=mcdb.batch_id join course c on c.course_id=mcdb.course_id join programme p on p.programme_id=mpd.programme_id join department d on d.department_id=mpd.department_id';
$queryEXE = mysqli_query($connection,$select_course_department_batch_mapping);
if($queryEXE->num_rows > 0){
	$course_department_batch_mapping_data = '';
    while($row = mysqli_fetch_array($queryEXE)){
        $course_department_batch_mapping_data.='<tr>';
        $course_department_batch_mapping_data.='<input type="hidden" class="course_mapping_id" value="'.$row['course_mapping_id'].'">';
        $course_department_batch_mapping_data.='<input type="hidden" class="course_id" value="'.$row['course_id'].'">';
        $course_department_batch_mapping_data.='<input type="hidden" class="mapping_id" value="'.$row['mapping_id'].'">';
        $course_department_batch_mapping_data.='<th scope="row">'.$row['course_name'].'</th>';
        $course_department_batch_mapping_data.='<td>'.$row['programme_name'].'-'.$row['department_name'].'</th>';
        $course_department_batch_mapping_data.='<td>'.$row['batch_name'].'</th>';
        $course_department_batch_mapping_data.='<input type="hidden" class="batch_id" value="'.$row['batch_id'].'">';
        $course_department_batch_mapping_data.='<td>'.$row['semester'].'</th>';
        $course_department_batch_mapping_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateMappingModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-cdb-mapping-button"><i class="fi fi-rr-trash"></i></button></td>';
        $course_department_batch_mapping_data.='</tr>';
    }
}

$select_course = 'select course_id,name from course';
$queryEXE = mysqli_query($connection,$select_course);
if($queryEXE->num_rows > 0){
	$course = '<option value="" selected disabled>Select Course</option>';
	while($row = mysqli_fetch_array($queryEXE)){
		$course.='<option value="'.$row['course_id'].'">'.$row['name'].'</option>';
	}
}

$department = '';
$department_query = "SELECT mpd.mapping_id,p.programme_name,d.name as department_name FROM mapping_program_department mpd join department d on d.department_id=mpd.department_id join programme p on p.programme_id=mpd.programme_id";
$queryEXE = mysqli_query($connection, $department_query);
if ($queryEXE->num_rows > 0) {
    $department .= '<option value="" selected disabled>Select Department</option>';
    while ($row = mysqli_fetch_array($queryEXE)) {
    $department .= '<option value="' . $row['mapping_id'] . '">' . $row['programme_name'].' - '.$row['department_name'] . '</option>';
    }
}

$select_batch = 'select batch_id,batch_name from batch';
$queryEXE = mysqli_query($connection,$select_batch);
if($queryEXE->num_rows > 0){
	$batch = '<option value="" selected disabled>Select Batch</option>';
	while($row = mysqli_fetch_array($queryEXE)){
		$batch.='<option value="'.$row['batch_id'].'">'.$row['batch_name'].'</option>';
	}
}


?>


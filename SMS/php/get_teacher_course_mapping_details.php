<?php
include '../config.php';
$select_teacher_course_mapping = 'select mtc.new_id,mcdb.course_mapping_id,l.user_id,l.name,mtc.section_id,c.name as course_name,d.name as department_name,b.batch_name,mcdb.semester,s.section_name from mapping_teacher_course mtc join login l on l.user_id=mtc.user_id '.
'join mapping_course_department_batch mcdb on mcdb.course_mapping_id=mtc.course_mapping_id '.
'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
'join course c on c.course_id=mcdb.course_id '. 
'join batch b on b.batch_id=mcdb.batch_id '.
'join department d on d.department_id=mpd.department_id '.
'join section s on s.section_id=mtc.section_id';

$queryEXE = mysqli_query($connection,$select_teacher_course_mapping);
if($queryEXE->num_rows > 0){
	$teacher_course_mapping_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
        $teacher_course_mapping_data.='<tr>';
        $teacher_course_mapping_data.='<input type="hidden" class="new_id" value="'.$row['new_id'].'">';
        $teacher_course_mapping_data.='<input type="hidden" class="user_id" value="'.$row['user_id'].'">';
        $teacher_course_mapping_data.='<input type="hidden" class="course_mapping_id" value="'.$row['course_mapping_id'].'">';
        $teacher_course_mapping_data.='<input type="hidden" class="section_id" value="'.$row['section_id'].'">';
		$teacher_course_mapping_data.='<th scope="row">'.$row['name'].'</th>';
		$teacher_course_mapping_data.='<td>'.$row['course_name'].'</th>';
		$teacher_course_mapping_data.='<td>'.$row['department_name'].'</th>';
		$teacher_course_mapping_data.='<td>'.$row['batch_name'].'</th>';
		$teacher_course_mapping_data.='<td>'.$row['semester'].'</th>';
        $teacher_course_mapping_data.='<td>'.$row['section_name'].'</th>';
        $teacher_course_mapping_data.= '<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateMappingModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-mapping-button"><i class="fi fi-rr-trash"></i></button></td>';
		$teacher_course_mapping_data.='</tr>';
	}
}

$select_user_data = "select user_id,name from login";
$queryEXE = mysqli_query($connection,$select_user_data);
if($queryEXE->num_rows > 0){
	$user_data = '<option selected value="">Select staff</option>';
	while($row = mysqli_fetch_array($queryEXE)){
		$user_data.='<option value="'.$row['user_id'].'">'.$row['name'].'</option>';
	}
}

$select_course_mapping_data = 'select mcdb.course_mapping_id,c.name as course_name,d.name as department_name,b.batch_name,mcdb.semester from mapping_course_department_batch mcdb join course c on c.course_id=mcdb.course_id '.
'join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id '.
'join department d on d.department_id=mpd.department_id '.
'join batch b on b.batch_id=mcdb.batch_id ';
$queryexe = mysqli_query($connection,$select_course_mapping_data);
if($queryexe->num_rows > 0){
	$course_mapping_data = '<option selected value="">select course</option>';
	while($row = mysqli_fetch_array($queryexe)){
		$course_mapping_data.='<option value="'.$row['course_mapping_id'].'">'.$row['course_name'].' - '.$row['department_name'].' - '.$row['batch_name'].' - '.$row['semester'].'</option>';
	}
}


$select_section_data = 'select * from section';
$queryEXE = mysqli_query($connection,$select_section_data);
    $section_data = 'option selected value="">Select Section</option>';
    while($row = mysqli_fetch_array($queryEXE)){
        $section_data.= '<option value="'.$row['section_id'].'">'.$row['section_name'].'</option>';
    }

?>

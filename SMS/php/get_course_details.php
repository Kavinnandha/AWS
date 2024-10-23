<?php
include '../master/config.php';
$select_course_data = "select c.course_id,c.name,t.type_id,t.type from course c join course_type t on t.type_id=c.type_id";
$queryEXE = mysqli_query($connection,$select_course_data);
if($queryEXE->num_rows > 0){
	$course_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
		$course_data.='<tr>';
		$course_data.='<th scope="row">'.$row['course_id'].'</th>';
		$course_data.='<td>'.$row['name'].'</td>';
        $course_data.='<td><input type="hidden" value="'.$row['type_id'].'" class="type_id">'.$row['type'].'</td>';
        $course_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateCourseModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-course-button"><i class="fi fi-rr-trash"></i></button></td>';
		$course_data.='</tr>';
    }
}
$select_course_type = 'select * from course_type';
$queryEXE = mysqli_query($connection,$select_course_type);
if($queryEXE->num_rows>0){
	$course_type = '<option value="" selected disabled>Select Course Type</option>';
	while($row = mysqli_fetch_array($queryEXE)){
        $course_type.='<option value="'.$row['type_id'].'">'.$row['type'].'</option>';
	}
}

?>

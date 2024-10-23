<?php
include '../../master/config.php';

$courses = $_POST['courses'];
foreach($courses as $course){
	$course_id = $course['course_id'];
	$course_name = $course['name'];
	$type = $course['type_id'];
	$insert_course = 'insert into course values("'.$course_id.'","'.$course_name.'","'.$type.'")';
	$queryEXE = mysqli_query($connection,$insert_course);
}
	echo '<script>alert("Details uploaded sucessfully");</script>';
        echo '<script>window.location.href = "../../master/database_upload/create_course.php"</script>';

?>


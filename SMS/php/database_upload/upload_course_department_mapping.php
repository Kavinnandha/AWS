<?php
include '../../master/config.php';
$course_id = $_POST['course_id'];
$mapping_id = $_POST['department_id'];
$batch_id = $_POST['batch_id'];
$semester = $_POST['semester'];
$insert_details = 'insert into mapping_course_department_batch(course_id,mapping_id,batch_id,semester) values("'.$course_id.'","'.$mapping_id.'","'.$batch_id.'","'.$semester.'")';
$queryEXE = mysqli_query($connection,$insert_details);
echo '<script>alert("Course department batch mapping created successfully!");window.location.href="../../master/database_upload/create_course_department_batch_mapping.php"</script>';
?>

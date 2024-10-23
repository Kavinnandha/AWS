<?php
include '../../master/config.php';
$programme_id = $_POST['programme_id'];
$department_id = $_POST['department_id'];
$insert_details = 'insert into mapping_program_department(programme_id,department_id) values("'.$programme_id.'","'.$department_id.'")';
$queryEXE = mysqli_query($connection,$insert_details);
echo '<script>alert("Details uploaded sucessfully");</script>';
echo '<script>window.location.href = "../../master/database_upload/create_program_department_mapping.php"</script>';

?>

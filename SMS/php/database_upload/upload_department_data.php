<?php
include '../../master/config.php';

$department_id = $_POST['department_id'];
$department_name = $_POST['department_name'];
$insert_department = 'insert into department values("'.$department_id.'","'.$department_name.'")';
$queryEXE = mysqli_query($connection,$insert_department);
echo '<script>alert("department details uploaded successfully!")</script>';
echo '<script>window.location.href = "../../master/database_upload/create_department.php"</script>';
?>


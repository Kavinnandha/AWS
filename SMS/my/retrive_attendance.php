<?php
include '../master/config.php';
$register_no = $_SESSION['register_no'];
$students_details = 'SELECT DISTINCT si.name as name,DATE_FORMAT(si.DOB,"%d-%m-%Y") as DOB,b.batch_name,p.programme_name,b.current_semester as sem,d.name as dname from student_information si join 
mapping_program_department mpd on mpd.mapping_id=si.mapping_id
join mapping_course_department_batch mcdb on mcdb.mapping_id=mpd.mapping_id
join batch b on b.batch_id=si.batch_id
join programme p on mpd.programme_id=p.programme_id
join department d on d.department_id = mpd.department_id
where si.register_no="'.$register_no.'" ';
$query = mysqli_query($connection, $students_details);
$row = mysqli_fetch_assoc($query);
$student_register = $register_no;
$student_name = $row['name'];
$current_sem = $row['sem'];
$student_dob = $row['DOB'];
$student_batch = $row['batch_name'];
$student_degree = $row['programme_name'].'.'.$row['dname'];
?>
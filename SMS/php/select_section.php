<?php
include '../master/config.php';
session_start();
if(isset($_POST['batch_id'])){
        $batch_id = $_POST['batch_id'];
        $user_id = $_SESSION['user_id'];
        $subject_details = "select DISTINCT s.section_id,s.section_name from section s join mapping_teacher_course mtc on mtc.section_id=s.section_id join mapping_course_department_batch mcdp on batch_id ='".$batch_id."'";
        $queryEXE = mysqli_query($connection,$subject_details);
        if ($queryEXE->num_rows>0) {
        $subjects = array();
        while($row = mysqli_fetch_array($queryEXE)){
            $subjects[] = $row;
        }
        echo json_encode($subjects);
        }
}
?>


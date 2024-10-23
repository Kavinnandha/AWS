<?php 

include '../../master/config.php';

if(isset($_POST['delete_id'])){
    $register_no = $_POST['delete_id'];
    $delete_query = 'delete from student_information where register_no="'.$register_no.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }
}else{
    $register_no = $_POST['register_no'];
    $name = $_POST['name'];
    $dob = $_POST['date'];
    $gender = $_POST['gender'];
    $boarding_status = $_POST['boarding_status'];
    $department_id = $_POST['department_id'];
    $select_mapping_id = 'select mapping_id from mapping_program_department where department_id="'.$department_id.'"';
    $queryEXE = mysqli_query($connection,$select_mapping_id);
    $mapping_id = mysqli_fetch_row($queryEXE)[0];
    $batch_id = $_POST['batch_id'];
    $section_id = $_POST['section_id'];
    $email = $_POST['email'];
    $update_query = 'update student_information set name="'.$name.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set dob="'.$dob.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set gender="'.$gender.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set boarding_status="'.$boarding_status.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set mapping_id="'.$mapping_id.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set batch_id="'.$batch_id.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set section_id="'.$section_id.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
$update_query = 'update student_information set email="'.$email.'" where register_no="'.$register_no.'"';
    $queryEXE = mysqli_query($connection,$update_query);
echo "success";
}

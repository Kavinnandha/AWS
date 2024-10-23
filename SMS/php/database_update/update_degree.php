<?php 
include '../../master/config.php';

if(isset($_POST['degree_id'])){
    $id = $_POST['degree_id'];
    $delete_query = 'delete from programme where programme_id="'.$id.'"';
    if(mysqli_query($connection,$delete_query)){
        echo "success";
    }else{
        echo "error";
    }   
}else{
$id = $_POST['id'];
$name = $_POST['name']; 
$duration = $_POST['duration'];
$semester = $_POST['semester'];

$update_name = 'update programme set programme_name="'.$name.'" where programme_id="'.$id.'"';
mysqli_query($connection,$update_name);
$update_duration = 'update programme set duration="'.$duration.'" where programme_id="'.$id.'"';
mysqli_query($connection,$update_duration);
$update_semester = 'update programme set no_of_semesters="'.$semester.'" where programme_id="'.$id.'"';
mysqli_query($connection,$update_semester);
}

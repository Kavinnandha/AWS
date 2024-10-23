<?php
include '../master/config.php';
$id = $_POST['id'];
$data = $_POST['status'];
$query = 'UPDATE certificates SET status = "'.$data.'" WHERE id = "'.$id.'"';
$result = mysqli_query($connection,$query);
if(isset($_POST['awarded_points'])){
$points_awarded = $_POST['awarded_points'];
$register_no = $_POST['register_no'];
$name = $_POST['name'];
$type = $_POST['type'];
$upload = 'INSERT INTO approved_certificates(event_name,points_awarded,register_no,type)VALUES("'.$name.'","'.$points_awarded.'","'.$register_no.'","'.$type.'")';
$result2 = mysqli_query($connection,$upload);
}
?>
<?php 
session_start();
include '../master/config.php';
if(isset($_POST['name'])){
$register_no = $_SESSION['register_no'];
$name = $_POST['name'];
$position = $_POST['position'];
$type = $_POST['type'];
$from_date = $_POST['From'];
$description = $_POST['des'];
$file = $_FILES['userFile']['tmp_name'];
$file_name = $_FILES['userFile']['name'];
$file_data = base64_encode(file_get_contents($file));
$upload = "INSERT into certificates(register_no,file_name,file_data,name,position_secured,held_date,type,description)values('$register_no','$file_name','$file_data','$name','$position','$from_date','$type','$description')";
$query=mysqli_query($connection,$upload);
echo '<script>alert("File uploaded successfully");</script>';
echo '<script> setTimeout(function() { window.location.href="homepage.php"; }, 1000); </script>';
}

<?php 
session_start();
include '../master/config.php';
if(isset($_POST['name'])){
$register_no = $_SESSION['register_no'];
$name = $_POST['name'];
$role = $_POST['role'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$type = $_POST['type'];
$description = $_POST['des'];
$file = $_FILES['userFile']['tmp_name'];
$file_name = $_FILES['userFile']['name'];
$file_data = base64_encode(file_get_contents($file));
$upload = "INSERT into certificates(register_no,file_name,file_data,name,role,held_date,type,description)values('$register_no','$file_name','$file_data','$name','$role','$to_date','$type','$description')";
$query=mysqli_query($connection,$upload);
echo '<script>alert("File uploaded successfully");</script>';
echo '<script> setTimeout(function() { window.location.href="homepage.php"; }, 1000); </script>';
}

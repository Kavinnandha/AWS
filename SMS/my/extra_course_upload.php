<?php 
session_start();
include '../master/config.php';
if(isset($_POST['name'])){
$register_no = $_SESSION['register_no'];
$name = $_POST['name'];
$description = $_POST['description'];
$type = $_POST['type'];
$issued_by = $_POST['issued'];
$file = $_FILES['userFile']['tmp_name'];
$file_name = $_FILES['userFile']['name'];
$file_data = base64_encode(file_get_contents($file));
$upload = "INSERT into certificates(register_no,file_name,file_data,name,description,issued_by,type)values('$register_no','$file_name','$file_data','$name','$description','$issued_by','$type')";
$query=mysqli_query($connection,$upload);
echo '<script>alert("File uploaded successfully");</script>';
echo '<script> setTimeout(function() { window.location.href="homepage.php"; }, 1000); </script>';
}

<?php
include '../master/config.php';
	session_start();
        if(isset($_POST['submit'])){
                $register_no = $_POST['register'];
                $password = $_POST['password'];
                $loginSQL="select register_no from student_information where register_no='".$register_no."' and password=PASSWORD('".$password."');";
                $loginEXE=mysqli_query($connection,$loginSQL);
		if ($loginEXE->num_rows==1){
			$_SESSION['register_no'] = mysqli_fetch_row($loginEXE)[0];
            header('Location: homepage.php');
        }else{
			echo "<script>alert('login failed please check username and password');
			window.location='index.php';
			</script>";
		}
        }

?>

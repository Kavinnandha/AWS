<?php
include 'master/config.php';
	session_start();

        if(isset($_POST['submit'])){
                $username = $_POST['username'];
		$password = $_POST['password'];
		if(is_numeric($username)){
			$loginSQL = 'select * from student_information where register_no="'.$username.'" and password=PASSWORD("'.$password.'")';
			$loginEXE=mysqli_query($connection,$loginSQL);
			if($loginEXE->num_rows == 1){
				$row = mysqli_fetch_array($loginEXE);
				$_SESSION['register_no'] = $row['register_no'];
				$_SESSION['role_id'] = '7';
				header('Location: my/homepage.php');
			}else{
			echo "<script>alert('login failed please check username and password');
			window.location='index.php';
			</script>";
		}

		}
		else{
			$loginSQL="select * from login where email_id='".$username."' and password=PASSWORD('".$password."')";
			$loginEXE=mysqli_query($connection,$loginSQL);
			if($loginEXE->num_rows == 1){
				$row = mysqli_fetch_array($loginEXE);
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['role_id'] = $row['role_id'];
                $role = $_SESSION['role_id'];
                if($role == 1){
                    header("Location: dashboard_hod.php");
                }else if($role == 6){
                    header("Location: dashboard_advisor.php");
                }else if($role == 0){
                    header("Location: dashboard_staff.php");
                }else if($role == 2){
					header("Location: dashboard_principal.php");
				}else if($role == 5){
					header("Location: dashboard_admin.php");
				}
                else{
                    header("Location: student_attendance.php");
                    }
			}else{
			echo "<script>alert('login failed please check username and password');
			window.location='index.php';
			</script>";
		}


		}
	}

?>

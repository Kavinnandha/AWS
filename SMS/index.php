<?php 
session_start();
    if(isset($_SESSION['user_id'])){
        $role = $_SESSION['role_id'];
        if($role==1){
        header('Location: dashboard_hod.php');
        }else if($role == 6){
        header('Location: dashboard_advisor.php');
        }else if($role == 0){
        header('Location: dashboard_staff.php');
        }else if($role == 5){
        header('Location: dashboard_admin.php');
        }
	}
	if(isset($_SESSION['register_no'])){
		header('Location: my/homepage.php');
	}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sri Shakthi Institute of Engineering and Technology</title>
    <link rel="icon" type="image/png" href="/SMS/master/images/collegelogo.png">
    <link href="master/css/login.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background-color: #e9ebe9;">

    <div class="card shadow-lg p-4" style="max-width: 475px; max-height: 500px; min-width: 400px; min-height: 350px;">
        <form action="login.php" method="POST">
            <div class="text-center mb-3 mt-4">
                <img src="master/images/siet.png" class="img-fluid" alt="Logo" style="max-width: 350px;">
            </div>
            <div class="text-center mb-4">
                <h5>SMS Login</h5>
            </div>
            <div class="form-group mb-4">
                <input type="text" class="form-control" placeholder=" " name="username" id="email" required>
                <label for="email" class="form-label">Email or Register no</label>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" placeholder=" " name="password" id="password" required>
                <label for="password" class="form-label">Password</label>
            </div>
            <div class="mb-5 text-end">
                <a href="forget_password.php" class="text-decoration-none">Forgot password?</a>
            </div>
            <div class="form-group mb-4">
                <button type="submit" class="btn btn-success w-100" name="submit" id="submit">Login</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-qRG5V1v4jPbxvGJFEHFp6S4vEQmnkUmOgCCPU6zZiMfkkrEcWprlBBRU0UgoyI3n" crossorigin="anonymous"></script>
</body>
</html>

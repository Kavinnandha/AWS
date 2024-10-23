<?php
include 'master/config.php';
include 'master/session.php';
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role_id'];

$sql = "SELECT name, email_id, designation FROM login WHERE user_id = '$user_id'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userName = $row['name'];
    $userEmail = $row['email_id'];
    $userDesig = $row['designation'];
    
} else {
    $userName = "Unknown";
    $userEmail = "Unknown";
    $userDesig = "Unknown";
     
}

$batch_name = $_SESSION['batch_name'] ?? 'default_batch_name'; 

$sqlSubjects = 'SELECT DISTINCT c.course_id, c.name 
                FROM course c 
                JOIN mapping_course_department_batch mcdb ON mcdb.course_id = c.course_id 
                JOIN mapping_teacher_course mtc ON mtc.course_mapping_id = mcdb.course_mapping_id 
                WHERE mtc.user_id = "' . $user_id . '"';
$resultSubjects = $connection->query($sqlSubjects);

$subjectDetails = "";
if ($resultSubjects->num_rows > 0) {
    while ($rowSubjects = $resultSubjects->fetch_assoc()) {
        $subjectDetails .= $rowSubjects['name'] . ", ";
    }
    $subjectDetails = rtrim($subjectDetails, ", ");
} else {
    $subjectDetails = "No subjects assigned";
}

$connection->close();

$error_msg = isset($_SESSION['error_msg']) ? $_SESSION['error_msg'] : '';
$success_msg = isset($_SESSION['success_msg']) ? $_SESSION['success_msg'] : '';

unset($_SESSION['error_msg']);
unset($_SESSION['success_msg']);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="master/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/sms/<?php if($role==0){ echo 'staff_dashboard.php';}else if($role==1){echo 'dashboard_hod.php';}else if($role==6){echo 'dashboard_advisor.php';} ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100 text-center profile-spacing">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Profile</h2>
                        <img src="master/images/profile-logo.png" alt="Profile Picture" class="img-fluid rounded-circle mt-4 mb-3">
                        <p class="text-muted"><?php echo $userName; ?></p>
                    </div>
                    <div class="card-footer border-0 bg-transparent">
                        <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
                    </div>
                    <div class="card-footer border-0 bg-transparent">
                        <a href="/sms/logout.php">
                            <button class="btn btn-success w-100">Logout</button>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card shadow-sm border-0 h-100 profile-spacing" id="content">
                    <div class="card-body">
                        <h2 class="card-title mb-4 text-center">User Details</h2>
                        <div class="mb-4">
                            <div class="row mb-3"> 
                                <div class="col-md-4"><strong>NAME:</strong></div>
                                <div class="col-md-8"><?php echo $userName; ?></div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4"><strong>EMAIL:</strong></div>
                                <div class="col-md-8"><?php echo $userEmail; ?></div>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-md-4"><strong>DESIGNATION:</strong></div>
                                <div class="col-md-8"><?php echo $userDesig; ?></div>
                            </div>
                          <!--  <div class="row mb-3"> 
                                <div class="col-md-4"><strong>HANDLING SUBJECTS:</strong></div>
                                <div class="col-md-8"><?php echo $subjectDetails; ?></div>
                            </div> -->
                        </div>
                        <br><br><hr>
                        <h4 class="text-center profile-spacing">Last Login</h4>
                        <div class="mt-4 text-center"> 
                            <h5>Last access to site:</h5>
                         
                      <!--     <p><?php echo $lastLoginDate; ?></p> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success_msg)): ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                    <?php endif; ?>

                    <form action="change_password.php" method="POST">
                        <div class="form-group mb-4">
                            <input type="password" class="form-control" id="currentPassword" name="current_password" required placeholder=" ">
                            <label for="currentPassword">Current Password</label>
                        </div>
                        <div class="form-group mb-4 position-relative">
                            <input type="password" class="form-control" id="newPassword" name="new_password" required placeholder=" ">
                            <label for="newPassword">New Password</label>
                            <span class="toggle-password position-absolute" onclick="togglePasswordVisibility('newPassword')">
                                <i class="fas fa-eye" id="toggleNewPasswordIcon"></i>
                            </span>
                        </div>

                        <div class="form-group mb-4 position-relative">
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required placeholder=" ">
                            <label for="confirmPassword">Confirm New Password</label>
                            <span class="toggle-password position-absolute" onclick="togglePasswordVisibility('confirmPassword')">
                                <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-success">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('password_changed')) {
            const passwordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            passwordModal.show();
        }

        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.querySelector(`#toggle${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}Icon`);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>

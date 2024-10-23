<!DOCTYPE html>
<html lang="en">
<?php include 'session.php';
include 'config.php';
$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];
$get_name = 'select name from login where user_id="' . $user_id . '"';
$query = mysqli_query($connection, $get_name);
$name = mysqli_fetch_row($query)[0];

$accessLevels = [
	'dashboard' => [0, 1, 2, 3, 4, 5, 6],
	'student_details' => [1],
	'db_upload' => [1, 2, 3, 4, 5],
	'attendance_approval' => [1, 2, 3, 4, 6]
];

function hasAccess($access, $role)
{
	global $accessLevels;
	return in_array($role, $accessLevels[$access]);
}
?>

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>SMS Dashboard</title>
	<link rel="icon" type="image/png" href="/sms/master/images/collegelogo.png">

	<!--icons-->
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
	<link rel="stylesheet" href="/sms/master/css/dashboard-styles.css" />
</head>

<body>
	<div class="sidebar close">
		<div class="logo"></div>

		<ul class="nav-list">
			<li class="<?php echo (
							$current_page == 'dashboard_staff.php' ||
							$current_page == 'dashboard_advisor.php' ||
							$current_page == 'dashboard_hod.php' ||
							$current_page == 'dashboard_principal.php' ||
							$current_page == 'dashboard_admin.php'
						) ? 'selected' : ''; ?>">
				<div class="main-link">
					<a href="<?php
								if ($role == 0) {
									echo '/sms/dashboard_staff.php';
								}
								if ($role == 6) {
									echo '/sms/dashboard_advisor.php';
								} else if ($role == 1) {
									echo '/sms/dashboard_hod.php';
								} else if ($role == 2) {
									echo '/sms/dashboard_principal.php';
								} else if ($role == 5) {
									echo '/sms/dashboard_admin.php';
								}
								?>">
						<i class="fi fi-rr-dashboard-panel"></i>
						<span class="link-name">Dashboard</span>
					</a>
					<ul class="sub-menu blank">
						<li><a href="#" class="link-name">Dashboard</a></li>
					</ul>
				</div>
			</li>
			<li class="<?php echo ($current_page == 'student_attendance.php') ? 'selected' : ''; ?>">
				<div class="main-link">
					<a href="/sms/student_attendance.php">
						<i class="fi fi-rr-id-badge"></i>
						<span class="link-name">Attendance</span>
					</a>

					<ul class="sub-menu blank">
						<li><a href="#" class="link-name ">Attendance</a></li>
					</ul>
				</div>
			</li>

			<?php if (hasAccess('student_details', $role)): ?>
				<li class="<?php echo ($current_page == 'create_student.php') ? 'selected' : ''; ?>">
					<div class="main-link">
						<a href="/sms/master/database_upload/create_student.php">
							<i class="fi fi-rr-user-graduate"></i>
							<span class="link-name">Student Details</span>
						</a>

						<ul class="sub-menu blank">
							<li><a href="#" class="link-name">Student Details</a></li>
						</ul>
					</div>
				</li>
			<?php endif; ?>

			<?php if (in_array($role, [2, 3, 4, 5])): ?>
				<li class="<?php echo (
								$current_page == 'create_teacher.php' ||
								$current_page == 'create_student.php' ||
								$current_page == 'create_department.php' ||
								$current_page == 'create_batch.php' ||
								$current_page == 'create_academic_year.php' ||
								$current_page == 'create_course.php' ||
								$current_page == 'create_degree.php'

							) ? 'selected' : ''; ?>">
					<div class="my-icon-link">
						<a data-page="menu2">
							<i class="fi fi-rr-folder-plus-circle"></i>
							<span class="link-name">Academic Info</span>
						</a>
						<i class="fi fi-rr-caret-down arrow"></i>
					</div>

					<ul class="sub-menu">
						<li><a class="link-name">Academic Information</a></li>

						<li><a href="/sms/master/database_upload/create_teacher.php">Staff</a></li>
						<li><a href="/sms/master/database_upload/create_student.php">Student</a></li>
						<li><a href="/sms/master/database_upload/create_batch.php">Batch</a></li>
						<li><a href="/sms/master/database_upload/create_academic_year.php">Academic Year</a></li>
						<li><a href="/sms/master/database_upload/create_course.php">Course</a></li>
						<li><a href="/sms/master/database_upload/create_department.php">Department</a></li>
						<li><a href="/sms/master/database_upload/create_degree.php">Programme</a></li>

					</ul>
				</li>
			<?php endif; ?>

			<?php if (hasAccess('db_upload', $role)): ?>
				<li class="<?php echo (
								$current_page == 'create_advisor_mapping.php' ||
								$current_page == 'create_hod_mapping.php' ||
								$current_page == 'create_teacher_course_mapping.php' ||
								$current_page == 'create_program_department_mapping.php' ||
								$current_page == 'create_course_department_batch_mapping.php'
							) ? 'selected' : ''; ?>">
					<div class="my-icon-link">
						<a data-page="menu2">
							<i class="fi fi-rr-track"></i>
							<span class="link-name">Mapping</span>
						</a>
						<i class="fi fi-rr-caret-down arrow"></i>
					</div>

					<ul class="sub-menu">
						<li><a class="link-name">Mapping</a></li>
						<?php if (in_array($role, [2, 3, 4, 5])): ?>
							<li><a href="/sms/master/database_upload/create_program_department_mapping.php">Programme department map</a></li>
							<li><a href="/sms/master/database_upload/create_hod_mapping.php">HOD-map</a></li>
						<?php endif; ?>
						<li><a href="/sms/master/database_upload/create_advisor_mapping.php">Advisor-map</a></li>
						<li><a href="/sms/master/database_upload/create_course_department_batch_mapping.php">Course department batch map</a></li>
						<li><a href="/sms/master/database_upload/create_teacher_course_mapping.php">Teacher course map</a></li>

					</ul>
				</li>
			<?php endif; ?>




			<li class="<?php echo ($current_page == 'get_report.php') ? 'selected' : ''; ?>">
				<div class="main-link">
					<a href="/sms/get_report.php">
						<i class="fi fi-rr-newspaper"></i>
						<span class="link-name">Report</span>
					</a>

					<ul class="sub-menu blank">
						<li><a href="#" class="link-name">Report</a></li>
					</ul>
				</div>
			</li>
			<?php if (!(in_array($role, [2, 3, 4]))): ?>
				<li class="<?php echo ($current_page == 'request_leave.php') ? 'selected' : ''; ?>">
					<div class="main-link">
						<a href="/sms/request_leave.php">
							<i class="fi fi-rr-member-list"></i>
							<span class="link-name">Leave Requests</span>
						</a>

						<ul class="sub-menu blank">
							<li><a href="#" class="link-name">Leave Requests</a></li>
						</ul>
					</div>
				</li>
			<?php endif; ?>
			<?php if (hasAccess('attendance_approval', $role)): ?>
				<li class="<?php echo ($current_page == 'leave_approvals.php') ? 'selected' : ''; ?>">
					<div class="main-link">
						<a href="/sms/leave_approvals.php">
							<i class="fi fi-rr-memo-circle-check"></i>
							<span class="link-name">Leave Approvals</span>
						</a>

						<ul class="sub-menu blank">
							<li><a href="#" class="link-name">Leave Approvals</a></li>
						</ul>
					</div>
				</li>
			<?php endif; ?>
			<?php if ($role == 1): ?>
				<li class="<?php echo ($current_page == 'achievements.php') ? 'selected' : ''; ?>">
					<div class="main-link">
						<a href="/sms/achievements.php">
							<i class="fi fi-rr-medal"></i>
							<span class="link-name">Achievements</span>
						</a>

						<ul class="sub-menu blank">
							<li><a href="#" class="link-name">Student Achievements</a></li>
						</ul>
					</div>
				</li>
			<?php endif; ?>
			<li class="<?php echo ($current_page == 'devinfo.php') ? 'selected' : ''; ?>">
				<div class="main-link">
					<a href="/sms/devinfo.php">
						<i class="fi fi-rr-department"></i>
						<span class="link-name">Team</span>
					</a>

					<ul class="sub-menu blank">
						<li><a href="#" class="link-name">Team</a></li>
					</ul>
				</div>
			</li>

		</ul>
	</div>

	<header class="header-section">
		<i class="fi fi-rr-bars-sort menu-icon" id="toggleSidebar"></i>

		<div class="right-icons">
			<p class="text"><?php echo $name ?></p>
			<a href="/sms/logout.php">
				<i class="fi fi-rr-sign-out-alt"></i>
			</a>
			<a href="/sms/profile.php" class="user-icon">
				<img src="/sms/master/images/profile-image-green.png" width="50px" height="50px" />
			</a>
		</div>
	</header>

	<div class="main-content"></div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="/sms/master/js/dashboard-script.js"></script>
</body>

</html>
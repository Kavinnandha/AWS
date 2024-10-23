<?php include '../config.php';

$select_teacher_data = 'select l.user_id,l.name,l.email_id,d.name as department_name,d.department_id,l.gender,l.designation,r.role_id,r.role_name from login l join department d on d.department_id=l.department_id join role r on r.role_id=l.role_id';
$queryEXE = mysqli_query($connection,$select_teacher_data);
if($queryEXE->num_rows>0){
	$teacher_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
        $teacher_data.='<tr>';
		$teacher_data.='<th scope="row"><input type="hidden" class="user_id" value="'.$row['user_id'].'">'.$row['name'].'</th>';
        $teacher_data.='<td>'.$row['email_id'].'</td>';
		$teacher_data.='<td><input type="hidden" class="department_id" value="'.$row['department_id'].'">'.$row['department_name'].'</td>';
		$teacher_data.='<td>'.$row['gender'].'</th>';
        $teacher_data.='<td>'.$row['designation'].'</td>';
        $teacher_data.='<td><input type="hidden" class="role_id" value="'.$row['role_id'].'">'.$row['role_name'].'</td>';
        $teacher_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateTeacherModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-teacher-button"><i class="fi fi-rr-trash"></i></button></td>';
		$teacher_data.='</tr>';
	}
}
$select_role = "select * from role";
$queryEXE = mysqli_query($connection,$select_role);
if($queryEXE->num_rows > 0){
	$role = '<option selected value="">select role</option>';
	while($row = mysqli_fetch_array($queryEXE)){
		$role.='<option value="'.$row['role_id'].'">'.$row['role_name'].'</option>';
	}
}

$department = '';
$department_query = "SELECT department_id, name FROM department";
$queryEXE = mysqli_query($connection, $department_query);
if ($queryEXE->num_rows > 0) {
    $department .= '<option value="" selected disabled>Select Department</option>';
    while ($row = mysqli_fetch_array($queryEXE)) {
	$department .= '<option value="' . $row['department_id'] . '">' . $row['name'] . '</option>';
    }
}


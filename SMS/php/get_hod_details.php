<?php
$user_id = $_SESSION['user_id'];
$user_table = '';
$get_user_table = 'select hm.hod_mapping_id,l.name,l.user_id,d.name as department_name,d.department_id from hod_mapping hm join login l on l.user_id = hm.user_id join department d on d.department_id=hm.department_id';
$queryEXE = mysqli_query($connection,$get_user_table);
while($row = mysqli_fetch_array($queryEXE)){
    $user_table.='<tr>';
    $user_table.='<input type="hidden" class="hod_mapping_id" value="'.$row['hod_mapping_id'].'">';
    $user_table.='<input type="hidden" class="user_id" value="'.$row['user_id'].'">';
    $user_table.='<th scope="row">'.$row['name'].'</th>';
    $user_table.='<input type="hidden" class="department_id" value="'.$row['department_id'].'">';
    $user_table.='<td>'.$row['department_name'].'</td>';
    $user_table.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateMappingModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-hod-mapping-button"><i class="fi fi-rr-trash"></i></button></td>';
    $user_table.='</tr>';
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

$select_users = 'select user_id,name from login';
$queryEXE = mysqli_query($connection,$select_users);
$users = '';
while($row = mysqli_fetch_array($queryEXE)){
	$users.='<option value="'.$row['user_id'].'">'.$row['name'].'</option>';
}



?>


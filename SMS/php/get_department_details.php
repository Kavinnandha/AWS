<?php
include '../config.php';
$select_department_information = 'select * from department';
$queryEXE = mysqli_query($connection,$select_department_information);
if($queryEXE->num_rows>0){
	$department_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
		$department_data.= '<tr data-id="'.$row['department_id'].'">';
		$department_data.='<th scope="row">'.$row['department_id'].'</th>';
		$department_data.='<td>'.$row['name'].'</th>';
		$department_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateDepartmentModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-department-button"><i class="fi fi-rr-trash"></i></button></td>';
		$department_data.='</tr>';
	}
}


<?php
$select_program_department_mapping = 'select mpd.mapping_id,p.programme_name,p.programme_id,d.name as department_name,d.department_id from mapping_program_department mpd join programme p on p.programme_id=mpd.programme_id join department d on d.department_id=mpd.department_id';
$queryEXE = mysqli_query($connection,$select_program_department_mapping);
if($queryEXE->num_rows >0){
	$program_department_mapping_data = '';
	$department_mapping_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
        $program_department_mapping_data.='<tr>';
        $program_department_mapping_data.='<input type="hidden" class="mapping_id" value="'.$row['mapping_id'].'">';
        $program_department_mapping_data.='<input type="hidden" class="programme_id" value="'.$row['programme_id'].'">';
        $program_department_mapping_data.='<input type="hidden" class="department_id" value="'.$row['department_id'].'">';
		$program_department_mapping_data.='<th scope="row">'.$row['programme_name'].'</th>';
        $program_department_mapping_data.='<td>'.$row['department_name'].'</th>';
        $program_department_mapping_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateMappingModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-program-department-mapping-button"><i class="fi fi-rr-trash"></i></button></td>';
		$program_department_mapping_data.='</tr>';
		$department_mapping_data.='<option value="'.$row['mapping_id'].'">'.$row['programme_name'].'-'.$row['department_name'].'</option>';
	}
}

$select_programme_details = 'select programme_id,programme_name from programme';
$queryEXE = mysqli_query($connection,$select_programme_details);
if($queryEXE->num_rows > 0){
	$programme = '<option value="" selected disabled>Select Programme</option>';
	while($row = mysqli_fetch_array($queryEXE)){
		$programme.='<option value="'.$row['programme_id'].'">'.$row['programme_name'].'</option>';
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


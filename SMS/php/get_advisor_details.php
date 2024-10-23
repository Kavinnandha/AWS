<?php 
$select_advisor_mapping_data = 'select am.advisor_mapping_id,l.name,l.user_id,d.name as department_name,p.programme_name,b.batch_name,b.batch_id,s.section_name,s.section_id,mpd.mapping_id from advisor_mapping am join login l on l.user_id=am.user_id join mapping_program_department mpd on mpd.mapping_id=am.mapping_id join department d on d.department_id=mpd.department_id join programme p on p.programme_id=mpd.programme_id join batch b on b.batch_id=am.batch_id join section s on s.section_id=am.section_id';
$queryEXE = mysqli_query($connection,$select_advisor_mapping_data);
$advisor_mapping_data = '';
while($row = mysqli_fetch_array($queryEXE)){
    $advisor_mapping_data.='<tr>';
    $advisor_mapping_data.='<input type="hidden" class="advisor_mapping_id" value="'.$row['advisor_mapping_id'].'">';
    $advisor_mapping_data.='<input type="hidden" class="user_id" value="'.$row['user_id'].'">';
    $advisor_mapping_data.='<th scope="row">'.$row['name'].'</th>';
    $advisor_mapping_data.='<input type="hidden" class="mapping_id" value="'.$row['mapping_id'].'">';
    $advisor_mapping_data.='<td>'.$row['programme_name'].'-'.$row['department_name'].'</td>';
    $advisor_mapping_data.='<input type="hidden" class="batch_id" value="'.$row['batch_id'].'">';
    $advisor_mapping_data.='<td>'.$row['batch_name'].'</td>';
    $advisor_mapping_data.='<input type="hidden" class="section_id" value="'.$row['section_id'].'">';
    $advisor_mapping_data.='<td>'.$row['section_name'].'</td>';
    $advisor_mapping_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateAdvisorModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-advisor-mapping-button"><i class="fi fi-rr-trash"></i></button></td>';
    $advisor_mapping_data.='</tr>';

}



$select_users = 'select user_id,name from login';
$queryEXE = mysqli_query($connection,$select_users);
$users = '';
while($row = mysqli_fetch_array($queryEXE)){
	$users.='<option value="'.$row['user_id'].'">'.$row['name'].'</option>';
}

$select_batch = 'select * from batch';
$queryEXE = mysqli_query($connection,$select_batch);
$batch = '';
while($row = mysqli_fetch_array($queryEXE)){
	$batch.='<option value="'.$row['batch_id'].'">'.$row['batch_name'].'</option>';
}

$select_section = 'select * from section';
$queryEXE = mysqli_query($connection,$select_section);
$section = '';
while($row = mysqli_fetch_array($queryEXE)){
	$section.='<option value="'.$row['section_id'].'">'.$row['section_name'].'</option>';
}

$select_program_department_mapping = 'select mpd.mapping_id,p.programme_name,d.name as department_name from mapping_program_department mpd join programme p on p.programme_id=mpd.programme_id join department d on d.department_id=mpd.department_id';
$queryEXE = mysqli_query($connection,$select_program_department_mapping);
if($queryEXE->num_rows >0){
	$program_department_mapping_data = '';
	$department_mapping_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
		$program_department_mapping_data.='<tr>';
		$program_department_mapping_data.='<th scope="row">'.$row['programme_name'].'</th>';
		$program_department_mapping_data.='<td>'.$row['department_name'].'</th>';
		$program_department_mapping_data.='</tr>';
		$department_mapping_data.='<option value="'.$row['mapping_id'].'">'.$row['programme_name'].'-'.$row['department_name'].'</option>';
	}
}


?>

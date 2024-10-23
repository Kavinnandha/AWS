<?php
include '../config.php';

$bulk_department = '<select name="department_id" class="form-select" aria-label="Select Department" required>';
$bulk_department.='<option selected value="">Select Department</option>';
$department = '<select name="department_id" class="form-select" id="editDepartment" aria-label="Select Department" required>';
$department_query = "SELECT department_id, name FROM department";
$queryEXE = mysqli_query($connection, $department_query);
if ($queryEXE->num_rows > 0) {
    while ($row = mysqli_fetch_array($queryEXE)) {
        $department .= '<option value="' . $row['department_id'] . '">' . $row['name'] . '</option>';
        $bulk_department .= '<option value="' . $row['department_id'] . '">' . $row['name'] . '</option>';
    }
}
$department .= '</select>';
$bulk_department .='</select>';

$bulk_batch = '<select name="batch_id" class="form-select" aria-label="Select Batch" required>';
$bulk_batch.='<option selected value="">Select Batch</option>';
$batch = '<select name="batch_id" class="form-select" id="editBatch" aria-label="Select Batch" required>';
$batch_query = "SELECT batch_id, batch_name FROM batch";
$queryEXE = mysqli_query($connection, $batch_query);
if ($queryEXE->num_rows > 0) {
    while ($row = mysqli_fetch_array($queryEXE)) {
        $batch .= '<option value="' . $row['batch_id'] . '">' . $row['batch_name'] . '</option>';
        $bulk_batch .= '<option value="' . $row['batch_id'] . '">' . $row['batch_name'] . '</option>';
    }
}
$batch .= '</select>';
$bulk_batch .='</select>';

$section = '<select name="section_id" id="editSection" class="form-select" aria-label="Select Section" required>';
$bulk_section = '<select name="section_id" class="form-select" aria-label="Select Section" required>';
$bulk_section.='<option selected value="">Select Section</option>';
$section_query = "SELECT section_id, section_name FROM section";
$queryEXE = mysqli_query($connection, $section_query);
if ($queryEXE->num_rows > 0) {
    $section .= '';
    while ($row = mysqli_fetch_array($queryEXE)) {
        $section .= '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
        $bulk_section .= '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
    }
}
$section .= '</select>';
$bulk_section .= '</select>';

$departmentModal = '<select name="students[0][department]" class="form-select" aria-label="Select Department">';
                                        $department_query = "SELECT department_id, name FROM department";
                                        $queryEXE = mysqli_query($connection, $department_query);
                                        if ($queryEXE->num_rows > 0) {
                                            $departmentModal .= '<option selected disabled>Select Department</option>';
                                            while ($row = mysqli_fetch_array($queryEXE)) {
                                                $departmentModal .= '<option value="' . $row['department_id'] . '">' . $row['name'] . '</option>';
                                            }
                                        }
                                        $departmentModal .= '</select>';
 $batchModal = '<select name="students[0][batch]" class="form-select" aria-label="Select Batch">';
                                        $batch_query = "SELECT batch_id, batch_name FROM batch";
                                        $queryEXE = mysqli_query($connection, $batch_query);
                                        if ($queryEXE->num_rows > 0) {
                                            $batchModal .= '<option selected disabled>Select Batch</option>';
                                            while ($row = mysqli_fetch_array($queryEXE)) {
                                                $batchModal .= '<option value="' . $row['batch_id'] . '">' . $row['batch_name'] . '</option>';
                                            }
                                        }
                                        $batchModal .= '</select>';
 $sectionModal = '<select name="students[0][section_id]" class="form-select" aria-label="Select Section">';
                                        $section_query = "SELECT section_id, section_name FROM section";
                                        $queryEXE = mysqli_query($connection, $section_query);
                                        if ($queryEXE->num_rows > 0) {
                                            $sectionModal .= '<option selected disabled>Select Section</option>';
                                            while ($row = mysqli_fetch_array($queryEXE)) {
                                                $sectionModal .= '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
                                            }
                                        }
                                        $sectionModal .= '</select>';



$select_student_information = 'select si.register_no,si.email,si.name as name,DATE_FORMAT(si.DOB,"%e-%c-%Y") as DOB,si.gender,si.boarding_status,d.name as department,d.department_id,se.section_name as section,se.section_id,b.batch_name as batch,b.batch_id,p.programme_name as programme,p.programme_id from student_information si '.
'join mapping_program_department mpd on mpd.mapping_id=si.mapping_id '.
'join department d on d.department_id=mpd.department_id '.
'join batch b on b.batch_id=si.batch_id '.
'join section se on se.section_id=si.section_id '.
'join programme p on p.programme_id=mpd.programme_id ';
$queryEXE = mysqli_query($connection,$select_student_information);
if($queryEXE->num_rows>0){
	$data = '';
	while($row = mysqli_fetch_array($queryEXE)){
		$data.= '<tr>';
		$data.='<th scope="row">'.$row['register_no'].'</th>';
		$data.='<td>'.$row['name'].'</th>';
		$data.='<td>'.$row['email'].'</th>';
		$data.='<td>'.$row['DOB'].'</th>';
		$data.='<td>'.$row['gender'].'</th>';
		if($row['boarding_status'] == "H"){
			$data.='<td>Hosteller</th>';
		}else{
			$data.='<td>Day Scholar</th>';
		}
		$data.='<td><input type="hidden" value="'.$row['department_id'].'" class="department_id">'.$row['department'].'</th>';
		$data.='<td><input type="hidden" value="'.$row['section_id'].'" class="section_id">'.$row['section'].'</th>';
		$data.='<td><input type="hidden" value="'.$row['batch_id'].'" class="batch_id">'.$row['batch'].'</th>';
        $data.='<td><input type="hidden" value="'.$row['programme_id'].'" class="programme_id">'.$row['programme'].'</th>';
        $data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateStudentModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-student-button"><i class="fi fi-rr-trash"></i></button></td>';
		$data.='</tr>';

		}
	}
else{
	$data = "No student information found";
}

?>

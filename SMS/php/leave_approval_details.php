<?php
include 'master/config.php';

$user_id = $_SESSION['user_id'];

// Advisor Leave Data
$get_leave_details = 'SELECT lr.reference_id, lr.remark, si.name, lr.start_date, lr.end_date, lr.no_of_days, at_type.description AS request_for, lr.reason, lr.out_time, lr.in_time 
                      FROM leave_record lr 
                      JOIN student_information si ON si.register_no = lr.reference_id 
                      JOIN attendance_type at_type ON at_type.type_id = lr.type_id 
                      JOIN advisor_mapping am ON am.mapping_id = si.mapping_id AND am.batch_id = si.batch_id AND am.section_id = si.section_id 
                      WHERE reference_id > 714000000000 AND am.user_id = "' . $user_id . '" AND lr.status_id = 0';
$queryEXE = mysqli_query($connection, $get_leave_details);
$advisor_leave_data = '<table class="table table-bordered mt-4">
                        <thead>
                            <tr class="text-center">
                                <th>Name-Register no</th>
                                <th>Request For</th>
                                <th>No of Days</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Reason</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
if ($queryEXE->num_rows > 0) {
	while ($row = mysqli_fetch_array($queryEXE)) {
		$advisor_leave_data .= '<form method="POST" action="php/update_advisor_leave_status.php">';
		$advisor_leave_data .= '<input type="hidden" name="reference_id" value="' . $row['reference_id'] . '">';
		$advisor_leave_data .= '<input type="hidden" name="start_date" value="' . $row['start_date'] . '">';
		$advisor_leave_data .= '<input type="hidden" name="end_date" value="' . $row['end_date'] . '">';
		$advisor_leave_data .= '<tr>
                                    <td>' . $row['name'] . '-' . $row['reference_id'] . '</td>
                                    <td>' . $row['request_for'] . '</td>
                                    <td>' . $row['no_of_days'] . '</td>
                                    <td>' . $row['start_date'] . ' - ' . $row['out_time'] . '</td>
                                    <td>' . $row['end_date'] . ' - ' . $row['in_time'] . '</td>
                                    <td>' . $row['reason'] . '</td>
                                    <td><input type="text" name="remark" placeholder="Remark" class="form-control" value="' . $row['remark'] . '"></td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-3">
                                            <button name="action" value="Accepted" class="btn btn-success btn-sm" type="submit">Accept</button>
                                            <button name="action" value="Rejected" class="btn btn-danger btn-sm" type="submit">Reject</button>
                                        </div>
                                    </td>
                                </tr>';
		$advisor_leave_data .= '</form>';
	}
} else {
	$advisor_leave_data = '<h4 class="text-center">No Leave requests pending</h4>';
}


$get_hod_leave_details = 'SELECT lr.reference_id, lr.remark, si.name, lr.start_date, lr.end_date, lr.no_of_days, at_type.description AS request_for, lr.reason, lr.out_time, lr.in_time 
                          FROM leave_record lr 
                          JOIN student_information si ON si.register_no = lr.reference_id 
                          JOIN attendance_type at_type ON at_type.type_id = lr.type_id 
                          JOIN mapping_program_department mpd ON mpd.mapping_id = si.mapping_id 
                          JOIN hod_mapping hm ON hm.department_id = mpd.department_id 
                          WHERE lr.reference_id > 714000000000 AND lr.status_id = 1 AND hm.user_id = "' . $user_id . '"';
$queryEXE = mysqli_query($connection, $get_hod_leave_details);
$hod_leave_data = '<table class="table table-bordered mt-4">
                    <thead>
                        <tr class="text-center">
                            <th>Name-Register no</th>
                            <th>Request For</th>
                            <th>No of Days</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Reason</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
if ($queryEXE->num_rows > 0) {
	while ($row = mysqli_fetch_array($queryEXE)) {
		$hod_leave_data .= '<form method="POST" action="php/update_hod_leave_status.php">';
		$hod_leave_data .= '<input type="hidden" name="reference_id" value="' . $row['reference_id'] . '">';
		$hod_leave_data .= '<input type="hidden" name="start_date" value="' . $row['start_date'] . '">';
		$hod_leave_data .= '<input type="hidden" name="end_date" value="' . $row['end_date'] . '">';
		$hod_leave_data .= '<tr>
                                <td>' . $row['name'] . '-' . $row['reference_id'] . '</td>
                                <td>' . $row['request_for'] . '</td>
                                <td>' . $row['no_of_days'] . '</td>
                                <td>' . $row['start_date'] . ' - ' . $row['out_time'] . '</td>
                                <td>' . $row['end_date'] . ' - ' . $row['in_time'] . '</td>
                                <td>' . $row['reason'] . '</td>
                                <td><input type="text" name="remark" placeholder="Remark" class="form-control" value="' . $row['remark'] . '"></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-3">
                                        <button name="action" value="Accepted" class="btn btn-success btn-sm" type="submit">Accept</button>
                                        <button name="action" value="Rejected" class="btn btn-danger btn-sm" type="submit">Reject</button>
                                        <button name="action" value="Accepted and Upward" class="btn btn-info btn-sm" type="submit">Forward to Principal</button>
                                    </div>
                                </td>
                            </tr>';
		$hod_leave_data .= '</form>';
	}
	$hod_leave_data .= '</tbody></table>';
} else {
	$hod_leave_data = '<h4 class="text-center">No Leave requests pending</h4>';
}


$get_faculty_leave_data = 'SELECT lr.reference_id, lr.remark, l.name, lr.start_date, lr.end_date, lr.no_of_days, at_type.description AS request_for, lr.reason, lr.out_time, lr.in_time 
                           FROM leave_record lr 
                           JOIN login l ON l.user_id = lr.reference_id 
                           JOIN attendance_type at_type ON at_type.type_id = lr.type_id 
                           WHERE reference_id < 714000000000 AND lr.status_id = 0 AND l.role_id NOT IN (1,2,3,4)';
$queryEXE = mysqli_query($connection, $get_faculty_leave_data);
$faculty_leave_data = '<table class="table table-bordered mt-4">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Request For</th>
                                <th>No of Days</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Reason</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
if ($queryEXE->num_rows > 0) {
	while ($row = mysqli_fetch_array($queryEXE)) {
		$faculty_leave_data .= '<form method="POST" action="php/update_hod_leave_status.php">';
		$faculty_leave_data .= '<input type="hidden" name="reference_id" value="' . $row['reference_id'] . '">';
		$faculty_leave_data .= '<input type="hidden" name="start_date" value="' . $row['start_date'] . '">';
		$faculty_leave_data .= '<input type="hidden" name="end_date" value="' . $row['end_date'] . '">';
		$faculty_leave_data .= '<tr>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . $row['request_for'] . '</td>
                                    <td>' . $row['no_of_days'] . '</td>
                                    <td>' . $row['start_date'] . ' - ' . $row['out_time'] . '</td>
                                    <td>' . $row['end_date'] . ' - ' . $row['in_time'] . '</td>
                                    <td>' . $row['reason'] . '</td>
                                    <td><input type="text" name="remark" placeholder="Remark" class="form-control" value="' . $row['remark'] . '"></td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-3">
                                            <button name="action" value="Accepted" class="btn btn-success btn-sm" type="submit">Accept</button>
                                            <button name="action" value="Rejected" class="btn btn-danger btn-sm" type="submit">Reject</button>
                                            <button name="action" value="Accepted and Upward" class="btn btn-info btn-sm" type="submit">Forward to Principal</button>
                                        </div>
                                    </td>
                                </tr>';
		$faculty_leave_data .= '</form>';
	}
	$faculty_leave_data .= '</tbody></table>';
} else {
	$faculty_leave_data = '<h4 class="text-center">No Leave requests pending</h4>';
}


$get_faculty_leave_data_principal = 'SELECT d.name AS department_name, lr.reference_id, lr.remark, l.name, lr.start_date, lr.end_date, lr.no_of_days, at_type.description AS request_for, lr.reason, lr.out_time, lr.in_time 
                           FROM leave_record lr 
                           JOIN login l ON l.user_id = lr.reference_id 
                           JOIN attendance_type at_type ON at_type.type_id = lr.type_id
						   JOIN department d ON l.department_id = d.department_id 
                           WHERE reference_id < 714000000000 AND lr.status_id = 5';
$queryEXE = mysqli_query($connection, $get_faculty_leave_data_principal);
$faculty_leave_data_principal = '<table class="table table-bordered mt-4">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
								<th>Department</th>
                                <th>Request For</th>
                                <th>Duration</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Reason</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
if ($queryEXE->num_rows > 0) {
	while ($row = mysqli_fetch_array($queryEXE)) {
		$faculty_leave_data_principal .= '<form method="POST" action="php/update_hod_leave_status.php">';
		$faculty_leave_data_principal .= '<input type="hidden" name="reference_id" value="' . $row['reference_id'] . '">';
		$faculty_leave_data_principal .= '<input type="hidden" name="start_date" value="' . $row['start_date'] . '">';
		$faculty_leave_data_principal .= '<input type="hidden" name="end_date" value="' . $row['end_date'] . '">';
		$faculty_leave_data_principal .= '<tr>
                                    <td>' . $row['name'] . '</td>
									<td>' . $row['department_name'] . '</td>
                                    <td>' . $row['request_for'] . '</td>
                                    <td>' . $row['no_of_days'] . '</td>
                                    <td>' . $row['start_date'] . ' - ' . $row['out_time'] . '</td>
                                    <td>' . $row['end_date'] . ' - ' . $row['in_time'] . '</td>
                                    <td>' . $row['reason'] . '</td>
                                    <td><input type="text" name="remark" placeholder="Remark" class="form-control" value="' . $row['remark'] . '"></td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-3">
                                            <button name="action" value="Accepted" class="btn btn-success btn-sm" type="submit">Accept</button>
                                            <button name="action" value="Rejected" class="btn btn-danger btn-sm" type="submit">Reject</button>
                                        </div>
                                    </td>
                                </tr>';
		$faculty_leave_data_principal .= '</form>';
	}
	$faculty_leave_data_principal .= '</tbody></table>';
} else {
	$faculty_leave_data_principal = '<h4 class="text-center">No Leave requests pending</h4>';
}


$student_leave_principal = 'SELECT d.name AS department_name, lr.reference_id, lr.remark, si.name, lr.start_date, lr.end_date, lr.no_of_days, at_type.description AS request_for, lr.reason, lr.out_time, lr.in_time 
                            FROM leave_record lr 
                            JOIN student_information si ON si.register_no = lr.reference_id 
                            JOIN attendance_type at_type ON at_type.type_id = lr.type_id 
                            JOIN mapping_program_department mpd ON mpd.mapping_id = si.mapping_id 
							JOIN department d ON mpd.department_id = d.department_id
                            WHERE lr.status_id = 5';
$queryEXE = mysqli_query($connection, $student_leave_principal);
$student_leave_data_principal = '<table class="table table-bordered mt-4">
                    <thead>
                        <tr class="text-center">
                            <th>Name-Register no</th>
							<th>Department</th>
                            <th>Request For</th>
                            <th>Duration</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Reason</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
if ($queryEXE->num_rows > 0) {
	while ($row = mysqli_fetch_array($queryEXE)) {
		$student_leave_data_principal .= '<form method="POST" action="php/update_hod_leave_status.php">';
		$student_leave_data_principal .= '<input type="hidden" name="reference_id" value="' . $row['reference_id'] . '">';
		$student_leave_data_principal .= '<input type="hidden" name="start_date" value="' . $row['start_date'] . '">';
		$student_leave_data_principal .= '<input type="hidden" name="end_date" value="' . $row['end_date'] . '">';
		$student_leave_data_principal .= '<tr>
                                <td>' . $row['name'] . '-' . $row['reference_id'] . '</td>
								<td>'  . $row['department_name'] . '</td>
                                <td>' . $row['request_for'] . '</td>
                                <td>' . $row['no_of_days'] . '</td>
                                <td>' . $row['start_date'] . ' - ' . $row['out_time'] . '</td>
                                <td>' . $row['end_date'] . ' - ' . $row['in_time'] . '</td>
                                <td>' . $row['reason'] . '</td>
                                <td><input type="text" name="remark" placeholder="Remark" class="form-control" value="' . $row['remark'] . '"></td>
                                <td>
                                    <div class="d-flex justify-content-end gap-3">
                                        <button name="action" value="Accepted" class="btn btn-success btn-sm" type="submit">Accept</button>
                                        <button name="action" value="Rejected" class="btn btn-danger btn-sm" type="submit">Reject</button>
                                    </div>
                                </td>
                            </tr>';
		$student_leave_data_principal .= '</form>';
	}
	$student_leave_data_principal .= '</tbody></table>';
} else {
	$student_leave_data_principal = '<h4 class="text-center">No Leave requests pending</h4>';
}
$get_student_leave_history = 'select lr.reference_id,lr.remark,si.name,lr.start_date,lr.end_date,lr.no_of_days,at_type.description as request_for,lr.reason,lr.out_time,lr.in_time,ls.name as status from leave_record lr join student_information si on si.register_no=lr.reference_id join leave_status ls on ls.status_id=lr.status_id join attendance_type at_type on at_type.type_id=lr.type_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id join hod_mapping hm on hm.department_id=mpd.department_id where (lr.status_id=7 or lr.status_id=8) and hm.user_id="'.$user_id.'"';

$student_leave_history = '';
$queryEXE = mysqli_query($connection,$get_student_leave_history);
if($queryEXE->num_rows > 0){
    while($row = mysqli_fetch_array($queryEXE)){
        $student_leave_history.= '<tr><td>'.$row['name'].'-'.$row['reference_id'].'</td>';
        $student_leave_history.= '<td>'.$row['request_for'].'</td>';
        $student_leave_history.= '<td>'.$row['no_of_days'].'</td>';
        $student_leave_history.= '<td>'.$row['start_date'].'</td>';
        $student_leave_history.= '<td>'.$row['end_date'].'</td>';
        $student_leave_history.= '<td>'.$row['reason'].'</td>';
        $student_leave_history.= '<td>'.$row['remark'].'</td>';
        $student_leave_history.= '<td>'.$row['status'].'</td>';
        $student_leave_history.='</tr>';
        }
}

$get_staff_leave_history = 'select lr.remark,l.name,lr.start_date,lr.end_date,lr.no_of_days,at_type.description as request_for,lr.reason,lr.out_time,lr.in_time,ls.name as status from leave_record lr join login l on l.user_id=lr.reference_id join leave_status ls on ls.status_id=lr.status_id join attendance_type at_type on at_type.type_id=lr.type_id join hod_mapping hm on hm.department_id=l.department_id where (lr.status_id=7 or lr.status_id=8) and hm.user_id="'.$user_id.'"';
$staff_leave_history = '';
$queryEXE = mysqli_query($connection,$get_staff_leave_history);
if($queryEXE->num_rows > 0){
    while($row = mysqli_fetch_array($queryEXE)){
        $staff_leave_history.= '<tr><td>'.$row['name'].'</td>';
        $staff_leave_history.= '<td>'.$row['request_for'].'</td>';
        $staff_leave_history.= '<td>'.$row['no_of_days'].'</td>';
        $staff_leave_history.= '<td>'.$row['start_date'].'</td>';
        $staff_leave_history.= '<td>'.$row['end_date'].'</td>';
        $staff_leave_history.= '<td>'.$row['reason'].'</td>';
        $staff_leave_history.= '<td>'.$row['remark'].'</td>';
        $staff_leave_history.= '<td>'.$row['status'].'</td>';
        $staff_leave_history.='</tr>';
        }
}

$get_student_history_advisor = 'select lr.reference_id,lr.remark,si.name,lr.start_date,lr.end_date,lr.no_of_days,at_type.description as request_for,lr.reason,lr.out_time,lr.in_time,ls.name as status from leave_record lr join student_information si on si.register_no=lr.reference_id join leave_status ls on ls.status_id=lr.status_id join attendance_type at_type on at_type.type_id=lr.type_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id join advisor_mapping am on am.mapping_id = mpd.mapping_id  where lr.status_id in (1,2) and am.user_id="'.$user_id.'"';
 $advisor_student_leave_history = '';
$queryEXE = mysqli_query($connection,$get_student_history_advisor);
if($queryEXE->num_rows > 0){
    while($row = mysqli_fetch_array($queryEXE)){
        $advisor_student_leave_history.= '<tr><td>'.$row['name'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['request_for'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['no_of_days'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['start_date'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['end_date'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['reason'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['remark'].'</td>';
        $advisor_student_leave_history.= '<td>'.$row['status'].'</td>';
        $advisor_student_leave_history.='</tr>';
        }
}


?>


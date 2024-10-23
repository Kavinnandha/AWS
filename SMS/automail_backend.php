<?php include 'master/config.php';
$department_query = 'SELECT * FROM department';
$query = mysqli_query($connection,$department_query);
$data = '';
while($row = mysqli_fetch_array($query)){
    $department_id = $row['department_id'];
    $department_name = $row['name'];
    $data.='<table width="100%" cellpadding="0" cellspacing="0" border="1" style="margin-top: 20px;">';
    $data.='<thead>';
    $data.='<tr>';
    $data.='<th>Batch</th>';
    $data.='<th>Department</th>';
    $data.='<th colspan="2">Strength</th>';
    $data.='<th>Boarding status</th>';
    $data.='<th>Present</th>';
    $data.='<th>Absent</th>';
    $data.='<th>OnDuty</th>';
    $data.='</tr>';
    $data.='</thead>';
    $data.='<tbody>';
    $batch_query = 'select distinct b.batch_name, b.batch_id from batch b left join student_information si on si.batch_id=b.batch_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where mpd.department_id="'.$department_id.'"';
    $query_1 = mysqli_query($connection,$batch_query);
    while($batchrow = mysqli_fetch_array($query_1)){
    $batch_id = $batchrow['batch_id'];
    $batch_name = $batchrow['batch_name'];
    $queries = [
    'total_girls_absent_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="F" and si.boarding_status="D" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_girls_present_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="F" and si.boarding_status="D" and a.status=1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_girls_onduty_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="F" and si.boarding_status="D" and a.status=-1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_boys_absent_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="M" and si.boarding_status="D" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_boys_present_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="M" and si.boarding_status="D" and a.status=1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_boys_onduty_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="M" and si.boarding_status="D" and a.status=-1 and mpd.department_id="'.$department_id.'" and s.period=1',


'total_girls_absent_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="F" and si.boarding_status="H" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_girls_present_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="F" and si.boarding_status="H" and a.status=1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_girls_onduty_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="F" and si.boarding_status="H" and a.status=-1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_boys_absent_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="M" and si.boarding_status="H" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_boys_present_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="M" and si.boarding_status="H" and a.status=1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_boys_onduty_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.gender="M" and si.boarding_status="H" and a.status=-1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_absent_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.boarding_status="D" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_present_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.boarding_status="D" and a.status=1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_onduty_d' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.boarding_status="D" and a.status=-1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_absent_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.boarding_status="H" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_present_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.boarding_status="H" and a.status=1 and mpd.department_id="'.$department_id.'" and s.period=1',

'total_onduty_h' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and si.boarding_status="H" and a.status=-1 and mpd.department_id="'.$department_id.'" and s.period=1',



'total_absent' => 'select count(DISTINCT si.register_no) from attendance a join student_information si on a.register_no=si.register_no join session s on s.session_id=a.session_id join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where s.date_of_session=CURDATE() and si.batch_id="'.$batch_id.'" and a.status=0 and mpd.department_id="'.$department_id.'" and s.period=1',


'total_boys' => 'select count(DISTINCT si.register_no) from student_information si join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where si.batch_id="'.$batch_id.'" and si.gender="M" and mpd.department_id="'.$department_id.'" ',


'total_girls' => 'select count(DISTINCT si.register_no) from student_information si join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where si.batch_id="'.$batch_id.'" and si.gender="F" and mpd.department_id="'.$department_id.'" ',


'total' => 'select count(DISTINCT si.register_no) from student_information si join mapping_program_department mpd on mpd.mapping_id=si.mapping_id where si.batch_id="'.$batch_id.'" and mpd.department_id="'.$department_id.'" ',
];

foreach ($queries as $key => $sql_query) {
    $result = mysqli_query($connection, $sql_query);
    
    if (!$result) {
        die('Error in query: ' . mysqli_error($connection));
    }

    $$key = mysqli_fetch_row($result)[0];
    
}
$data .= '<tr>';
$data .= '<th rowspan="6">'.$batch_name.'</th>';
$data .= '<td rowspan="6">'.$department_name.'</td>';

$data .= '<th rowspan="2">Boys</th>';
$data .= '<td rowspan="2">' . $total_boys . '</td>';
$data .= '<td>Dayscholar</td>';
$data .= '<td>' . $total_boys_present_d . '</td>';
$data .= '<td>' . $total_boys_absent_d . '</td>';
$data .= '<td>' . $total_boys_onduty_d . '</td>';
$data .= '</tr>';
$data .= '<tr><td>Hosteler</td>';
$data .= '<td>' . $total_boys_present_h . '</td>';
$data .= '<td>' . $total_boys_absent_h . '</td>';
$data .= '<td>' . $total_boys_onduty_h . '</td>';
$data .= '</tr>';

$data .= '<tr><th rowspan="2">Girls</th>';
$data .= '<td rowspan="2">' . $total_girls . '</td>';
$data .= '<td>Dayscholar</td>';
$data .= '<td>' . $total_girls_present_d . '</td>';
$data .= '<td>' . $total_girls_absent_d . '</td>';
$data .= '<td>' . $total_girls_onduty_d . '</td>';
$data .= '</tr>';
$data .= '<tr><td>Hosteler</td>';
$data .= '<td>' . $total_girls_present_h . '</td>';
$data .= '<td>' . $total_girls_absent_h . '</td>';
$data .= '<td>' . $total_girls_onduty_h . '</td>';
$data .= '</tr>';

$data .= '<tr><th rowspan="2">Total</th>';
$data .= '<td rowspan="2">' . $total . '</td>';
$data .= '<td>Dayscholar</td>';
$data .= '<td>' . $total_present_d . '</td>';
$data .= '<td>' . $total_absent_d . '</td>';
$data .= '<td>' . $total_onduty_d . '</td>';
$data .= '</tr>';
$data .= '<tr><td>Hosteler</td>';
$data .= '<td>' . $total_present_h . '</td>';
$data .= '<td>' . $total_absent_h . '</td>';
$data .= '<td>' . $total_onduty_h . '</td>';
$data .= '</tr>';
$data .='<tr>';
$data .= '<td colspan="7">'.'<strong>Total Absent: </strong>'.$total_absent.'</td>';
$data .='</tr>';
}
$data .= '</tbody>';
$data .= '</table>';
}
?>

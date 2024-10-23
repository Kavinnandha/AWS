<?php

$user_id = $_SESSION['user_id'];

// Student_Leave_requests
$sql = "SELECT si.name, lr.reason, lr.no_of_days
        FROM leave_record lr 
        JOIN student_information si ON si.register_no = lr.reference_id 
        JOIN attendance_type at_type ON at_type.type_id = lr.type_id 
        JOIN advisor_mapping am ON am.mapping_id = si.mapping_id 
          AND am.batch_id = si.batch_id 
          AND am.section_id = si.section_id 
        WHERE lr.reference_id > 714000000000 
          AND am.user_id = '$user_id' 
          AND lr.status_id = 0";

$result = mysqli_query($connection, $sql);
$leave_requests = "";

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $leave_requests .= '<tr>';
        $leave_requests .= '<td style="white-space: nowrap;">' . $row['name'] . '</td>';
        $leave_requests .= '<td>' . $row['no_of_days'] . '</td>';
        $leave_requests .= '<td>' . $row['reason'] . '</td>';
    }
}
else {
    $leave_requests .= '<tr><td colspan="3" class="text-center">No Leave Requests</td></tr>';
}

// Attendance Period Report
$user_sql = "
    SELECT 
        l.department_id, 
        am.batch_id, 
        am.section_id
    FROM 
        login l
    JOIN 
        advisor_mapping am ON l.user_id = am.user_id
    WHERE 
        l.user_id = '$user_id'
";

$user_result = mysqli_query($connection, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);

$department_id = $user_data['department_id'];
$batch_id = $user_data['batch_id'];
$section_id = $user_data['section_id'];

$attendance_sql = "
    SELECT 
        s.period AS period_no,
        s.no_of_present AS present,
        s.no_of_absent AS absent,
        s.no_of_od AS od,
        GROUP_CONCAT(DISTINCT CASE WHEN a.status = '0' THEN si.name END SEPARATOR ', ') AS absent_names,
        GROUP_CONCAT(DISTINCT CASE WHEN a.status = '-1' THEN si.name END SEPARATOR ', ') AS od_names
    FROM 
        session s
    JOIN 
        attendance a ON s.session_id = a.session_id 
    JOIN 
        student_information si ON a.register_no = si.register_no
    JOIN 
        mapping_course_department_batch mcd ON si.batch_id = mcd.batch_id AND si.section_id = mcd.section_id
    JOIN 
        mapping_program_department mpd ON mpd.mapping_id = mcd.mapping_id
    WHERE 
        s.date_of_session = CURDATE()
        AND mcd.batch_id = '$batch_id'
        AND mcd.section_id = '$section_id'
        AND mpd.department_id = '$department_id'
    GROUP BY 
        s.period
    ORDER BY 
        s.period;
";


$attendance_result = mysqli_query($connection, $attendance_sql);
$attendance_rows = '';

if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
    while ($data = mysqli_fetch_assoc($attendance_result)) {
        $attendance_rows .= '<tr>';
        $attendance_rows .= '<th>' . $data['period_no'] . '</th>';
        $attendance_rows .= '<td>' . $data['present'] . '</td>';
        $attendance_rows .= '<td>' . $data['absent'] . '</td>';
        $attendance_rows .= '<td>' . $data['od'] . '</td>';
        $attendance_rows .= '<td>' . (!empty($data['absent_names']) ? $data['absent_names'] : 'None') . '</td>';
        $attendance_rows .= '<td>' . (!empty($data['od_names']) ? $data['od_names'] : 'None') . '</td>';
        $attendance_rows .= '</tr>';
    }
} else {
    $attendance_rows = '<tr><td colspan="6" class="text-center">No attendance records found for today.</td></tr>';
}

$select_latest_date = 'select max(date_of_session) as date_of_session from session';
$queryEXE = mysqli_query($connection, $select_latest_date);
$row = mysqli_fetch_array($queryEXE);
$date = new DateTime($row['date_of_session']);
$date->sub(new DateInterval('P2D'));
$start_date = $date->format('Y-m-d');
$end_date = date('Y-m-d', strtotime('0 day'));

$missed_attendance_sql = "
WITH RECURSIVE DateGenerator AS (
    SELECT 
        '$start_date' AS date_of_session
    UNION ALL
    SELECT 
        DATE_ADD(date_of_session, INTERVAL 1 DAY)
    FROM 
        DateGenerator
    WHERE 
        DATE_ADD(date_of_session, INTERVAL 1 DAY) <= '$end_date'
),
PeriodGenerator AS (
    SELECT period
    FROM (SELECT 1 AS period UNION ALL SELECT 2 UNION ALL SELECT 3 
          UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 
          UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS periods
)

SELECT 
    dg.date_of_session, 
    GROUP_CONCAT(pg.period ORDER BY pg.period) AS periods
FROM 
    DateGenerator dg
CROSS JOIN 
    PeriodGenerator pg
LEFT JOIN 
    (SELECT s.date_of_session, s.period
     FROM session s
     LEFT JOIN mapping_teacher_course mtc ON mtc.new_id = s.new_id
     LEFT JOIN mapping_course_department_batch mcd ON mcd.course_mapping_id = mtc.course_mapping_id
     LEFT JOIN mapping_program_department mpd ON mpd.mapping_id = mcd.mapping_id
     WHERE mtc.section_id = $section_id
       AND mcd.batch_id = $batch_id
       AND mpd.department_id = $department_id) AS existing
ON 
    dg.date_of_session = existing.date_of_session AND pg.period = existing.period
WHERE 
    existing.date_of_session IS NULL
GROUP BY 
    dg.date_of_session
ORDER BY 
    dg.date_of_session DESC;
";

$missed_attendance_result = mysqli_query($connection, $missed_attendance_sql);
$missed_attendance_rows = "";

if ($missed_attendance_result) {
    if (mysqli_num_rows($missed_attendance_result) > 0) {
        while ($data = mysqli_fetch_assoc($missed_attendance_result)) {
            $missed_attendance_rows .= '<tr>';
            $missed_attendance_rows .= '<td>' . $data['date_of_session'] . '</td>';
            $missed_attendance_rows .= '<td>' . $data['periods'] . '</td>';
            $missed_attendance_rows .= '</tr>';
        }
    } else {
        $missed_attendance_rows = '<tr><td colspan="2" class="text-center">No Missed Attendance</td></tr>';
    }
} else {
    $missed_attendance_rows = '<tr><td colspan="2" class="text-center">Error in Query: ' . mysqli_error($connection) . '</td></tr>';
}

$get_low_attendance_details = 'SELECT si.register_no, si.name, (SUM(CASE WHEN status = 1 THEN 1 ELSE (CASE WHEN status = -1 THEN 1 ELSE 0 END) END) / COUNT(a.status)) * 100 as attendance_percentage FROM attendance a JOIN session s ON s.session_id = a.session_id JOIN mapping_teacher_course mtc ON mtc.new_id = s.new_id JOIN student_information si ON si.register_no = a.register_no JOIN mapping_program_department mpd ON mpd.mapping_id = si.mapping_id JOIN advisor_mapping am ON am.mapping_id = mpd.mapping_id WHERE am.user_id =6 GROUP BY register_no having attendance_percentage < 75 ORDER BY `attendance_percentage`';

$queryEXE = mysqli_query($connection,$get_low_attendance_details);
if($queryEXE -> num_rows > 0){
    $low_attendance_data = '';
    while($row = mysqli_fetch_array($queryEXE)){
        $low_attendance_data.='<tr>';
        $low_attendance_data.='<td>'.$row['register_no'].'</td>';
        $low_attendance_data.='<td>'.$row['name'].'</td>';
        $low_attendance_data.='<td>'.$row['attendance_percentage'].'</td>';
    }
}else{
    $low_attendance_data = 'data not found';
}


// Attendance dips - Advisor

$attendance_dips_advisor_sql = "
    SELECT DISTINCT
	    mcd.course_id,
	    SUM(s.no_of_present) AS total_present,
        SUM(s.no_of_absent) AS total_absent,
        SUM(s.no_of_od) AS total_od

    FROM 
	    mapping_course_department_batch mcd
    JOIN
	    mapping_teacher_course mtc ON mtc.course_mapping_id = mcd.course_mapping_id
    JOIN
	    mapping_program_department mpd ON mpd.mapping_id = mcd.mapping_id
    JOIN 
	    session s ON s.new_id = mtc.new_id
    WHERE 
	    mcd.mapping_id = (SELECT DISTINCT 
						        si.mapping_id 
					        FROM 
                      	        student_information si 
					        JOIN 
							    mapping_program_department mpd ON mpd.mapping_id = si.mapping_id 
                            WHERE 
							    batch_id = $batch_id
                      		    AND section_id = $section_id
							    AND department_id = $department_id)
							
        AND mcd.batch_id = $batch_id
        AND mpd.department_id = $department_id
    GROUP BY
	    mcd.course_id
";

$attendance_dips_advisor_result = mysqli_query($connection, $attendance_dips_advisor_sql);
$attendance_dips_advisor_rows = "";

$labels = [];
$data = [];


if (mysqli_num_rows($attendance_dips_advisor_result) > 0) {
    while ($row = mysqli_fetch_assoc($attendance_dips_advisor_result)) {
        $labels[] = $row["course_id"];
        $attendance_percentage = ($row["total_present"] / ($row['total_present'] + $row['total_absent'] + $row['total_od']) * 100);
        $data[] = round($attendance_percentage, 3); 
    }
}

$labels_json = json_encode($labels);
$data_json = json_encode($data);

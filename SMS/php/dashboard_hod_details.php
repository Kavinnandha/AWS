<?php
$user_id = $_SESSION['user_id'];

$user_sql = "
    SELECT 
        l.department_id
    FROM 
        login l
    WHERE 
        l.user_id = '$user_id'
";

$user_result = mysqli_query($connection, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);

$department_id = $user_data['department_id'];

// Total Students
$total_students_sql = "
    SELECT 
        COUNT(register_no) AS total_students
    FROM 
        student_information si
    JOIN 
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
    WHERE 
        mpd.department_id = $department_id;
";

$total_students_result = mysqli_query($connection, $total_students_sql);
$row = mysqli_fetch_array($total_students_result);
$total_students = $row['total_students'];

// Total Absent, Present and ON Duty
$total_attendance_sql = "
    SELECT 
    COUNT(DISTINCT CASE WHEN a.status = 0 THEN a.register_no END) AS total_absent,
    COUNT(DISTINCT CASE WHEN a.status = -1 THEN a.register_no END) AS total_od,
    COUNT(DISTINCT CASE WHEN a.status = 1 AND a.register_no NOT IN (
        SELECT a2.register_no
        FROM attendance a2
        JOIN session s2 ON a2.session_id = s2.session_id
        WHERE 
            s2.date_of_session = CURDATE() 
            AND mpd.department_id = $department_id
            AND (a2.status = 0 OR a2.status = -1)
    ) THEN a.register_no END) AS total_present
    FROM 
        session s
    JOIN 
        attendance a ON s.session_id = a.session_id
    JOIN 
        mapping_teacher_course mtc ON s.new_id = mtc.new_id
    JOIN 
        mapping_course_department_batch mcdb ON mtc.course_mapping_id = mcdb.course_mapping_id
    JOIN 
        mapping_program_department mpd ON mcdb.mapping_id = mpd.mapping_id
    WHERE 
        s.date_of_session = CURDATE() 
        AND mpd.department_id = $department_id;

";

$total_attendance_result = mysqli_query($connection, $total_attendance_sql);
$row = mysqli_fetch_array($total_attendance_result);
$total_absent = $row["total_absent"];
$total_present = $row["total_present"];
$total_od = $row["total_od"];

// Student Leave Requests
$student_leave_sql = "
    SELECT 
        si.name, lr.no_of_days, lr.reason
    FROM 
        leave_record lr
    JOIN 
        student_information si ON si.register_no = lr.reference_id
    JOIN 
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
    JOIN 
        hod_mapping hm ON hm.department_id = mpd.department_id
    WHERE  
        lr.reference_id > 714000000000 
        AND lr.status_id = 1 
        AND hm.user_id = $user_id
";

$student_leave_result = mysqli_query($connection, $student_leave_sql);
$student_leave_requests = "";


if ($student_leave_result && mysqli_num_rows($student_leave_result) > 0) {
    $student_leave_requests .= "<thead><th>Name</th><th>Days</th><th>Reason</th>";
    while ($row = mysqli_fetch_array($student_leave_result)) {
        $student_leave_requests .= "<tr>";
        $student_leave_requests .= "<td>" . $row["name"] . "</td>";
        $student_leave_requests .= "<td>" . $row["no_of_days"] . "</td>";
        $student_leave_requests .= "<td>" . $row["reason"] . "</td>";
        $student_leave_requests .= "</tr>";
    }
} else {
    $student_leave_requests .= "No Student leave requests";
}

// Faculty Leave Requests
$faculty_leave_sql = "
    SELECT 
        l.name, lr.no_of_days, lr.reason
    FROM 
        leave_record lr
    JOIN 
        login l ON l.user_id = lr.reference_id
    JOIN 
        attendance_type at_type ON at_type.type_id = lr.type_id
    WHERE 
        lr.reference_id < 714000000000 
        AND lr.status_id = 0 
        AND l.role_id NOT IN (1, 2, 3, 4)
";

$faculty_leave_result = mysqli_query($connection, $faculty_leave_sql);
$faculty_leave_requests = "";


if ($faculty_leave_result && mysqli_num_rows($faculty_leave_result) > 0) {
    $faculty_leave_requests .= "<thead><th>Name</th><th>Days</th><th>Reason</th>";
    while ($row = mysqli_fetch_array($faculty_leave_result)) {
        $faculty_leave_requests .= "<tr>";
        $faculty_leave_requests .= "<td>" . $row["name"] . "</td>";
        $faculty_leave_requests .= "<td>" . $row["no_of_days"] . "</td>";
        $faculty_leave_requests .= "<td>" . $row["reason"] . "</td>";
        $faculty_leave_requests .= "</tr>";
    }
} else {
    $faculty_leave_requests .= "No faculty leave requests";
}


// Attendance Period Report
$attendance_sql = "
    SELECT 
        b.batch_name,
        si.section_id,
        s.period AS period_no,
        s.no_of_present AS present,
        s.no_of_absent AS absent,
        s.no_of_od AS od,
        GROUP_CONCAT(DISTINCT CASE WHEN a.status = '0' THEN si.name END SEPARATOR ', ') AS absent_names,
        GROUP_CONCAT(DISTINCT CASE WHEN a.status = '-1' THEN si.name END SEPARATOR ', ') AS od_names
    FROM 
        session s
    LEFT JOIN 
        attendance a ON s.session_id = a.session_id 
    LEFT JOIN 
        student_information si ON a.register_no = si.register_no
    LEFT JOIN 
        batch b ON b.batch_id = si.batch_id
    JOIN
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
    WHERE 
        s.date_of_session = CURDATE()
        AND mpd.department_id = $department_id
    GROUP BY 
        s.period, b.batch_id
    ORDER BY 
        s.period, b.batch_id;
";


$attendance_result = mysqli_query($connection, $attendance_sql);
$attendance_rows = '';

if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
    while ($data = mysqli_fetch_assoc($attendance_result)) {
        $attendance_rows .= '<tr>';
        $attendance_rows .= '<td>'. $data['batch_name'] . '</td>';    
        $attendance_rows .= '<td>'. $data['section_id'] . '</td>';
        $attendance_rows .= '<th>' . $data['period_no'] . '</th>';
        $attendance_rows .= '<td>' . $data['present'] . '</td>';
        $attendance_rows .= '<td>' . $data['absent'] . '</td>';
        $attendance_rows .= '<td>' . $data['od'] . '</td>';
        $attendance_rows .= '<td>' . (!empty($data['absent_names']) ? $data['absent_names'] : 'None') . '</td>';
        $attendance_rows .= '<td>' . (!empty($data['od_names']) ? $data['od_names'] : 'None') . '</td>';
        $attendance_rows .= '</tr>';
    }
} else {
    $attendance_rows = '<tr><td colspan="8" class="text-center">No attendance records found for today.</td></tr>';
}

$get_low_attendance_details = 'SELECT si.register_no, si.name, (SUM(CASE WHEN status = 1 THEN 1 ELSE (CASE WHEN status = -1 THEN 1 ELSE 0 END) END) / COUNT(a.status)) * 100 as attendance_percentage FROM attendance a JOIN session s ON s.session_id = a.session_id JOIN mapping_teacher_course mtc ON mtc.new_id = s.new_id JOIN student_information si ON si.register_no = a.register_no JOIN mapping_program_department mpd ON mpd.mapping_id = si.mapping_id JOIN hod_mapping hm ON hm.department_id = mpd.department_id WHERE hm.user_id ="'.$user_id.'" GROUP BY register_no having attendance_percentage < 75 ORDER BY `attendance_percentage` ';
$queryEXE = mysqli_query($connection,$get_low_attendance_details);
$low_attendance_data = '';
if($queryEXE->num_rows > 0){
    while($row = mysqli_fetch_array($queryEXE)){
        $low_attendance_data.='<tr>';
        $low_attendance_data.='<td>'.$row['register_no'].'</td>';
        $low_attendance_data.='<td>'.$row['name'].'</td>';
        $low_attendance_data.='<td>'.$row['attendance_percentage'].'</td>';
    }
}else{
    $low_attendance_data = 'No data found';
}

$get_requests = 'select request_id,request,reference_id from requests where status=0 and reference_id > 714000000000';
$queryEXE = mysqli_query($connection,$get_requests);
if($queryEXE->num_rows > 0){
    $student_feedback = '<table class="table table-borderless">';
    while($row = mysqli_fetch_array($queryEXE)){
            $student_feedback.= '<tr><form method="post" action="php/submit_request.php">';
            $student_feedback.='<input type="hidden" name="request_id" value="'.$row['request_id'].'">';
            $student_feedback.='<td>'.$row['request'].'</td>';
            $student_feedback.='<td><button type="submit" value="submit" class="btn btn-success">Fixed</button>';
            $student_feedback.='</form></tr>';
        }
}else{
    $student_feedback = 'No student requests';
}



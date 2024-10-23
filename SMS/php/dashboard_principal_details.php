<?php
$user_id = $_SESSION['user_id'];

// Total faculty
$total_faculty_sql = "
    SELECT
        COUNT(user_id) AS total_faculty
    FROM 
        login l
    WHERE
        l.role_id NOT IN (1, 2, 3, 4)
";
$total_faculty_result = mysqli_query($connection, $total_faculty_sql);
$total_faculty_row = mysqli_fetch_array($total_faculty_result);
$total_faculty = $total_faculty_row["total_faculty"];

// Total Absent, Present and On Duty - Faculty
$attendance_faculty_sql = "
    SELECT 
    (SELECT COUNT(*) 
     FROM login l 
     WHERE l.user_id NOT IN (
         SELECT lr.reference_id 
         FROM leave_record lr 
         WHERE CURRENT_DATE BETWEEN lr.start_date AND lr.end_date 
           AND lr.status_id = 7
     ) 
     AND l.role_id NOT IN (1, 2, 3, 4)
    ) AS Present,
     
    (SELECT COUNT(*)
     FROM leave_record lr 
     JOIN login l ON l.user_id = lr.reference_id
     WHERE lr.type_id = 2 
       AND CURRENT_DATE BETWEEN lr.start_date AND lr.end_date 
       AND lr.status_id = 7 
       AND l.role_id NOT IN (1, 2, 3, 4)
    ) AS Absent,
             
    (SELECT COUNT(*)
     FROM leave_record lr 
     JOIN login l ON l.user_id = lr.reference_id
     WHERE lr.type_id = 3 
       AND CURRENT_DATE BETWEEN lr.start_date AND lr.end_date 
       AND lr.status_id = 7 
       AND l.role_id NOT IN (1, 2, 3, 4)
    ) AS OnDuty
FROM 
    leave_record lr
RIGHT JOIN 
    login l ON l.user_id = lr.reference_id
WHERE 
    l.role_id NOT IN (1, 2, 3, 4)
";


$attendance_faculty_result = mysqli_query($connection, $attendance_faculty_sql);
$attendance_faculty_row = mysqli_fetch_array($attendance_faculty_result);
$faculty_present = $attendance_faculty_row["Present"];
$faculty_absent = $attendance_faculty_row["Absent"];
$faculty_onduty = $attendance_faculty_row["OnDuty"];

// Total Students
$total_students_sql = "
    SELECT 
        COUNT(register_no) AS total_students
    FROM 
        student_information
";

$total_students_result = mysqli_query($connection, $total_students_sql);
$row = mysqli_fetch_array($total_students_result);
$total_students = $row['total_students'];

// Total Absent, Present and On Duty - Student
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
            AND (a2.status = 0 OR a2.status = -1)
    ) THEN a.register_no END) AS total_present
    FROM 
        session s
    JOIN 
        attendance a ON s.session_id = a.session_id
    WHERE 
        s.date_of_session = CURDATE() 
";

$total_attendance_result = mysqli_query($connection, $total_attendance_sql);
$row = mysqli_fetch_array($total_attendance_result);
$student_absent = $row["total_absent"];
$student_present = $row["total_present"];
$student_onduty = $row["total_od"];


// Faculty Leave Requests
$faculty_leave_sql = "
    SELECT 
        l.name, lr.no_of_days, lr.reason, d.name AS department_name, at_type.description
    FROM 
        leave_record lr
    JOIN 
        login l ON l.user_id = lr.reference_id
    JOIN
        department d ON l.department_id = d.department_id
    JOIN 
        attendance_type at_type ON at_type.type_id = lr.type_id
    WHERE 
        lr.reference_id < 714000000000 
        AND lr.status_id = 5
";

$faculty_leave_result = mysqli_query($connection, $faculty_leave_sql);
$faculty_leave_requests = "";


if ($faculty_leave_result && mysqli_num_rows($faculty_leave_result) > 0) {
    $faculty_leave_requests .= "<thead><tr><th>Name</th><th>Department</th><th>Type</th><th>Duration</th><th>Reason</th></tr></thead>";
    while ($row = mysqli_fetch_array($faculty_leave_result)) {
        $faculty_leave_requests .= "<tbody><tr>";
        $faculty_leave_requests .= "<td>" . $row["name"] . "</td>";
        $faculty_leave_requests .= "<td>" . $row["department_name"] . "</td>";
        $faculty_leave_requests .= "<td>" . ($row["description"] == "Absent" ? "Leave" : $row["description"]) . "</td>";
        $faculty_leave_requests .= "<td>" . $row["no_of_days"] . "</td>";
        $faculty_leave_requests .= "<td>" . $row["reason"] . "</td>";
        $faculty_leave_requests .= "</tr></tbody>";
    }
} else {
    $faculty_leave_requests .= "No faculty leave requests";
}


// Student Leave Requests
$student_leave_sql = "
    SELECT 
        si.name, lr.no_of_days, lr.reason, d.name AS department_name, at_type.description
    FROM 
        leave_record lr
    JOIN 
        student_information si ON si.register_no = lr.reference_id
    JOIN 
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
    JOIN 
        department d ON mpd.department_id = d.department_id
    JOIN 
        attendance_type at_type ON lr.type_id = at_type.type_id
    WHERE  
        lr.reference_id > 714000000000 
        AND lr.status_id = 5
";

$student_leave_result = mysqli_query($connection, $student_leave_sql);
$student_leave_requests = "";

if ($student_leave_result && mysqli_num_rows($student_leave_result) > 0) {
    $student_leave_requests .= "<thead><tr><th>Name</th><th>Department</th><th>Type</th><th>Duration</th><th>Reason</th></tr></thead><tbody>";
    while ($row = mysqli_fetch_array($student_leave_result)) {
        $student_leave_requests .= "<tr>";
        $student_leave_requests .= "<td>" . $row["name"] . "</td>";
        $student_leave_requests .= "<td>" . $row["department_name"] . "</td>";
        $student_leave_requests .= "<td>" . ($row["description"] == "Absent" ? "Leave" : $row["description"]) . "</td>";
        $student_leave_requests .= "<td>" . $row["no_of_days"] . "</td>";
        $student_leave_requests .= "<td>" . $row["reason"] . "</td>";
        $student_leave_requests .= "</tr>";
    }
    $student_leave_requests .= "</tbody>";
} else {
    $student_leave_requests .= "<p>No student leave requests.</p>";
}

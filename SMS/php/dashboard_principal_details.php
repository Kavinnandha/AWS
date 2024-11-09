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
$total_students_all = $row['total_students'];

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
        s.date_of_session = CURDATE();
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

$total_students_sql = "
    SELECT 
        mpd.department_id,
        COUNT(si.register_no) AS total_students
    FROM 
        student_information si
    JOIN 
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
    GROUP BY 
        mpd.department_id;
";

$total_students_result = mysqli_query($connection, $total_students_sql);

$total_students_by_department = [];
while ($row = mysqli_fetch_assoc($total_students_result)) {
    $total_students_by_department[$row['department_id']] = $row['total_students'];
}

$student_attendance_modal_sql = "
    SELECT 
        d.name AS department_name,count(a.register_no) as total_strength,
        mpd.department_id,b.batch_name,
        COUNT(DISTINCT CASE WHEN a.status = 0 THEN a.register_no END) AS total_absent,
        COUNT(DISTINCT CASE WHEN a.status = -1 THEN a.register_no END) AS total_od,
        COUNT(DISTINCT CASE WHEN a.status = 1 
            AND a.register_no NOT IN (
                SELECT a2.register_no
                FROM attendance a2
                JOIN session s2 ON a2.session_id = s2.session_id
                JOIN mapping_teacher_course mtc2 ON s2.new_id = mtc2.new_id
                JOIN mapping_course_department_batch mcdb2 ON mtc2.course_mapping_id = mcdb2.course_mapping_id
                JOIN mapping_program_department mpd2 ON mcdb2.mapping_id = mpd2.mapping_id
                WHERE 
                    s2.date_of_session = CURDATE() 
                    AND (a2.status = 0 OR a2.status = -1)
                    AND mpd2.department_id = mpd.department_id
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
    JOIN 
        department d ON d.department_id = mpd.department_id
    JOIN
        batch b on b.batch_id = mcdb.batch_id
    WHERE 
        s.date_of_session = CURDATE()
    GROUP BY 
        mcdb.batch_id
 ";

$student_attendance_modal_result = mysqli_query($connection, $student_attendance_modal_sql);
$student_attendance_modal = "";

if ($student_attendance_modal_result && mysqli_num_rows($student_attendance_modal_result) > 0) {
    while ($row = mysqli_fetch_array($student_attendance_modal_result)) {
        $department_id = $row["department_id"];
        $total_absent = $row["total_absent"];
        $total_od = $row["total_od"];
        
        $total_students = $total_students_by_department[$department_id] ?? 0;

        $student_attendance_modal .= "<tr>";
        $student_attendance_modal .= "<td>" . $row['department_name'] .' - '.$row['batch_name']. "</td>";
        $student_attendance_modal .= "<td>".$row['total_strength']."</td>";
        $student_attendance_modal .= "<td>" . $row['total_present'] . "</td>";
        $student_attendance_modal .= "<td>" . $total_absent . "</td>";
        $student_attendance_modal .= "<td>" . $total_od . "</td>";
        $student_attendance_modal .= "</tr>";
    }
} else {
    $student_attendance_modal .= "<p>No attendance data found</p>";
}

$attendance_faculty_sql = "
    SELECT 
        l.department_id,d.name as department_name,
        
        (SELECT COUNT(*) 
         FROM login l_inner 
         WHERE l_inner.user_id NOT IN (
             SELECT lr_inner.reference_id 
             FROM leave_record lr_inner 
             WHERE CURRENT_DATE BETWEEN lr_inner.start_date AND lr_inner.end_date 
               AND lr_inner.status_id = 7
         ) 
         AND l_inner.role_id NOT IN (1, 2, 3, 4) 
         AND l_inner.department_id = l.department_id
        ) AS Present,

        (SELECT COUNT(*)
         FROM leave_record lr 
         JOIN login l_inner ON l_inner.user_id = lr.reference_id
         WHERE lr.type_id = 2 
           AND CURRENT_DATE BETWEEN lr.start_date AND lr.end_date 
           AND lr.status_id = 7 
           AND l_inner.role_id NOT IN (1, 2, 3, 4)
           AND l_inner.department_id = l.department_id
        ) AS Absent,

        (SELECT COUNT(*)
         FROM leave_record lr 
         JOIN login l_inner ON l_inner.user_id = lr.reference_id
         WHERE lr.type_id = 3 
           AND CURRENT_DATE BETWEEN lr.start_date AND lr.end_date 
           AND lr.status_id = 7 
           AND l_inner.role_id NOT IN (1, 2, 3, 4)
           AND l_inner.department_id = l.department_id
        ) AS OnDuty

    FROM 
        login l
    JOIN 
        department d on d.department_id = l.department_id
    WHERE 
        l.role_id NOT IN (1, 2, 3, 4)
    GROUP BY 
        l.department_id
";

$result = mysqli_query($connection, $attendance_faculty_sql);

$faculty_attendance_modal = '';
while ($row = mysqli_fetch_assoc($result)) {
    $faculty_attendance_modal .= "
        <tr>
            <td>" . $row['department_name'] . "</td>
            <td>" . $row['Present'] . "</td>
            <td>" . $row['Absent'] . "</td>
            <td>" . $row['OnDuty'] . "</td>
        </tr>
    ";
}

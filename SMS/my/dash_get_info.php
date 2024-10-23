<?php
include '../master/config.php';
session_start();
$register_no = $_SESSION['register_no'];
$select_section = "SELECT section_id,batch_id FROM student_information where register_no = '".$register_no."'";
$query = mysqli_query($connection,$select_section);
$section_batch = mysqli_fetch_array($query);
$section = $section_batch['section_id'];
$batch = $section_batch['batch_id'];
$query = "SELECT COUNT(status) as overall_status,
                 SUM(CASE WHEN status = 1 THEN 0 ELSE
                           (CASE WHEN status = -1 THEN 0 ELSE 1 END) END) as overall_attend 
          FROM attendance 
          WHERE register_no = '".$register_no."'";
$result = mysqli_query($connection, $query);
$overall_data = mysqli_fetch_assoc($result);

$total_sessions = $overall_data['overall_status'];
$total_attendance = $overall_data['overall_attend'];

if ($total_sessions > 0) {
    $attendance_percentage = (($total_sessions - $total_attendance) / $total_sessions) * 100;
    $attendance_percentage = number_format($attendance_percentage, 2);
} else {
    $attendance_percentage = 0;
}
$attendance = 'SELECT 
    c.course_id as cname, 
    c.name as name, 
    COUNT(s.session_id) as total, 
    SUM(CASE WHEN a.status = 1 THEN 0 ELSE
         (CASE WHEN a.status = -1 THEN 0 ELSE 1 END)
       END) as total_attend, 
    DATE_FORMAT(s.date_of_session,"%d-%m-%Y") as date_of_session  
FROM session s
JOIN mapping_teacher_course mtc ON s.new_id = mtc.new_id 
JOIN mapping_course_department_batch mcdb ON mtc.course_mapping_id = mcdb.course_mapping_id 
JOIN course c ON c.course_id = mcdb.course_id 
JOIN attendance a ON a.session_id = s.session_id 
JOIN student_information si ON si.register_no = a.register_no 
WHERE mcdb.batch_id = "'.$batch.'" 
  AND mtc.section_id = "'.$section.'"
  AND a.register_no = "'.$register_no.'"
  AND s.date_of_session BETWEEN s.date_of_session AND CURDATE()
  GROUP BY c.course_id
  ORDER BY s.date_of_session, s.period';

$result = mysqli_query($connection, $attendance);

$subjects = [];
while($row = mysqli_fetch_assoc($result)) {
    $subjects[] = $row['name'] ;
    $sattend[] = $row['total'] - $row['total_attend'];
    $missed[] = $row['total_attend'];
}

header('Content-Type: application/json');
echo json_encode([
    'total_attendance' => $total_attendance,
    'total_sessions' => $total_sessions,
    'attendance_percentage' => round($attendance_percentage),
    'labels' => $subjects,
    'attend' => $sattend,
    'missed' => $missed
]);

?>


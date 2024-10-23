<?php 
include 'master/config.php';
$user_id = $_SESSION['user_id'];
$no_of_subject = 'SELECT COUNT(DISTINCT course_mapping_id) as count FROM mapping_teacher_course WHERE user_id="'.$user_id.'"';
$queryEXE = mysqli_query($connection, $no_of_subject);
$row = mysqli_fetch_assoc($queryEXE);
$count = $row['count'];

$no_of_student = 'SELECT COUNT(DISTINCT si.register_no) AS total '.
'FROM mapping_teacher_course AS mtc '.
'JOIN mapping_course_department_batch AS mcdb '.
'ON mtc.course_mapping_id = mcdb.course_mapping_id '.
'JOIN student_information AS si '.
'ON si.mapping_id = mcdb.mapping_id AND si.batch_id = mcdb.batch_id AND si.section_id = mcdb.section_id '.
'WHERE user_id = "'.$user_id.'"';
$queryEXE = mysqli_query($connection,$no_of_student);
$row = mysqli_fetch_assoc($queryEXE);
$total = $row['total'];

$get_date = 'SELECT DATE_FORMAT(CURDATE(),"%d-%m-%Y") as date';
$queryEXE = mysqli_query($connection,$get_date);
$row = mysqli_fetch_assoc($queryEXE);
$date = $row['date'];

$get_subject_taught = 'SELECT c.name AS Course, d.name AS Department, b.batch_name AS Batch, s.section_name AS Section '.
'FROM mapping_teacher_course AS mtc '.
'JOIN mapping_course_department_batch AS mcdb ON mtc.course_mapping_id = mcdb.course_mapping_id '.
'JOIN course AS c ON c.course_id = mcdb.course_id '.
'JOIN batch AS b ON b.batch_id = mcdb.batch_id '.
'JOIN section AS s ON s.section_id = mcdb.section_id '.
'JOIN mapping_program_department AS mpd ON mpd.mapping_id = mcdb.mapping_id '.
'JOIN department AS d ON d.department_id = mpd.department_id '.
'WHERE mtc.user_id = "'.$user_id.'"';
$queryEXE = mysqli_query($connection, $get_subject_taught);

if ($queryEXE->num_rows > 0) {
    $subject_data = '';
    while ($row = mysqli_fetch_array($queryEXE)) {
        $subject_data .= '<tr>';
        $subject_data .= '<th scope="row">' . $row['Course'] . '</th>';
        $subject_data .= '<td>' . $row['Department'] . '</td>';
        $subject_data .= '<td>' . $row['Batch'] . '</td>';
        $subject_data .= '<td>' . $row['Section'] . '</td>';
        $subject_data .= '</tr>';
    }
} else {
    $subject_data = '<tr><td colspan="4">No data found</td></tr>';
}

$get_latest_leave = 'SELECT lr.start_date as `From` ,lr.end_date as `To`,atype.description as Type,lr.reason as Reason,lr.remark as Remark '.
'FROM `leave_record` as lr '.
'JOIN attendance_type as atype '.
'ON atype.type_id = lr.type_id '.
'WHERE reference_id = "'.$user_id.'" AND lr.status_id not in (7,8)';
$queryEXE = mysqli_query($connection, $get_latest_leave);

if (mysqli_num_rows($queryEXE) > 0) {
    $tleave_data = '';
    while ($row = mysqli_fetch_array($queryEXE)) {
        $tleave_data .= '<tr>';
        $tleave_data .= '<th scope="row">' . $row['From'] . '</th>';
        $tleave_data .= '<td>' . $row['To'] . '</td>';
        $tleave_data .= '<td>' . $row['Type'] . '</td>';
        $tleave_data .= '<td>' . $row['Reason'] . '</td>';
        $tleave_data .= '<td>' . $row['Remark'] . '</td>';
        $tleave_data .= '</tr>';
    }
} else {
    $tleave_data = '<tr><td colspan="5">No data found</td></tr>';
}

$get_student = 'SELECT si.register_no,si.name,d.name as department,b.batch_name as batch,s.section_name as section '.
'FROM mapping_teacher_course AS mtc '.
'JOIN mapping_course_department_batch AS mcdb ON mtc.course_mapping_id = mcdb.course_mapping_id '.
'JOIN batch AS b ON b.batch_id = mcdb.batch_id '.
'JOIN section as s ON s.section_id = mcdb.section_id '.
'JOIN mapping_program_department AS mpd ON mpd.mapping_id = mcdb.mapping_id '.
'JOIN department AS d ON d.department_id = mpd.department_id '.
'JOIN student_information AS si ON si.mapping_id = mcdb.mapping_id AND si.batch_id = mcdb.batch_id AND si.section_id = mcdb.section_id '.
'WHERE user_id = "'.$user_id.'"';
$queryEXE = mysqli_query($connection, $get_student);
$total_data = '';
if (mysqli_num_rows($queryEXE) > 0) {
    while ($row = mysqli_fetch_array($queryEXE)) {
        $total_data  .= '<tr>';
        $total_data  .= '<th scope="row">' . $row['register_no'] . '</th>';
        $total_data  .= '<td>' . $row['name'] . '</td>';
        $total_data  .= '<td>' . $row['department'] . '</td>';
        $total_data  .= '<td>' . $row['batch'] . '</td>';
        $total_data  .= '<td>' . $row['section'] . '</td>';
        $total_data  .= '</tr>';
    }
} 
?>
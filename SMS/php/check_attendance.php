<?php
include '../master/config.php';
session_start();
$user_id = $_SESSION['user_id'];
$period = $_POST['period'];
$check_query = 'SELECT COUNT(*) as count FROM session s join mapping_teacher_course mtc on mtc.new_id = s.new_id where mtc.user_id= ? AND date_of_session = CURDATE() AND period = ?';
    $stmt = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $period);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($row && $row['count'] > 0) {
	    $get_session_id = 'select session_id from session s join mapping_teacher_course mtc on mtc.new_id = s.new_id where mtc.user_id= "'.$user_id.'" and date_of_session = CURDATE() and period="'.$period.'"';
	    $queryEXE = mysqli_query($connection,$get_session_id);
	    $session_id = mysqli_fetch_array($queryEXE)[0];
	    $select_attendance = 'select a.register_no,si.name,t.description,a.remark from attendance a join student_information si on a.register_no=si.register_no join attendance_type t on t.value=a.status where session_id ="'.$session_id.'" and a.status_id!=4';
	    $queryEXE = mysqli_query($connection,$select_attendance);
	    $data = [];
	    while($row = mysqli_fetch_array($queryEXE)){
		    $data[] = $row;
	    }
	    echo json_encode(['status' => 'exists','data' => $data]);

    } else {
    echo json_encode(['status' => 'success']);
}

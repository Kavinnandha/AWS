<?php
include '../master/config.php';

if (isset($_POST['attendance_data'])) {
    session_start();

    $count_data = json_decode($_POST['attendance_count'], true);
    $new_id = $_POST['new_id'];
    $user_id = $_SESSION['user_id'];
    $topic = $_POST['topic'];
    $attendance_data = json_decode($_POST['attendance_data'], true);
    $present = $count_data['present'];
    $absent = $count_data['absent'];
    $OD = $count_data['OD'];
    $period = $_POST['period'];
    $year_id = $_POST['year']; 
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
	    $select_attendance = 'select a.register_no,si.name,t.description,a.remark from attendance a join student_information si on a.register_no=si.register_no join attendance_type t on t.value=a.status where session_id ="'.$session_id.'"';
	    $queryEXE = mysqli_query($connection,$select_attendance);
	    $data = [];
	    while($row = mysqli_fetch_array($queryEXE)){
		    $data[] = $row;
	    }
	    echo json_encode(['status' => 'exists','data' => $data]);

    } else {
       
        $add_session = 'INSERT INTO session(new_id, academic_year_id, date_of_session, period, topics_covered, no_of_present, no_of_absent, no_of_od) 
                        VALUES (?, ?, CURDATE(), ?, ?, ?, ?, ?)';
        $stmt = mysqli_prepare($connection, $add_session);
        mysqli_stmt_bind_param($stmt, 'iiisiii', $new_id, $year_id, $period, $topic, $present, $absent, $OD);
        $queryEXE = mysqli_stmt_execute($stmt);
        
        if ($queryEXE) {
            
            $get_session_id = 'SELECT session_id FROM session WHERE new_id = ? AND date_of_session = CURDATE() AND period = ? AND no_of_present = ?';
            $stmt = mysqli_prepare($connection, $get_session_id);
            mysqli_stmt_bind_param($stmt, 'ssi', $new_id, $period, $present);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $session_id = mysqli_fetch_assoc($result)['session_id'];
        
            foreach ($attendance_data as $record) {
                $reg_no = $record['register_no'];
                $status = $record['status'];
                $remark = $record['remarks'];
                
                $insert = 'INSERT INTO attendance(session_id, register_no, status, remark) VALUES(?, ?, ?, ?)';
                $stmt = mysqli_prepare($connection, $insert);
                mysqli_stmt_bind_param($stmt, 'iiis', $session_id, $reg_no, $status, $remark);
                mysqli_stmt_execute($stmt);
            }
         
            echo json_encode(['status' => 'success']);
        } else {
          
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert session data.']);
        }
    }
}
?>

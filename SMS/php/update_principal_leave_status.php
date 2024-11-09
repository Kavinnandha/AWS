<?php
include '../master/config.php';
if (isset($_POST['reference_id'])) {
    $action = $_POST['action'];
    $register_no = $_POST['reference_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $remark = $_POST['remark'];
    $remark_insert = 'update leave_record set remark= "' . $remark . '" where reference_id="' . $register_no . '" and start_date="' . $start_date . '" and end_date="' . $end_date . '"';
    $queryEXE = mysqli_query($connection, $remark_insert);
    $select_leave_id = 'select leave_id from leave_record where reference_id="' . $register_no . '" and start_date="' . $start_date . '" and end_date="' . $end_date . '"';
    $queryEXE = mysqli_query($connection, $select_leave_id);
    $leave_id = mysqli_fetch_row($queryEXE)[0];

    if ($action == "Accepted") {
        $update_query = 'update leave_record set status_id=7 where leave_id="' . $leave_id . '"';
    } else {
        $update_query = 'update leave_record set status_id=8 where leave_id="' . $leave_id . '"';
    }
    $queryEXE = mysqli_query($connection, $update_query);
    Header('Location: /SMS/leave_approvals.php');
}

<?php
include '../master/config.php';
$reference_id = $_SESSION['register_no'];; 
$total_leave_query = "SELECT COUNT(leave_id) AS total FROM leave_record WHERE reference_id = $reference_id";
$leave_approved_query = "SELECT COUNT(leave_id) AS approved FROM leave_record WHERE reference_id = $reference_id AND status_id = 7";
$leave_not_approved_query = "SELECT COUNT(leave_id) AS not_approved FROM leave_record WHERE reference_id = $reference_id AND status_id = 8";
$leave_wait_query = "SELECT COUNT(leave_id) AS waiting FROM leave_record WHERE reference_id = $reference_id AND status_id < 7";
$total_leave_data_query = "SELECT reason FROM leave_record WHERE reference_id = $reference_id";
$total_approve_data_query = "SELECT reason FROM leave_record WHERE reference_id = $reference_id AND status_id = 7";
$total_reject_data_query = "SELECT reason FROM leave_record WHERE reference_id = $reference_id AND status_id = 8";
$total_wait_data_query = "SELECT reason FROM leave_record WHERE reference_id = $reference_id AND status_id < 7";
$total_leave_data_result = mysqli_query($connection,$total_leave_data_query);
$total_approve_data_result = mysqli_query($connection,$total_approve_data_query);
$total_reject_data_result = mysqli_query($connection,$total_reject_data_query);
$total_wait_data_result = mysqli_query($connection,$total_wait_data_query);
$total_leave_result = mysqli_query($connection, $total_leave_query);
$leave_approved_result = mysqli_query($connection, $leave_approved_query);
$leave_not_approved_result = mysqli_query($connection, $leave_not_approved_query);
$leave_wait_result = mysqli_query($connection, $leave_wait_query);
$tot_leave = mysqli_fetch_array($total_leave_result);
$leave_approved = mysqli_fetch_array($leave_approved_result);
$leave_not_approved = mysqli_fetch_array($leave_not_approved_result);
$leave_wait = mysqli_fetch_array($leave_wait_result);

?>

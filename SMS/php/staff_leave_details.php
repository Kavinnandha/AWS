<?php 
include 'master/config.php';
$register_no = $_SESSION['user_id'];
$leave_info = "SELECT DATE_FORMAT(r.start_date,'%d-%m-%Y') as start,DATE_FORMAT(r.end_date,'%d-%m-%Y') as end,r.no_of_days as ndays,r.in_time as intime,r.out_time as outtime,a.description as des,s.name as stat,r.reason as reason,r.remark as remark,r.status_id as statid from leave_record r JOIN
leave_status s on s.status_id = r.status_id JOIN attendance_type a on a.type_id = r.type_id WHERE reference_id = '".$user_id."'";
$query = mysqli_query($connection, $leave_info);
if($query->num_rows>0){
    $leave_data = '';
    while($row = mysqli_fetch_array($query)){
        if($row['statid']>6){
        if($row['statid']==7){
            $leave_data.='<tr class="table-success">';
        }else{
            $leave_data.='<tr class="table-danger">';
        }
        $leave_data.= '<td>'.$row['start'].'</td>';
        $leave_data.= '<td>'.$row['end'].'</td>';
        $leave_data.= '<td>'.$row['ndays'].'</td>';
        $leave_data.= '<td>'.$row['des'].'</td>';
        $leave_data.= '<td>'.$row['reason'].'</td>';
        $leave_data.= '<td>'.$row['remark'].'</td>';
        $leave_data.= '<td>'.$row['outtime'].'</td>';
        $leave_data.= '<td>'.$row['intime'].'</td>';
        $leave_data.= '<td>'.$row['stat'].'</td>';
        $leave_data.='</tr>';
        }
    }
}else{
    $leave_data = "no records found";
}

$current_leave_info = "select DATE_FORMAT(lr.start_date,'%d-%m-%Y') as start_date,lr.remark,DATE_FORMAT(lr.end_date,'%d-%m-%Y') as end_date,lr.no_of_days,at_type.description as request_for,lr.reason,lr.out_time,lr.in_time,ls.name from leave_record lr join login l on l.user_id=lr.reference_id join attendance_type at_type on at_type.type_id=lr.type_id join leave_status ls on ls.status_id=lr.status_id where reference_id = '".$user_id."' and lr.status_id not in (7,8)";
$queryEXE = mysqli_query($connection,$current_leave_info);
$current_leave_data = '';
if($queryEXE->num_rows>0){
	while($row = mysqli_fetch_array($queryEXE)){
		$current_leave_data.= '<tr class="table-info">';
		$current_leave_data.= '<td>'.$row['start_date'].'</td>';
		$current_leave_data.= '<td>'.$row['end_date'].'</td>';
		$current_leave_data.= '<td>'.$row['no_of_days'].'</td>';
		$current_leave_data.= '<td>'.$row['request_for'].'</td>';
		$current_leave_data.= '<td>'.$row['reason'].'</td>';
        $current_leave_data.= '<td>'.$row['remark'].'</td>';
		$current_leave_data.= '<td>'.$row['out_time'].'</td>';
		$current_leave_data.= '<td>'.$row['in_time'].'</td>';
		$current_leave_data.= '<td>'.$row['name'].'</td>';
		$current_leave_data.='</tr>';
	}
}else{
	$currrent_leave_data = 'no current leaves applied';
}

?>

<?php include 'master/config.php';
include 'master/session.php';
$user_id = $_SESSION['user_id'];
$get_time_table = 'select DISTINCT l.name,c.course_id,s.period from session s join mapping_teacher_course mtc on mtc.new_id=s.new_id join mapping_course_department_batch mcdb on mcdb.course_mapping_id=mtc.course_mapping_id join course c on c.course_id=mcdb.course_id join login l on l.user_id=mtc.user_id join mapping_program_department mpd on mpd.mapping_id=mcdb.mapping_id join advisor_mapping am on am.batch_id=mcdb.batch_id where s.date_of_session=CURDATE() and mcdb.batch_id=am.batch_id and am.user_id="'.$user_id.'" order by s.period';
$get_current_date = 'select CURDATE()';
$queryEXE = mysqli_query($connection,$get_current_date);
$time_table_result = mysqli_query($connection,$get_time_table);
$current_date = mysqli_fetch_row($queryEXE)[0];
$time_table = '<td>'.$current_date.'</td>';
$periods = [];
while ($row = mysqli_fetch_assoc($time_table_result)) {
    $periods[$row['period']] = $row;
}
for($x = 1;$x <= 9; $x++){
    if(isset($periods[$x])){
        $time_table.='<td class="table-success">'.$periods[$x]['course_id'].'-'.$periods[$x]['name'].'</td>';
    }else{
        $time_table.='<td class="table-danger">'.$x.'</td>';
    }
}
    

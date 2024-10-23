<?php
include '../master/config.php';
$register_no = $_SESSION['register_no'];
$extra_curricular_query = 'SELECT * from approved_certificates where register_no = "'.$register_no.'"';
$result = mysqli_query($connection,$extra_curricular_query);
if($result->num_rows>0){
    $data = '';
    while($row = mysqli_fetch_array($result)){
        $data.= '<tr>';
          $data.='<th scope = "row">'.$row['event_name'].'</td>';
          $data.= '<th>'.$row['type'].'</td>';
          $data.= '<td>'.$row['points_awarded'].'</td>';
          $data.= '</tr>';
    }
}
else{
    $data ='<td colspan="3">No Data Found</td>';
}
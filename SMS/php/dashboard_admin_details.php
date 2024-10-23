<?php 

include 'master/config.php';

$get_requests = 'select request_id,request,reference_id from requests where status=0 and reference_id < 714000000000';
$queryEXE = mysqli_query($connection,$get_requests);
if($queryEXE->num_rows > 0){
    $requst_data = '<table class="table table-borderless">';
    while($row = mysqli_fetch_array($queryEXE)){
            $request_data.= '<tr><form method="post" action="php/submit_request.php">';
            $request_data.='<input type="hidden" name="request_id" value="'.$row['request_id'].'">';
            $request_data.='<td>'.$row['request'].'</td>';
            $request_data.='<td><button type="submit" value="submit" class="btn btn-success">Fixed</button>';
            $request_data.='</form></tr>';
        }
}else{
    $request_data = 'No Edit Requests Available';
}
?>

<?php
$select_batch_data = 'select batch_id,batch_name,current_semester from batch';
$queryEXE = mysqli_query($connection,$select_batch_data);
if($queryEXE->num_rows > 0){
	$batch_data = '';
	while($row = mysqli_fetch_array($queryEXE)){
        $batch_data.='<tr>';
        $batch_data.='<input type="hidden" class="batch_id" value="'.$row['batch_id'].'">';
		$batch_data.='<th scope="row">'.$row['batch_name'].'</th>';
        $batch_data.='<td>'.$row['current_semester'].'</td>';
        $batch_data.= '<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateBatchModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-batch-button"><i class="fi fi-rr-trash"></i></button></td>';
		$batch_data.='</tr>';
	}
}
?>

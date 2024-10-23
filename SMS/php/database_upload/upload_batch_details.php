<?php
include '../../master/config.php';

if(isset($_POST['update'])){
    $update_query = 'update batch set current_semester = current_semester+1';
    $queryEXE = mysqli_query($connection,$update_query);
echo "<script>alert('Semesters have been updated.');window.location.href='../../master/database_upload/create_batch.php'</script>";

}
else{
$batches= $_POST['batch'];
foreach($batches as $batch){
	$batch_name = $batch['batch_name'];
	$current_semester = $batch['current_semester'];
	$insert_batch = 'insert into batch(batch_name,current_semester) values("'.$batch_name.'","'.$current_semester.'")';
	$queryEXE = mysqli_query($connection,$insert_batch);
}
echo "<script>alert('Batch details have been successfully inserted.');window.location.href='../../master/database_upload/create_batch.php'</script>";
}
?>


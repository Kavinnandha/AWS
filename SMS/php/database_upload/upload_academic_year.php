<?php
include '../../master/config.php';
$years = $_POST['years'];
foreach($years as $year){
        $name = $year['academic_year'];
        $type = $year['type'];
        $status = $year['status'];
        $insert_academic_year = 'insert into academic_year(name,type,status) values("'.$name.'","'.$type.'","'.$status.'")';
        $queryEXE = mysqli_query($connection,$insert_academic_year);
}
        echo '<script>alert("Details uploaded sucessfully");</script>';
        echo '<script>window.location.href = "../../master/database_upload/create_academic_year.php"</script>';
?>


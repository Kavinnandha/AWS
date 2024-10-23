<?php
include '../../master/config.php';  
$degrees = $_POST['degree'];  
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

foreach ($degrees as $degree) {
    $programme_name = $degree['programme_name'];
    $duration = $degree['duration'];
    $no_of_semesters = $degree['no_of_semester'];
    $insert_programme = 'INSERT INTO programme (programme_name, duration, no_of_semesters) 
                         VALUES ("'.$programme_name.'", "'.$duration.'", "'.$no_of_semesters.'")';
    $queryEXE = mysqli_query($connection, $insert_programme);
    if (!$queryEXE) {
        die("Database query failed: " . mysqli_error($connection));
    }
}
echo "<script>alert('Degree details have been successfully inserted.');window.location.href='../../master/database_upload/create_degree.php'</script>";
?>


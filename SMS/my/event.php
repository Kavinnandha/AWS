<?php
include '../master/config.php';

if (isset($_POST['type'])) {
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    
    $get_event_name = 'SELECT DISTINCT event_name FROM approved_certificates WHERE type = "' . $type . '"';
    $queryEXE = mysqli_query($connection, $get_event_name);

    $event_data = '';

    if (mysqli_num_rows($queryEXE) > 0) {
        $event_data .= '<option value="" selected disabled>Select '.$type.'</option>';
        while ($row = mysqli_fetch_array($queryEXE)) {
            $event_data .= '<option value="' . $row['event_name'] . '">' . $row['event_name'] . '</option>';
        }
    } else {
        $event_data .= '<option value="" selected disabled>No Competitions Available</option>';
    }
    $event_data .= '<option value="Others">Others</option>'; 

    echo $event_data;  
}
?>


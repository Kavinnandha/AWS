<?php
include '../config.php';
$select_programme_information = '
    SELECT programme_id,programme_name, CAST(duration AS UNSIGNED) AS duration, CAST(no_of_semesters AS UNSIGNED) AS no_of_semesters
    FROM programme';

$queryEXE = mysqli_query($connection, $select_programme_information);


if (mysqli_num_rows($queryEXE) > 0) {
    
    while ($row = mysqli_fetch_array($queryEXE)) {
        echo '<tr>';
        echo '<input value="'.$row['programme_id'].'" type="hidden">';
        echo '<th scope="row">' . $row['programme_name'] . '</th>';
        echo '<td>' . $row['duration'] . '</td>';
	echo '<td>' . $row['no_of_semesters'] . '</td>';
	echo '<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateDegreeModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-degree-button"><i class="fi fi-rr-trash"></i></button></td>';
        echo '</tr>';
    }
} else {
    echo 'No programme information found';
}
$connection->close();
?>

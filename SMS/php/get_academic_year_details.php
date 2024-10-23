<?php

$select_academic_year = 'select * from academic_year';
$queryEXE = mysqli_query($connection,$select_academic_year);
$academic_year_data = '';
while($row = mysqli_fetch_array($queryEXE)){
        $academic_year_data.='<tr>';
        $academic_year_data.='<input type="hidden" class="academic_year_id" value="'.$row['academic_year_id'].'">';
        $academic_year_data.='<th scope="row">'.$row['name'].'</th>';
        $academic_year_data.='<td>'.$row['type'].'</td>';
        $academic_year_data.='<td>'.$row['status'].'</td>';
        $academic_year_data.='<td><div class="btn-group" role="group"><button class="btn" data-bs-toggle="modal" data-bs-target="#updateYearModal"><i class="fi fi-rr-edit"></i></button><button class="btn delete-year-button"><i class="fi fi-rr-trash"></i></button></td>';

}

?>

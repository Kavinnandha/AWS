<?php 
include 'master/config.php';
$result = 'SELECT * FROM certificates ORDER BY id';
$query=mysqli_query($connection,$result);
$compare = 'SELECT event_name FROM approved_certificates';
$compare_query = mysqli_query($connection, $compare);
$approved_names = [];
while ($compare_row = mysqli_fetch_array($compare_query)) {
    $approved_names[] = $compare_row['event_name']; 
}

if($query->num_rows>0){
    $data = '';
    $data2 = '';
    $data3 = '';
    $data4 = '';
    while($row = mysqli_fetch_array($query)){
        if($row['type']=="competition" and $row['status']==0){
        $data.= '<tr>';
        $data.='<td scope = "row" id="register_' . $row['id'] . '">'.$row['register_no'].'</td>';
        $data .= '<input type="hidden" id="type_' . $row['id'] . '" value="' . $row['type'] . '">';
        if (in_array($row['name'], $approved_names)) {
            $data .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
            $points = 'SELECT points_awarded FROM approved_certificates WHERE event_name = "' . $row['name'] . '"';
            $points_query = mysqli_query($connection, $points);
            $points_awarded = mysqli_fetch_assoc($points_query);
            $data .= '<input type="hidden" id="points_' . $row['id'] . '" value="' . $points_awarded['points_awarded'] . '">';
        } else {
            $data .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
            $data .= '<input type="hidden" id="points_' . $row['id'] . '" value="0">';
        }
        $data.='<td>'.$row['position_secured'].'</td>';
        $data.='<td>'.$row['held_date'].'</td>';
        $data .= '<td>'.
            '<p class="d-inline-flex gap-1">'.
                '<button class="btn btn-primary form-control" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$row['id'].'"  aria-controls="collapseExample'.$row['id'].'">'.
                    "More".
                '</button>'.
            '</p>'.'</td>';
        $data.='<td>'.'<a class="btn btn-info form-control" href="php/view_certificate.php?id='.$row['id'].'" target="_blank">'."view".'</a>';
        $data.='<td><div class="d-grid gap-2 mx-auto">'.'<button class="btn btn-success" type="button" onclick="acceptButtonClicked('.$row['id'].')">Accept</button>'." ".'<button class="btn btn-warning" onclick="acceptRestrictionButtonClicked('.$row['id'].')">Accept with restriction</button>'.'</div><td>';
        
        $data.='</tr>';
        $data.= '<td colspan="7">'.'<div class="collapse" id="collapseExample'.$row['id'].'">'.
                '<div class="card card-body">'.
                    $row['description'].
                '</div>'.
            '</div>'.
        '</td>';
            
    }else if($row['type']=="internship" and $row['status']==0){
            $data3.= '<tr>';
            $data3.='<td scope = "row" id="register_' . $row['id'] . '">'.$row['register_no'].'</td>';
            $data3 .= '<input type="hidden" id="type_' . $row['id'] . '" value="' . $row['type'] . '">';
            if (in_array($row['name'], $approved_names)) {
                $data3 .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
                $points = 'SELECT points_awarded FROM approved_certificates WHERE event_name = "' . $row['name'] . '"';
                $points_query = mysqli_query($connection, $points);
                $points_awarded = mysqli_fetch_assoc($points_query);
                $data3 .= '<input type="hidden" id="points_' . $row['id'] . '" value="' . $points_awarded['points_awarded'] . '">';
            } else {
                $data3 .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
                $data3 .= '<input type="hidden" id="points_' . $row['id'] . '" value="0">';
            }
            $data3.='<td>'.$row['role'].'</td>';
            $data3.= '<td>'.
                '<p class="d-inline-flex gap-1">'.
                    '<button class="btn btn-primary form-control" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$row['id'].'"  aria-controls="collapseExample'.$row['id'].'">'.
                        "More".
                    '</button>'.
                '</p>'.'</td>';
            $data3.='<td>'.'<a class="btn btn-info form-control" href="php/view_certificate.php?id='.$row['id'].'" target="_blank">'."view".'</a>';
            $data3.='<td><div class="d-grid gap-2 mx-auto">'.'<button class="btn btn-success" onclick="acceptButtonClicked('.$row['id'].')">Accept</button>'." ".'<button class="btn btn-warning" onclick="acceptRestrictionButtonClicked('.$row['id'].')">Accept with restriction</button>'.'</div><td>';
            $data3.='</tr>';
            $data3.= '<td colspan="7">'.'<div class="collapse" id="collapseExample'.$row['id'].'">'.
                    '<div class="card card-body">'.
                        $row['description'].
                    '</div>'.
                '</div>'.
            '</td>';
    
            }else if($row['type']=="research" and $row['status']==0){
                if($row['status']==0)
                $data2.= '<tr>';
                $data2.='<td scope = "row" id="register_' . $row['id'] . '">'.$row['register_no'].'</td>';
                $data2 .= '<input type="hidden" id="type_' . $row['id'] . '" value="' . $row['type'] . '">';
                if (in_array($row['name'], $approved_names)) {
                    $data2 .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
                    $points = 'SELECT points_awarded FROM approved_certificates WHERE event_name = "' . $row['name'] . '"';
                    $points_query = mysqli_query($connection, $points);
                    $points_awarded = mysqli_fetch_assoc($points_query);
                    $data2 .= '<input type="hidden" id="points_' . $row['id'] . '" value="' . $points_awarded['points_awarded'] . '">';
                } else {
                    $data2 .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
                    $data2 .= '<input type="hidden" id="points_' . $row['id'] . '" value="0">';
                }
                $data2.='<td>'.$row['publication_name'].'</td>';
                $data2.= '<td>'.
                    '<p class="d-inline-flex gap-1">'.
                        '<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$row['id'].'"  aria-controls="collapseExample'.$row['id'].'">'.
                            "More".
                        '</button>'.
                    '</p>'.'</td>';
                $data2.='<td>'.'<a class="btn btn-info form-control" href="php/view_certificate.php?id='.$row['id'].'" target="_blank">'."view".'</a>';
                $data2.='<td><div class="d-grid gap-2 mx-auto">'.'<button class="btn btn-success" onclick="acceptButtonClicked('.$row['id'].')">Accept</button>'." ".'<button class="btn btn-warning" onclick="acceptRestrictionButtonClicked('.$row['id'].')">Accept with restriction</button>'.'</div><td>';
                $data2.='</tr>';
                $data2.= '<td colspan="7">'.'<div class="collapse" id="collapseExample'.$row['id'].'">'.
                        '<div class="card card-body">'.
                            $row['description'].
                        '</div>'.
                    '</div>'.
                '</td>';
        
                }else if($row['type']=="extra_courses_done" and $row['status']==0){
                    $data4.= '<tr>';
                    $data4.='<td scope = "row" id="register_' . $row['id'] . '">'.$row['register_no'].'</td>';
                    $data4 .= '<input type="hidden" id="type_' . $row['id'] . '" value="' . $row['type'] . '">';
                    if (in_array($row['name'], $approved_names)) {
                        $data4 .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
                        $points = 'SELECT points_awarded FROM approved_certificates WHERE event_name = "' . $row['name'] . '"';
                        $points_query = mysqli_query($connection, $points);
                        $points_awarded = mysqli_fetch_assoc($points_query);
                        $data4 .= '<input type="hidden" id="points_' . $row['id'] . '" value="' . $points_awarded['points_awarded'] . '">';
                    } else {
                        $data4 .= '<td id="name_' . $row['id'] . '">' . $row['name'] . '</td>';
                        $data4 .= '<input type="hidden" id="points_' . $row['id'] . '" value="0">';
                    }
                    $data4.='<td>'.$row['issued_by'].'</td>';
                    $data4.= '<td>'.
                        '<p class="d-inline-flex gap-1">'.
                            '<button class="btn btn-primary form-control" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample'.$row['id'].'"  aria-controls="collapseExample'.$row['id'].'">'.
                                "More".
                            '</button>'.
                        '</p>'.'</td>';
                    $data4.='<td>'.'<a class="btn btn-info form-control" href="php/view_certificate.php?id='.$row['id'].'" target="_blank">'."view".'</a>';
                    $data4.='<td><div class="d-grid gap-2 mx-auto">'.'<button class="btn btn-success" onclick="acceptButtonClicked('.$row['id'].')">Accept</button>'." ".'<button class="btn btn-warning" onclick="acceptRestrictionButtonClicked('.$row['id'].')">Accept with restriction</button>'.'</div><td>';
                    $data4.='</tr>';
                    $data4.= '<td colspan="7">'.'<div class="collapse" id="collapseExample'.$row['id'].'">'.
                            '<div class="card card-body">'.
                                $row['description'].
                            '</div>'.
                        '</div>'.
                    '</td>';
            
                    }
        
    }
    echo '<script>
        function acceptButtonClicked(row_id) {
        var nameElement = document.getElementById("name_" + row_id);
        var name = nameElement.innerText;
        var registerElement = document.getElementById("register_" + row_id);
        var register = registerElement.innerText;
        var pointElement = document.getElementById("points_" + row_id);
        var point = pointElement.value;
        var typeElement = document.getElementById("type_" + row_id);
        var type = typeElement.value;
            if (point == 0) {
                var points = prompt("Enter points to be awarded");        
        
            if (points === null || points.trim() === "") {
                return;
            }
    } else {
        var points = point;
    }

    
    $.ajax({
        type: "POST",
        url: "php/update_achievements.php",
        data: { id: row_id, status: 1, awarded_points: points, name: name,register_no: register,type:type },
        success: function() {
            alert(points + " Points Have Been Points Awarded Successfully");
            window.location.href = "achievements.php";
        }
    });
}

function acceptRestrictionButtonClicked(row_id) {
    $.ajax({
        type: "POST",
        url: "php/update_achievements.php",
        data: { id: row_id, status: 2 },
        success: function() {
            alert("Accepted successfully with restriction");
            window.location.href = "achievements.php";
        }
    });
}

    </script>';
}
?>

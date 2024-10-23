<?php
    include '../../master/config.php';
    $user_id = $_POST['user_id'];
    $department_id = $_POST['department_id'];
$check_query = "SELECT * FROM hod_mapping WHERE department_id = '$department_id'";
$result = mysqli_query($connection, $check_query);

if (mysqli_num_rows($result) > 0) {
     echo "<script>alert('A HOD for that department already exists!');window.location.href='../../master/database_upload/create_hod_mapping.php';</script>";
} else{
    $insert_hod_mapping = 'insert into hod_mapping(user_id,department_id) values("'.$user_id.'","'.$department_id.'")';
    if(mysqli_query($connection,$insert_hod_mapping)){
        echo "<script>alert('Details have been successfully inserted.');window.location.href='../../master/database_upload/create_hod_mapping.php'</script>";
    }
}
?>


<?php 
include '../master/config.php';
session_start();

if(isset($_POST['request_id'])){
    $request_id = $_POST['request_id'];
    $update_query = 'update requests set status=1 where request_id="'.$request_id.'"';
    mysqli_query($connection,$update_query);
    if ($_SESSION['user_id'] == 5){
        header("Location: ../dashboard_admin.php");
    }
    else if ($_SESSION['user_id'] == 1) {
        header("Location: ../dashboard_hod.php");
    }
}else{

    if(isset($_SESSION['register_no'])){
        $reference_id = $_SESSION['register_no'];
    }else{
        $reference_id = $_SESSION['user_id'];
    }
    $origin_url = $_POST['origin'];
    $request = $_POST['request'];
    $upload_request = 'insert into requests(reference_id,request) values("'.$reference_id.'","'.$request.'")';
    if(mysqli_query($connection,$upload_request)){
        echo '<script>alert("Your request/Feedback has been submitted successfully!");window.location.href="'.$origin_url.'";</script>';
    }
}
?>

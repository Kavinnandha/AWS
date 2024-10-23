<?php
include '../master/config.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "SELECT file_name, file_data FROM certificates WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $file_name = $row['file_name'];
        $file_data = base64_decode($row['file_data']); 

        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        switch($file_extension){
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                header('Content-Type: image/'.$file_extension);
                break;
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            default:
                echo "Unsupported file type.";
                exit();
        }

    
        echo $file_data;
        exit();
    } else {
        echo "File not found.";
    }
} else {
    echo "No file selected.";
}
?>

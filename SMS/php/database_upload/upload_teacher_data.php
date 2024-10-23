<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../master/config.php';

// Function to safely redirect
function safeRedirect($url) {
    echo "<script>window.location.href = '" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "';</script>";
    exit;
}

// Function to show alert and redirect
function alertAndRedirect($message, $url) {
    echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "');</script>";
    safeRedirect($url);
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Upload') {
    $role_id = $_POST['role'];
    $department_id = $_POST['department'];
    
    try {
        $file = $_FILES["file"]["tmp_name"];
        if (($handle = fopen($file, "r")) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            $headers[] = "role_id";
            $headers[] = "department_id";
            $columns = '`' . implode("`, `", $headers) . '`, `password`';
            $placeholders = implode(", ", array_fill(0, count($headers),"?")).",PASSWORD(?)";
            $sql = "INSERT INTO login ($columns) VALUES ($placeholders)";
            
            $stmt = $connection->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $connection->error);
            }

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $data[] = $role_id;
                $data[] = $department_id;
                $data[] = "siet@2024"; 
                
                $types = str_repeat("s", count($data));
                $stmt->bind_param($types, ...$data);
                
                if (!$stmt->execute()) {
                    throw new Exception('Failed to upload teacher data: ' . $stmt->error);
                }
            }
            fclose($handle);
            alertAndRedirect("File Uploaded Successfully", "../../master/database_upload/create_teacher.php");
        } else {
            throw new Exception("Error in opening the file.");
        }
    } catch (Exception $e) {
        error_log("Bulk upload error: " . $e->getMessage());
        alertAndRedirect("Error: " . $e->getMessage(), "../../master/database_upload/create_teacher.php");
    }
} elseif (isset($_POST['teachers'])) {
    $teacher_data = $_POST['teachers'];
        foreach ($teacher_data as $teacher) {
            $email = $teacher['email_id'];
            $name = $teacher['name'];
            $department_id = $teacher['department'];
            $gender = $teacher['gender'];
            $designation = $teacher['designation'];
            $role = $teacher['role'];
            $password = 'siet@2024';
            $sql = 'INSERT INTO login (email_id, name, department_id, gender, designation, password, role_id) 
                    VALUES ("'.$email.'","'.$name.'","'.$department_id.'","'.$gender.'","'.$designation.'", PASSWORD("siet@2024"),"'.$role.'")';
            mysqli_query($connection,$sql);
            }
alertAndRedirect("Teacher details have been successfully inserted.", "../../master/database_upload/create_teacher.php");

}else {
    alertAndRedirect("No data submitted!", "../../master/database_upload/create_teacher.php");
}
?>

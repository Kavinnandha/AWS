<?php
include '../../master/config.php';

if (isset($_POST['students'])) {
    $students = $_POST['students'];
        $department = $students[0]['department'];
        $batch_id = $students[0]['batch'];
        $section_id = $students[0]['section_id'];

    foreach ($students as $student) {
        try {
        $register_no = $student['register_no'];
        $name = $student['name'];
        $dob = $student['DOB'];
        $gender = $student['gender'];
        $boarding_status = $student['boarding_status'];
               $email = $student['email'];
            $get_mapping_id = 'SELECT mapping_id FROM mapping_program_department WHERE department_id = "'.$department.'"';
            $queryEXE = mysqli_query($connection,$get_mapping_id);
            $mapping_id = mysqli_fetch_row($queryEXE)[0];

            $insert_details = 'INSERT INTO student_information (register_no, name, dob, gender, boarding_status, mapping_id, batch_id, section_id,email,password) VALUES (?, ?, ?,?, ?, ?, ?, ?, ?,PASSWORD("siet@2024"))';
            $stmt = $connection->prepare($insert_details);
            $stmt->bind_param("sssssssss", $register_no, $name, $dob, $gender, $boarding_status, $mapping_id, $batch_id, $section_id, $email);
            $stmt->execute();
        }catch(mysqli_sql_exception){
                echo '<script>alert("Duplicate Entry for Register no!");</script>';
                echo '<script>window.location.href = "../../master/database_upload/create_student.php";</script>';
        }
echo '<script>alert("Details uploaded successfully");</script>';
echo '<script>window.location.href = "../../master/database_upload/create_student.php";</script>';

}
}
?>

<?php
include '../../master/config.php';

if (isset($_FILES["file"])) {
    try {
        $batch_id = $_POST['batch_id'];
        $section_id = $_POST['section_id'];
        $department_id = $_POST['department_id'];

        // Get mapping_id first
        $get_mapping_id = 'SELECT mapping_id FROM mapping_program_department WHERE department_id = ?';
        $stmt = $connection->prepare($get_mapping_id);
        $stmt->bind_param("s", $department_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $mapping_id = $result->fetch_array()[0];

        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            $success = 0;
            $failure = 0;
            
            // Get headers from first row
            $headers = fgetcsv($handle, 1000, ",");
            $headers[] = "batch_id";
            $headers[] = "section_id";
            $headers[] = "mapping_id";
            
            // Create base INSERT query
            $table = "INSERT INTO student_information (" . implode(", ", $headers) . ",password) VALUES(";
            
            while (($data = fgetcsv($handle, 1000, ","))) {
                $values = '';
                
                // Format date for the DOB field (assuming it's the 3rd column)
                $data[2] = date('Y-m-d', strtotime($data[2]));
                
                // Add the additional fields
                $data[] = $batch_id;
                $data[] = $section_id;
                $data[] = $mapping_id;
                
                // Build values string
                for($i = 0; $i < count($data); $i++) {
                    if(mysqli_real_escape_string($connection, $data[$i]) != '') {
                        $values .= "'" . mysqli_real_escape_string($connection, $data[$i]) . "'";
                        if($i != count($data) - 1) {
                            $values .= ',';
                        }
                    }
                }
                

                $values .= ",PASSWORD('siet@2024')";
                $values .= ');';
                
                $query = $table . $values;
                echo $query;
                if (mysqli_query($connection, $query)) {
                    $success++;
                } else {
                    $failure++;
                    error_log("Query failed: " . mysqli_error($connection));
                }
            }
            
            fclose($handle);
            
            $message = "Upload completed. Successful entries: $success, Failed entries: $failure";
            echo "<script>alert('$message');</script>";
            echo '<script>window.location.href = "../../master/database_upload/create_student.php";</script>';
        } else {
            throw new Exception("Please upload a CSV file");
        }
    } catch (Exception $e) {
        error_log("Upload Error: " . $e->getMessage());
        echo '<script>alert("Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '");</script>';
        echo '<script>window.location.href = "../../master/database_upload/create_student.php";</script>';
    }
} else {
    echo "file not sent";
}

?>

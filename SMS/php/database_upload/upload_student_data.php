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

    if (isset($_POST["file"])) {
        $batch_id = $_POST['batch_id'];
        $section_id = $_POST['section_id'];
        $department_id = $_POST['department_id'];

        try {
            $get_mapping_id = 'SELECT mapping_id FROM mapping_program_department WHERE department_id = ?';
            $stmt = $connection->prepare($get_mapping_id);
            $stmt->bind_param("s", $department_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $mapping_id = $result->fetch_array()[0];

            $file = $_FILES["file"]["tmp_name"];
            if (($handle = fopen($file, "r")) !== FALSE) {
                $headers = fgetcsv($handle, 1000, ",");
                $headers[] = "batch_id";
                $headers[] = "section_id";
                $headers[] = "mapping_id";

                $sql = "INSERT INTO student_information (" . implode(", ", $headers) . ") 
                        VALUES (" . implode(", ", array_fill(0, count($headers), "?")) . ")";
                $stmt = $connection->prepare($sql);

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $dob = date('Y-m-d', strtotime($data[2]));
                    $data[2] = $dob;
                    $data[] = $batch_id;
                    $data[] = $section_id;
                    $data[] = $mapping_id;

                    $stmt->bind_param(str_repeat("s", count($data)), ...$data);
                    if (!$stmt->execute()) {
                        throw new Exception('Failed to upload student data from file: ' . $stmt->error);
                    }
                }
                fclose($handle);
                echo '<script>alert("File Uploaded Successfully");</script>';
                echo '<script>window.location.href = "../../master/database_upload/create_student.php";</script>';
            } else {
                throw new Exception("Error in opening the file.");
            }
        } catch (Exception $e) {
            echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
            echo '<script>window.location.href = "../../master/database_upload/create_student.php";</script>';
        }
    } 
?>

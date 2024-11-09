<?php
include '../../master/config.php';

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'fetch':
        $query = "SELECT lms_course_id, lms_course_name FROM lms_courses";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            echo json_encode(["success" => false, "error" => mysqli_error($connection)]);
            exit;
        }

        $courses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }

        echo json_encode($courses);
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $courseId = intval($_GET['id']);
            $sql = "DELETE FROM lms_courses WHERE lms_course_id = $courseId";

            if ($connection->query($sql) === TRUE) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $connection->error]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "No course ID specified."]);
        }
        break;

    case 'update':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id']) && isset($data['name'])) {
            $courseId = intval($data['id']);
            $courseName = $connection->real_escape_string($data['name']);

            $sql = "UPDATE lms_courses SET lms_course_name = '$courseName' WHERE lms_course_id = $courseId";

            if ($connection->query($sql) === TRUE) {
                echo json_encode(["success" => true, "message" => "Course updated successfully."]);
            } else {
                echo json_encode(["success" => false, "error" => $connection->error]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Invalid input."]);
        }
        break;


    case 'insert':
        $data = $_POST; 

        header('Content-Type: application/json');

        if (isset($data['course_name'])) {
            $courseName = $connection->real_escape_string($data['course_name']); 

            $sql = "INSERT INTO lms_courses (lms_course_name) VALUES ('$courseName')"; 

            if ($connection->query($sql) === TRUE) {
                echo json_encode(['success' => true]); 
            } else {
                echo json_encode(['success' => false, 'error' => $connection->error]); 
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Course name not provided']); 
        }
        break;
}

<?php 
// Start output buffering
set_time_limit(300);
ob_start();

include '../master/config.php';
require '../lib/excelparse/vendor/autoload.php'; // Include PhpSpreadsheet using Composer
include '../master/sidebar.php';

use PhpOffice\PhpSpreadsheet\IOFactory; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    // Check if the file was uploaded without errors
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Get the uploaded file path and validate the extension
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate the file extension
        if ($fileExtension !== 'xlsx') {
            $_SESSION['messages'][] = "Error: Please upload a valid .xlsx file.";
            header("Location: /SMS/lms_portal_report.php"); // Redirect to your desired page
            exit();
        }

        try {
            // Connect to MySQL database
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Load the Excel file
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Get current date for report_date
            $reportDate = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

            // Step 1: Insert missing courses into lms_courses
            $uniqueCourses = [];
            foreach ($sheetData[1] as $col => $courseName) {
                if ($col == 'A') continue; // Skip the Register Number column
                $uniqueCourses[$courseName] = true; // Store unique course names
            }

            // Fetch existing courses in the database
            $existingCourses = $pdo->query("SELECT lms_course_name FROM lms_courses")->fetchAll(PDO::FETCH_COLUMN);
            
            // Insert new courses into the database
            $newCourses = array_diff(array_keys($uniqueCourses), $existingCourses);
            $insertCourseStmt = $pdo->prepare("INSERT INTO lms_courses (lms_course_name) VALUES (:courseName)");
            foreach ($newCourses as $course) {
                $insertCourseStmt->execute([':courseName' => $course]);
            }

            // Fetch course IDs after insertion
            $courseIdMap = [];
            foreach ($pdo->query("SELECT lms_course_id, lms_course_name FROM lms_courses") as $row) {
                $courseIdMap[$row['lms_course_name']] = $row['lms_course_id'];
            }

            // Step 2: Insert scores for each student
            $insertScoreStmt = $pdo->prepare("
                INSERT INTO lms_score (register_no, lms_course_id, score, report_date)
                VALUES (:register_no, :course_id, :score, :report_date)
            ");

            foreach ($sheetData as $index => $row) {
                if ($index == 1) continue; // Skip header row
                $registerNo = $row['A']; // Assuming Register Number is in column 'A'

                // Check if register number exists in student_information
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM student_information WHERE register_no = ?");
                $stmt->execute([$registerNo]);
                $exists = $stmt->fetchColumn();

                if ($exists) {
                    // Loop through course scores, starting from column B
                    foreach ($row as $col => $score) {
                        if ($col == 'A') continue; // Skip the Register Number column

                        $courseName = $sheetData[1][$col]; // Get course name from the header row
                        $courseId = $courseIdMap[$courseName] ?? null; // Get course ID

                        if ($courseId !== null) {
                            // Insert the score entry
                            $insertScoreStmt->execute([
                                ':register_no' => $registerNo,
                                ':course_id' => $courseId,
                                ':score' => $score,
                                ':report_date' => $reportDate
                            ]);
                        } else {
                            $_SESSION['messages'][] = "Course '$courseName' not found for register number '$registerNo'. Skipping score insertion.";
                        }
                    }
                } else {
                    $_SESSION['messages'][] = "Register number '$registerNo' does not exist in student_information. Skipping.";
                }
            }

            $_SESSION['messages'][] = "Data insertion completed successfully.";
            header("Location: /SMS/lms_portal_report.php");
            exit();

        } catch (PDOException $e) {
            $_SESSION['messages'][] = "Database error: " . $e->getMessage();
            header("Location: /SMS/lms_portal_report.php");
            exit();
        }
    } else {
        $_SESSION['messages'][] = "Error uploading file. Error code: " . $_FILES['file']['error'];
        header("Location: /SMS/lms_portal_report.php");
        exit();
    }
} else {
    $_SESSION['messages'][] = "No file uploaded.";
    header("Location: /SMS/lms_portal_report.php");
    exit();
}
// Flush the output buffer
ob_end_flush();


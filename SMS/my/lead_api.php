<?php
include '../master/config.php';
include '../master/session.php';

$register_no = $_SESSION['register_no'];
$response = [];


$past_week_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $query = "
        SELECT
            COUNT(lms.score) as question_count,
            DATE(report_date) as report_date
        FROM 
            lms_score lms 
        JOIN 
            lms_courses courses 
        ON 
            lms.lms_course_id = courses.lms_course_id  
        WHERE 
            register_no = '$register_no' 
        AND 
            report_date = '$date'
        AND 
            courses.lms_course_name NOT IN ('Rank', 'Total Score', 'Total - Diff')
        GROUP BY 
            DATE(report_date)
    ";
    
    $result = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $past_week_data[] = [
            'date' => $date,
            'count' => (int)$row['question_count']
        ];
    } else {
        $past_week_data[] = [
            'date' => $date,
            'count' => 0
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($past_week_data);
?>
<?php
include '../master/config.php';
include '../master/session.php';
$register_no = $_SESSION['register_no'];
$current_date = date('Y-m-d');

$lms_id = "
    SELECT
        lms.score as score,
        lms.lms_course_id as id,
        courses.lms_course_name as course_name 
    FROM 
        lms_score lms 
    JOIN 
        lms_courses courses 
    ON 
        lms.lms_course_id = courses.lms_course_id  
    WHERE 
        register_no = '$register_no' 
    AND 
        report_date = '$current_date'
    AND 
        courses.lms_course_name NOT IN ('Rank', 'Total Score', 'Total - Diff') -- Exclude specific courses
";

$query = mysqli_query($connection, $lms_id);

$course_data = [];
$placement_course_data = [];

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $course_name = $row['course_name'];
        $score = $row['score'];

        if (stripos($course_name, 'L') === 0) {
            $placement_course_data['Placement Course'][] = $score;
        } else {
            $course_data[$course_name] = $score;
        }
    }
    
    if (!empty($placement_course_data['Placement Course'])) {
        $average_score = array_sum($placement_course_data['Placement Course']) / count($placement_course_data['Placement Course']);
        $course_data['Placement Course'] = round($average_score, 2);
    }

    arsort($course_data);

    echo json_encode($course_data);
} else {
    echo json_encode(["error" => mysqli_error($connection)]);
}
?>

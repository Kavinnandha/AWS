<?php
include 'lms_portal_report_details.php';

// Course Completion Section
$course_completion_sql = "
SELECT 
    si.batch_id, 
    s.section_name, 
    d.name AS department_name, 
    lc.lms_course_name, 
    COUNT(DISTINCT ls.register_no) AS total_std
FROM 
    lms_score ls
JOIN 
    lms_courses lc ON ls.lms_course_id = lc.lms_course_id
JOIN 
    student_information si ON ls.register_no = si.register_no
JOIN 
    mapping_program_department mpd ON si.mapping_id = mpd.mapping_id
JOIN 
    section s ON s.section_id = si.section_id
JOIN 
    department d ON d.department_id = mpd.department_id
JOIN
    batch b ON si.batch_id = b.batch_id
WHERE 
        (si.batch_id = $selected_batch OR $selected_batch IS NULL) AND
        (mpd.department_id = $selected_department OR $selected_department IS NULL) AND
        ls.report_date = '$selected_date' AND
        ls.score > 0
GROUP BY
    si.batch_id, s.section_name, d.name, lc.lms_course_name;
";

$result = $connection->query($course_completion_sql);

$data = [];
$departments = [];
$courses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $department_id = $row['department_name'];
        $section_name = $row['section_name'];
        $course_name = $row['lms_course_name'];
        $total_std = $row['total_std'];

        $data[$department_id][$section_name][$course_name] = $total_std;

        if (!in_array($department_id, $departments)) {
            $departments[] = $department_id;
        }

        if (!in_array($course_name, $courses)) {
            $courses[] = $course_name;
        }
    }
}

$course_completion = [
    "data" => $data,
    "departments" => $departments,
    "courses" => $courses
];

// Overall Performance Courses - Header
$performance_courseNames = [];
$performance_course_query = "
    SELECT DISTINCT 
        lc.lms_course_name 
    FROM 
        lms_score ls 
    JOIN 
        lms_courses lc ON ls.lms_course_id = lc.lms_course_id
    JOIN
        student_information si ON si.register_no = ls.register_no
    JOIN
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id 
    WHERE 
        ls.report_date = '$selected_date' AND
        (mpd.department_id = $selected_department OR $selected_department IS NULL)     
";
$performance_course_result = $connection->query($performance_course_query);

if ($performance_course_result && $performance_course_result->num_rows > 0) {
    while ($row = $performance_course_result->fetch_assoc()) {
        $performance_courseNames[] = $row['lms_course_name'];
    }
}

// Overall Performance Query
$performance_sql = "
    SELECT 
        si.register_no, 
        si.name AS student_name,
        d.name AS department_name,
        s.section_name,
        lc.lms_course_name,
        SUM(ls.score) AS total_score
    FROM
        lms_score ls
    JOIN
        lms_courses lc ON lc.lms_course_id = ls.lms_course_id
    JOIN
        student_information si ON ls.register_no = si.register_no
    JOIN
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
    JOIN
        department d ON d.department_id = mpd.department_id
    JOIN 
        section s ON s.section_id = si.section_id
    WHERE
        (si.batch_id = $selected_batch OR $selected_batch IS NULL) AND
        (mpd.department_id = $selected_department OR $selected_department IS NULL) AND
        ls.report_date = '$selected_date'
    GROUP BY 
        si.register_no, lc.lms_course_name
    ORDER BY
        si.register_no, lc.lms_course_name;
";

$performance_result = $connection->query($performance_sql);

$performanceData = []; 
if ($performance_result && $performance_result->num_rows > 0) {
    $currentStudent = null;
    $studentCourses = array_fill_keys($performance_courseNames, '-');
    $s_no = 1;

    while ($row = $performance_result->fetch_assoc()) {
        $registerNo = $row['register_no'];

        if ($currentStudent && $currentStudent['register_no'] !== $registerNo) {
            // Add previous student record to performanceData
            $currentStudent['s_no'] = $s_no++; // Assign and increment serial number here
            $currentStudent['courses'] = $studentCourses;
            $performanceData[] = $currentStudent;
            $studentCourses = array_fill_keys($performance_courseNames, '-'); // Reset for the next student
        }

        // Prepare the new currentStudent record
        $currentStudent = [
            'register_no' => $registerNo,
            'student_name' => $row['student_name'],
            'department_name' => $row['department_name'],
            'section_name' => $row['section_name']
        ];

        // Populate the score for the specific course
        $studentCourses[$row['lms_course_name']] = $row['total_score'];
    }

    // Add the last student record to performanceData
    $currentStudent['s_no'] = $s_no++; 
    $currentStudent['courses'] = $studentCourses;
    $performanceData[] = $currentStudent;
}

$performance = [
    "performance_courses" => $performance_courseNames,
    "performance_students" => $performanceData
];

// Performance Difference Courses - Header
$difference_courseNames = [];
$difference_course_query = "
    SELECT DISTINCT 
        lc.lms_course_name 
    FROM 
        lms_score ls 
    JOIN 
        lms_courses lc ON ls.lms_course_id = lc.lms_course_id
    JOIN
        student_information si ON si.register_no = ls.register_no
    JOIN
        mapping_program_department mpd ON mpd.mapping_id = si.mapping_id 
    WHERE 
        ls.report_date = '$latestDate' AND
        (mpd.department_id = $selected_department OR $selected_department IS NULL)     
";
$difference_course_result = $connection->query($difference_course_query);

if ($difference_course_result && $difference_course_result->num_rows > 0) {
    while ($row = $difference_course_result->fetch_assoc()) {
        $difference_courseNames[] = $row['lms_course_name'];
    }
}

// Overall Performance Query - Difference
$difference_sql = "
    SELECT 
    si.register_no, 
    si.name AS student_name,
    d.name AS department_name,
    s.section_name,
    lc.lms_course_name,
    (ls2.score - ls.score) AS score_difference
FROM
    lms_score ls
JOIN 
    lms_score ls2 ON ls.lms_course_id = ls2.lms_course_id 
                  AND ls.register_no = ls2.register_no
                  AND ls.report_date = '$previousDate'
                  AND ls2.report_date = '$latestDate'
JOIN
    lms_courses lc ON lc.lms_course_id = ls.lms_course_id
JOIN
    student_information si ON ls.register_no = si.register_no
JOIN
    mapping_program_department mpd ON mpd.mapping_id = si.mapping_id
JOIN
    department d ON d.department_id = mpd.department_id
JOIN 
    section s ON s.section_id = si.section_id
WHERE
    (si.batch_id = $selected_batch OR $selected_batch IS NULL) AND
    (mpd.department_id = $selected_department OR $selected_department IS NULL)
GROUP BY 
    si.register_no, lc.lms_course_name
ORDER BY
    si.register_no, lc.lms_course_name;

";

$differenceData = []; 
$s_no = 1;
$currentStudent = null;
$difference_studentCourses = array_fill_keys($difference_courseNames, '-'); // Fill with default '-' values

$difference_result = $connection->query($difference_sql);

if ($difference_result && $difference_result->num_rows > 0) {
    while ($row = $difference_result->fetch_assoc()) {
        $registerNo = $row['register_no'];

        // Check if we have moved to a new student record
        if ($currentStudent && $currentStudent['register_no'] !== $registerNo) {
            // Save the current student data
            $currentStudent['s_no'] = $s_no++; // Assign and increment serial number
            $currentStudent['scores'] = $difference_studentCourses; // Store courses with their scores
            $differenceData[] = $currentStudent;

            // Reset for the next student
            $difference_studentCourses = array_fill_keys($difference_courseNames, '-');
        }

        // Update current student information
        $currentStudent = [
            'register_no' => $registerNo,
            'student_name' => $row['student_name'],
            'department_name' => $row['department_name'],
            'section_name' => $row['section_name']
        ];

        // Store the score difference for the specific course
        $difference_studentCourses[$row['lms_course_name']] = $row['score_difference'];
    }

    // Add the last student record to differenceData
    $currentStudent['s_no'] = $s_no++; 
    $currentStudent['scores'] = $difference_studentCourses;
    $differenceData[] = $currentStudent;
}

$difference = [
    "difference_courses" => $difference_courseNames,
    "difference_students" => $differenceData
];

// Student Radar Chart
$register_no = $_POST['register_no'] ?? 0;

$radar_student_details_query = "
    SELECT 
        si.name AS student_name
    FROM 
        student_information si
    WhERE
        register_no = '$register_no'
";

$radar_student_details_result = $connection->query($radar_student_details_query);
$radar_student_details = [];
if ($radar_student_details_result && $radar_student_details_result->num_rows > 0) {
    $row = $radar_student_details_result->fetch_assoc();
    $radar_student_details = $row['student_name'];
}


$radar_chart_query = "
    SELECT
        ls.score AS radar_score,
        lc.lms_course_name AS radar_course_name 
    FROM 
        lms_score ls 
    JOIN 
        lms_courses lc ON ls.lms_course_id = lc.lms_course_id  
    WHERE 
        register_no = '$register_no' AND 
        report_date = '$latestDate'
    AND 
        lc.lms_course_name NOT IN ('Rank', 'Total Score', 'Total - Diff')
";

$radar_result = $connection->query($radar_chart_query);

$radar_course_data = [];
$radar_placement_course_data = [];

if ($radar_result) {
    while ($row = mysqli_fetch_assoc($radar_result)) {
        $radar_course_name = $row['radar_course_name'];
        $radar_score = $row['radar_score'];

        if (stripos($radar_course_name, 'L') === 0) {
            $radar_placement_course_data['Placement Course'][] = $radar_score;
        } else {
            $radar_course_data[$radar_course_name] = $radar_score;
        }
    }

    if (!empty($radar_placement_course_data['Placement Course'])) {
        $radar_average_score = array_sum($radar_placement_course_data['Placement Course']) / count($radar_placement_course_data['Placement Course']);
        $radar_course_data['Placement Course'] = round($radar_average_score, 2);
    }

    arsort($radar_course_data);
}

$radar_data = [
    "radar_student_details" => $radar_student_details,
    "radar_chart_data" => $radar_course_data];

$response = [
    "course_completion" => $course_completion,
    "performance" => $performance,
    "difference" => $difference,
    "radar_data" => $radar_data
];

header('Content-Type: application/json');
echo json_encode($response);

<?php
$register_no = $_SESSION['register_no'];

$date_query = "
    SELECT DISTINCT ls.report_date 
    FROM lms_score ls
    WHERE
      ls.register_no = $register_no
    ORDER BY ls.report_date DESC
";
$date_result = mysqli_query($connection, $date_query);

$dates = [];
while ($date_row = mysqli_fetch_assoc($date_result)) {
    $dates[] = $date_row['report_date'];
}

$lms_report_sql = "
    SELECT 
        lc.lms_course_name, 
        ls.report_date,
        ls.score
    FROM
        lms_score ls
    JOIN
        lms_courses lc ON lc.lms_course_id = ls.lms_course_id
    WHERE
        ls.register_no = $register_no
    ORDER BY 
        lc.lms_course_name, ls.report_date DESC
";
$report_result = mysqli_query($connection, $lms_report_sql);

$course_data = [];
while ($report_row = mysqli_fetch_assoc($report_result)) {
    $course_name = $report_row['lms_course_name'];
    $report_date = $report_row['report_date'];
    $score = $report_row['score'];

    $course_data[$course_name][$report_date] = $score;
}

$lms_report_data = "";

$lms_report_data .= "<table class='table table-striped'>";
$lms_report_data .= "<tr><th>Course Name</th>";
foreach ($dates as $date) {
    $lms_report_data .= "<th>" . htmlspecialchars($date) . "</th>";
}
$lms_report_data .= "</tr>";

foreach ($course_data as $course_name => $scores_by_date) {
    $lms_report_data .= "<tr>";
    $lms_report_data .= "<td>" . htmlspecialchars($course_name) . "</td>";

    foreach ($dates as $date) {
        $lms_report_data .= "<td>" . (isset($scores_by_date[$date]) ? htmlspecialchars($scores_by_date[$date]) : '-') . "</td>";
    }
    $lms_report_data .= "</tr>";
}

$lms_report_data .= "</table>";

mysqli_free_result($date_result);
mysqli_free_result($report_result);

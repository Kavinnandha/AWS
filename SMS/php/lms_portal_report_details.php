<?php

include $_SERVER['DOCUMENT_ROOT'] . '/SMS/master/config.php';

$selected_batch = isset($_POST['batch']) ? $_POST['batch'] : 'NULL';
$selected_date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
$selected_department = isset($_POST['department']) ? $_POST['department'] : 'NULL';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truncateData'])) {
    $startDate = mysqli_real_escape_string($connection, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($connection, $_POST['endDate']);

    $sql = "DELETE FROM lms_score WHERE report_date BETWEEN '$startDate' AND '$endDate'";

    if (mysqli_query($connection, $sql)) {
        header("Location: /SMS/lms_portal_report.php?message=" . urlencode("Records successfully deleted for the specified date range."));
    } else {
        header("Location: lms_portal_report.php?message=" . urlencode("Error deleting records: " . mysqli_error($connection)));
    }
    exit(); 
}


// Fetching batches
$batch_sql = "SELECT batch_id, batch_name FROM batch ORDER BY batch_id DESC";
$batch_result = mysqli_query($connection, $batch_sql);

$batch_data = "";
if ($batch_result && $batch_result->num_rows > 0) {
    while ($row = $batch_result->fetch_assoc()) {
        $batch_data .= '<option value="' . $row['batch_id'] . '"' . ($selected_batch == $row['batch_id'] ? ' selected' : '') . '>' . $row['batch_name'] . '</option>';
    }
}

// Fetch department
$department_sql = "SELECT department_id, name AS department_name FROM department";
$department_result = mysqli_query($connection, $department_sql); 

$department_data = "";
if ($department_result && $department_result->num_rows > 0) {
    while ($row = $department_result->fetch_assoc()) {
        $department_data .= "<option value='" . $row['department_id'] . "'" . ($selected_department == $row['department_id'] ? ' selected' : '') . ">" . $row['department_name'] . "</option>";
    }
}

$latestDateQuery = "SELECT MAX(report_date) AS latest_date FROM lms_score";
$latestDateResult = $connection->query($latestDateQuery);
$latestDateRow = $latestDateResult->fetch_assoc();
$latestDate = $latestDateRow['latest_date'];

$datesQuery = "SELECT DISTINCT report_date FROM lms_score WHERE report_date < '$latestDate' ORDER BY report_date DESC";
$datesResult = $connection->query($datesQuery);

$previousDate = null;
if ($datesResult && $datesResult->num_rows > 0) {
    $row = $datesResult->fetch_assoc();
    $previousDate = isset($_POST['days']) ? $_POST['days'] : $row['report_date'];
}

$PreviousDaysDropdown = '';
if ($datesResult && $datesResult->num_rows > 0) {
    mysqli_data_seek($datesResult, 0);
    while ($dateRow = $datesResult->fetch_assoc()) {
        $currentDate = $dateRow['report_date'];
        $dateDifference = (strtotime($latestDate) - strtotime($currentDate)) / (60 * 60 * 24);
        $PreviousDaysDropdown .= "<option value='" . $currentDate . "'>Previous " . $dateDifference . " day" . ($dateDifference > 1 ? "s" : "") . "</option>";
    }
}


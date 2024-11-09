<?php include 'leave_info.php' ;
include 'extra_curricular_table.php';
include 'attendance_report.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Charts in Row</title>
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/stu.css">
</head>
<body>
    <div class="container">
    <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card total-students" data-bs-toggle="modal" data-bs-target="#totalModal">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                            <i class="fi fi-rr-user-graduate"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">Overall Attendance Percentage</h3>
                                <p class="stat-value"><?php echo $attendance_percentage ;?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="stat-card on-duty">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                            <i class="fi fi-rr-ranking-podium"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">LearderBoard - Rank</h3>
                                <p class="stat-value">15</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-3">
                    <div class="stat-card absent">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                            <i class="fi fi-rr-leave"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">No Of Leave Applied</h3>
                                <p class="stat-value"><?php echo $tot_leave['total'];?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="stat-card arrears">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                            <i class="fi fi-rr-badge-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">CGPA</h3>
                                <p class="stat-value">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row justify-content car-1">
            <div class="col-lg justify-content">
                <div class="card">
                    <div class="card-header fw-bold text-light bg-success">
                        No Of Periods Attended Each Subject
                    </div>
                    <div class="chart-container">
                        <canvas class="can-2" id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header fw-bold text-light bg-success">
                        Total Attendance Percentage
                    </div>
                    <div class="chart-container">
                        <canvas class="can-1" id="pieChart"></canvas>
                    </div>
                    <div class="device-legend">
                        <div class="con"><span class="legend-color" style="background-color:#4caf50;"></span>Periods Attended</div>
                        <div class="con"><span class="legend-color" style="background-color:#f44336;"></span>Periods Missed</div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header fw-bold text-light bg-success">
                        Leaderboard
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Student A - Rank 1</li>
                            <li class="list-group-item">Student B - Rank 2</li>
                            <li class="list-group-item" style="background-color: rgb(130, 192, 246);">Name - Rank 3</li>
                            <li class="list-group-item">Student D - Rank 4</li>
                            <li class="list-group-item">Student E - Rank 5</li>
                            <li class="list-group-item">Student F - Rank 6</li>
                            <li class="list-group-item">Student G - Rank 7</li>
                            <li class="list-group-item">Student H - Rank 8</li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header fw-bold bg-success text-light">
                        Extra-Curricular
                    </div>
                    <div class="card-body table-container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-black" style="background-color: rgb(106, 212, 29);">Name oF the Event</th>
                                    <th scope="col" class="bg-warning">Type</th>
                                    <th scope="col" class="text-black" style="background-color: #b69c09b1;">Points Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $data;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 d-flex align-items-stretch">
                <div class="card w-100 h-100 shadow-sm">
                    <div class="card-header fw-bold text-light bg-success">
                        Leave Application Status
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                No. of Leaves Applied: <?php echo $tot_leave['total'];?>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#appliedLeaveModal">View</button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                No. of Leaves Approved: <?php echo $leave_approved['approved'];?>
                                <button class="btn btn-info btn-sm bg-success" data-bs-toggle="modal" data-bs-target="#approvedLeaveModal">View</button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                No. of Leaves Rejected: <?php echo $leave_not_approved['not_approved'];?>
                                <button class="btn btn-info btn-sm bg-danger" data-bs-toggle="modal" data-bs-target="#rejectedLeaveModal">View</button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                No. of Applications Waitlisted: <?php echo $leave_wait['waiting']; ?>
                                <button class="btn btn-info btn-sm bg-warning" data-bs-toggle="modal" data-bs-target="#waitlistedLeaveModal">View</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal" id="appliedLeaveModal" tabindex="-1" aria-labelledby="appliedLeaveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appliedLeaveModalLabel">Leave Applied Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                        <?php
                    if (mysqli_num_rows($total_leave_data_result) > 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($total_leave_data_result)) {
                            echo "<li>Leave $count: " . htmlspecialchars($row['reason']) . "</li>";
                            $count++;
                        }
                    } else {
                        echo "<li>No leave records found</li>";
                    }
                    ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="approvedLeaveModal" tabindex="-1" aria-labelledby="approvedLeaveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvedLeaveModalLabel">Approved Leave Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                        <?php
                        if (mysqli_num_rows($total_approve_data_result) > 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($total_approve_data_result)) {
                            echo "<li>Leave $count: " . htmlspecialchars($row['reason']) . "</li>";
                            $count++;
                        }
                    } else {
                        echo "<li>No leave records found</li>";
                    }
                    ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="rejectedLeaveModal" tabindex="-1" aria-labelledby="rejectedLeaveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectedLeaveModalLabel">Rejected Leave Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                        <?php
                        if (mysqli_num_rows($total_reject_data_result) > 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($total_reject_data_result)) {
                            echo "<li>Leave $count: " . htmlspecialchars($row['reason']) . "</li>";
                            $count++;
                        }
                    } else {
                        echo "<li>No leave records found</li>";
                    }
                    ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="waitlistedLeaveModal" tabindex="-1" aria-labelledby="waitlistedLeaveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="waitlistedLeaveModalLabel">Waitlisted Leave Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul>
                        <?php
                        if (mysqli_num_rows($total_wait_data_result) > 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($total_wait_data_result)) {
                            echo "<li>Leave $count: " . htmlspecialchars($row['reason']) . "</li>";
                            $count++;
                        }
                    } else {
                        echo "<li>No leave records found</li>";
                    }
                    ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/dash.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

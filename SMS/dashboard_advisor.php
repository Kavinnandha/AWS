<?php
include 'master/dependancies.php';
include 'master/sidebar.php';
if ($role == 6):
    include 'master/config.php';
    include 'php/dashboard_advisor_details.php';
    include 'php/dashboard_staff_details.php';
    include 'php/search_details.php';
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advisor Dashboard</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href="/SMS/master/css/dashboard_advisor_styles.css" rel="stylesheet">
    </head>

    <body>
        <div class="container my-4">
                <div class="row g-4">
                    <!-- Total Students Card -->
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card total-students" data-bs-toggle="modal" data-bs-target="#totalModal">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="fi fi-rr-users"></i>
                                </div>
                                <div class="stat-content">
                                    <h3 class="stat-title">Total Students</h3>
                                    <p class="stat-value"><?php echo $total; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects Taught Card -->
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card subjects-taught" data-bs-toggle="modal" data-bs-target="#subjectModal">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="fi fi-rr-book-open-cover"></i>
                                </div>
                                <div class="stat-content">
                                    <h3 class="stat-title">Subjects Taught</h3>
                                    <p class="stat-value"><?php echo $count; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slow Learners Card -->
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card slow-learners">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="fi fi-rr-brain"></i>
                                </div>
                                <div class="stat-content">
                                    <h3 class="stat-title">Slow Learners</h3>
                                    <p class="stat-value">20</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Students with Arrear Card -->
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card arrears">
                            <div class="stat-card-body">
                                <div class="stat-icon">
                                    <i class="fi fi-rr-triangle-warning"></i>
                                </div>
                                <div class="stat-content">
                                    <h3 class="stat-title">Students with Arrear</h3>
                                    <p class="stat-value">15</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row 1: Leave Requests and Attendance Missed -->
            <div class="row">
                <div class="container">
                    <div class="card">
                        <div class="card-header bg-info text-white text-center">
                            <h5 class="card-title">Today Missed Attendance</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table">
                                    <tr>
                                        <th scope="col">DAY/TIME</th>
                                        <th scope="col">I</th>
                                        <th scope="col">II</th>
                                        <th scope="col">III</th>
                                        <th scope="col">IV</th>
                                        <th scope="col">V</th>
                                        <th scope="col">VI</th>
                                        <th scope="col">VII</th>
                                        <th scope="col">VIII</th>
                                        <th scope="col">IX</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-primary">
                                        <?php echo $time_table; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="totalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="totalModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="totalModalLabel">Total Students</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="total_student" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Register No</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Batch</th>
                                                <th>Section</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $total_data; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="subjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="subjectModalLabel">Subject Taught</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Department</th>
                                                <th>Batch</th>
                                                <th>Section</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $subject_data; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Student Attendance</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-muted">Low Attendance Students</h6>
                                <form action="" method="post" class="mb-3">
                                    <?php echo $main_dropdown; ?>
                                    <div>
                                        <button class="btn btn-success mt-3">Submit</button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <th>Register No</th>
                                                <th>Name</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Top Achievers</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-muted">Students with High Marks</h6>
                                <form action="" method="post" class="mb-3">
                                    <?php echo $main_dropdown; ?>
                                    <div>
                                        <button class="btn btn-success mt-3">Submit</button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-hover mt-5">
                                        <thead>
                                            <tr>
                                                <th>Register No</th>
                                                <th>Name</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row mt-3">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Leave Requests</h5>
                                    <a class="btn btn-light btn-sm" href="/SMS/leave_approvals.php">View Requests</a>
                                </div>

                                <div class="scrollable-content-leave-requests">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Days</th>
                                                    <th>Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo $leave_requests; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-info text-white text-center">
                                    <h5 class="card-title">Attendance Missed</h5>
                                </div>
                                <div class="scrollable-content-leave-requests">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Period</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo $missed_attendance_rows; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Absent Period Report and Attendance Dips -->
                    <div class="row ">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Absent Period Report</h5>
                                    <span><strong>Date:</strong> <?php echo date('d-m-Y'); ?></span>
                                </div>
                                <div class="scrollable-content-absent-period-report">
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Period</th>
                                                    <th>Present</th>
                                                    <th>Absent</th>
                                                    <th>OD</th>
                                                    <th>Absent List</th>
                                                    <th>OD List</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php echo $attendance_rows; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-warning text-dark text-center">
                                    <h5 class="card-title">Attendance Dips</h5>
                                </div>
                                <div class="scrollable-content-absent-period-report">
                                    <div class="card-body text-center">
                                        <canvas id="lowAttendanceChart"></canvas>
                                        <div class="table-responsive">
                                            <table class="table mt-5" id="lowAttendance">
                                                <thead>
                                                    <tr>
                                                        <th>Register No</th>
                                                        <th>Name</th>
                                                        <th>Percentage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php echo $low_attendance_data; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Star Students, Lagging Learners, and Semester Setbacks -->
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-success text-white text-center">
                                    <h5 class="card-title">Star Students</h5>
                                </div>
                                <div class="card-body scrollable-content-star-students">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Student X - Rank 1</li>
                                        <li class="list-group-item">Student Y - Rank 2</li>
                                        <li class="list-group-item">Student Z - Rank 3</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-danger text-white text-center">
                                    <h5 class="card-title">Lagging Learners</h5>
                                </div>
                                <div class="card-body scrollable-content-lagging-learners">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Student A - Rank 98</li>
                                        <li class="list-group-item">Student B - Rank 99</li>
                                        <li class="list-group-item">Student C - Rank 100</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-custom">
                                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Semester Setbacks</h5>
                                    <a href="/SMS/semester_setbacks_info.php" class="text-white">More Info</a>
                                </div>
                                <div class="card-body text-center">
                                    <canvas id="arrearsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart.js Scripts -->
                <script>
                    var ctx1 = document.getElementById('lowAttendanceChart').getContext('2d');
                    var lowAttendanceChart = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: <?php echo $labels_json; ?>,
                            datasets: [{
                                label: 'Attendance %',
                                data: <?php echo $data_json; ?>,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        }
                    });

                    var ctx2 = document.getElementById('arrearsChart').getContext('2d');
                    var arrearsChart = new Chart(ctx2, {
                        type: 'pie',
                        data: {
                            labels: ['Cleared', 'Arrears'],
                            datasets: [{
                                data: [75, 25],
                                backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)'],
                                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                                borderWidth: 1
                            }]
                        }
                    });
                </script>
    </body>

    </html>

<?php
else:
    echo "Are you advisor, aren't you?";
endif;
?>
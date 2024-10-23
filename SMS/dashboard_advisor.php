<?php
include 'master/dependancies.php';
include 'master/sidebar.php';
if ($role == 6):
include 'master/config.php';
include 'php/dashboard_advisor_details.php';
include 'php/timetable_details.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advisor Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="/sms/master/css/dashboard_advisor_styles.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">
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
            <div>
                <div class="row mt-3">
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-custom">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Leave Requests</h5>
                                <a class="btn btn-light btn-sm" href="/sms/leave_approvals.php">View Requests</a>
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
                            <div class="card-body">
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
                            <div class="card-body">
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
                                <a href="/sms/semester_setbacks_info.php" class="text-white">More Info</a>
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
<?php
include 'master/dependancies.php';
include 'master/sidebar.php';
if ($role == 2):
    include 'master/config.php';
    include 'php/dashboard_principal_details.php';
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/SMS/master/css/dashboard_principal_styles.css">

    <body>
        <div class="container-fluid p-4">
            <!-- Faculty and Student Overview Cards -->
            <div class="row g-4 mb-4">
                <!-- Faculty Overview Card -->
                <!-- Faculty Attendance Cards -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center text-black bg-gradient-secondary rounded shadow-sm p-4">
                            <h4 class="mb-4 fw-bold">Faculty Attendance</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#facultyModal">
                                        <div class="card-body text-primary text-center">
                                            <h6 class="fw-bold"><i class="bi bi-people-fill"></i> Total Faculties</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $total_faculty ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#facultyModal">
                                        <div class="card-body text-success text-center">
                                            <h6 class="fw-bold"><i class="bi bi-person-check-fill"></i> Present</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $faculty_present ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#facultyModal">
                                        <div class="card-body text-danger text-center">
                                            <h6 class="fw-bold"><i class="bi bi-person-x-fill"></i> Absent</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $faculty_absent ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#facultyModal">
                                        <div class="card-body text-info text-center">
                                            <h6 class="fw-bold"><i class="bi bi-person-bounding-box"></i> On Duty (OD)</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $faculty_onduty ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Faculty Attendance Modal -->
                <div class="modal fade" id="facultyModal" tabindex="-1" aria-labelledby="facultyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="facultyModalLabel">Faculty Attendance Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Department</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>On Duty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $faculty_attendance_modal; ?>
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




                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Department</th>
                                                <th>Total</th>
                                                <th>Present</th>
                                                <th>Absent</th>
                                                <th>OD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $student_attendance_modal ?>
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

                <!-- Student Overview Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center text-black bg-gradient-secondary rounded shadow-sm p-4">
                            <h4 class="mb-4 fw-bold">Student Attendance</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <div class="card-body text-primary text-center">
                                            <h6 class="fw-bold"><i class="bi bi-people-fill"></i> Total Students</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $total_students_all ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <div class="card-body text-success text-center">
                                            <h6 class="fw-bold"><i class="bi bi-person-check-fill"></i> Present</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $student_present ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <div class="card-body text-danger text-center">
                                            <h6 class="fw-bold"><i class="bi bi-person-x-fill"></i> Absent</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $student_absent ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 rounded shadow h-100 bg-white card-hover" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <div class="card-body text-info text-center">
                                            <h6 class="fw-bold"><i class="bi bi-person-bounding-box"></i> On Duty (OD)</h6>
                                            <p class="fs-4 fw-bold">
                                                <?php echo $student_onduty ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Requests Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mt-1">Leave Requests</h5>
                    <a class="btn btn-light btn-sm" href="/SMS/leave_approvals.php">View All Requests</a>
                </div>
                <div class="card-body">
                    <!-- Faculty Leave Requests Section -->
                    <div class="table-responsive">
                        <h5 class="text-center py-2">Faculty Requests</h5>
                        <table class="table table-striped">
                            <?php echo $faculty_leave_requests; ?>
                        </table>

                        <!-- Student Leave Requests Section -->
                        <h5 class="text-center py-2">Student Requests</h5>
                        <table class="table table-striped">
                            <?php echo $student_leave_requests; ?>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Leave Chart Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mt-1">Leave Charts</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div id="leaveChart_faculty" style="height: 400px; width: 90%;"></div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div id="leaveChart_student" style="height: 400px; width: 90%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Load Google Charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load the Visualization API and the corechart package
            google.charts.load('current', {
                packages: ['corechart']
            });

            // Set a callback to run when the Google Visualization API is loaded
            google.charts.setOnLoadCallback(drawCharts);

            function drawCharts() {
                // Faculty Leave Chart
                var facultyData = google.visualization.arrayToDataTable([
                    ['Leave Type', 'Count'],
                    ['Faculty Present', <?php echo $faculty_present; ?>],
                    ['Faculty Absent', <?php echo $faculty_absent; ?>],
                    ['Faculty On Duty', <?php echo $faculty_onduty; ?>]
                ]);

                var facultyOptions = {
                    title: 'Faculty Leave Chart',
                    is3D: true,
                    slices: {
                        0: {
                            offset: 0.1
                        },
                        1: {
                            offset: 0.1
                        },
                        2: {
                            offset: 0.1
                        }
                    },
                    height: 400,
                    legend: {
                        position: 'bottom'
                    }
                };

                var facultyChart = new google.visualization.PieChart(document.getElementById('leaveChart_faculty'));
                facultyChart.draw(facultyData, facultyOptions);

                // Student Leave Chart
                var studentData = google.visualization.arrayToDataTable([
                    ['Leave Type', 'Count'],
                    ['Student Present', <?php echo $student_present; ?>],
                    ['Student Absent', <?php echo $student_absent; ?>],
                    ['Student On Duty', <?php echo $student_onduty; ?>]
                ]);

                var studentOptions = {
                    title: 'Student Leave Chart',
                    is3D: true,
                    slices: {
                        0: {
                            offset: 0.1
                        },
                        1: {
                            offset: 0.1
                        },
                        2: {
                            offset: 0.1
                        }
                    },
                    height: 400,
                    legend: {
                        position: 'bottom'
                    }
                };

                var studentChart = new google.visualization.PieChart(document.getElementById('leaveChart_student'));
                studentChart.draw(studentData, studentOptions);
            }

            // Make charts responsive on window resize
            window.addEventListener('resize', drawCharts);
        </script>

    </body>
<?php
else:
    echo "wait...you're not the principal!";
endif;
?>

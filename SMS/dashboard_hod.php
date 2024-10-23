<?php

include 'master/dependancies.php';
include 'master/sidebar.php';
if ($role == 1):
    include 'master/config.php';
    include 'php/dashboard_hod_details.php';
    include 'php/dashboard_staff_details.php';
    include 'php/search_details.php';
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HOD Dashboard</title>
        <link href="/sms/master/css/dashboard_hod_style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid mt-4">
            <div class="row">
                <!-- Left Section -->
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="stat-card total-students">
                                <h6>Students</h6>
                                <p class="display-6">
                                    <?php echo $total_students; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card total-present">
                                <h6>Present</h6>
                                <p class="display-6">
                                    <?php echo $total_present; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card total-od">
                                <h6>OnDuty</h6>
                                <p class="display-6">
                                    <?php echo $total_od; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card total-absent">
                                <h6>Absent</h6>
                                <p class="display-6">
                                    <?php echo $total_absent; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-md-9">
                    <div class="card shadow-custom">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Leave Requests</h5>
                            <a class="btn btn-light btn-sm" href="/sms/leave_approvals.php">View All Requests</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Student Leave Requests -->
                                <div class="col-md-6 mb-3">
                                    <h5>Student Leave Requests</h5>
                                    <div class="scrollable-content">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <?php echo $student_leave_requests; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Faculty Leave Requests -->
                                <div class="col-md-6 mb-3">
                                    <h5>Faculty Leave Requests</h5>
                                    <div class="scrollable-content">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <?php echo $faculty_leave_requests; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card bg-success" data-bs-toggle="modal" data-bs-target="#subjectModal">
                        <div class="card-body text-white">
                            <h5 class="card-title">Subject Taught</h5>
                            <p class="card-text display-6"><?php echo $count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-warning">
                        <div class="card-body text-white">
                            <h5 class="card-title">Slow Learners</h5>
                            <p class="card-text display-6">20</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-danger">
                        <div class="card-body text-white">
                            <h5 class="card-title">Students with Arrear</h5>
                            <p class="card-text display-6">15</p>
                        </div>
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
                            <div class="table-responsive">
                                <table class="table table-hover mt-5" id="lowAttendance">
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



            <div class="row mt-3">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow-custom">
                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Absent Period Report</h5>
                            <span><strong>Date:</strong> <?php echo date('d-m-Y'); ?></span>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Section</th>
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

            <div class="row mt-3">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow-custom">
                        <div class="card-header bg-info bg-gradient text-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Student Feedback</h5>
                        </div>
                        <div class="card-body">
                            <?php echo $student_feedback ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <script>
        new DataTable('#lowAttendance');
    </script>

    </html>
<?php
else:
    echo "are you supposed to be here?";
endif;
?>
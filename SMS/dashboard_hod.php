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
        <link href="/SMS/master/css/dashboard_hod_style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid mt-4">
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
                                <p class="stat-value"><?php echo $total_students; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subjects Taught Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card on-duty">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fi fi-rr-workshop"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">Present</h3>
                                <p class="stat-value"><?php echo $total_present; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slow Learners Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card absent">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fi fi-rr-chalkboard-user"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">OnDuty</h3>
                                <p class="stat-value"><?php echo $total_od; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students with Arrear Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card arrears">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fi fi-rr-person-circle-xmark"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-title">Absent</h3>
                                <p class="stat-value"><?php echo $total_absent; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card shadow-custom">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Leave Requests</h5>
                            <a class="btn btn-light btn-sm" href="/SMS/leave_approvals.php">View All Requests</a>
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

        <?php
        if ($batch_data):
            foreach ($batch_data as $batch_name => $records): ?>
                <div class="row mt-3">
                    <div class="col-lg-12 mb-4">
                        <div class="card shadow-custom">
                            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($batch_name); ?> - Absent Period Report</h5>
                                <span><strong>Date:</strong> <?php echo date('d-m-Y'); ?></span>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
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
                                        <?php if (!empty($records)): ?>
                                            <?php foreach ($records as $data): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($data['section_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['period_no']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['present']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['absent']); ?></td>
                                                    <td><?php echo htmlspecialchars($data['od']); ?></td>
                                                    <td><?php echo !empty($data['absent_names']) ? htmlspecialchars($data['absent_names']) : 'None'; ?></td>
                                                    <td><?php echo !empty($data['od_names']) ? htmlspecialchars($data['od_names']) : 'None'; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No attendance records found for this batch.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endforeach;
        endif;
        ?>

        <?php if (empty($batch_data)): ?>
            <div class="row mt-3">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow-custom">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title">Absent Period Report</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-center">No attendance records found for today.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
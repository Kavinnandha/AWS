<?php

include 'master/dependancies.php';
include 'master/sidebar.php';
if ($role == 0):
    include 'php/search_details.php';
    include 'php/dashboard_staff_details.php';
?>
    <link href="/SMS/master/css/dashboard_advisor_styles.css" rel="stylesheet">

    <body class="bg-light">
        <div class="container-fluid">
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

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Latest Leave Approval Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Type</th>
                                        <th>Reason</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $tleave_data; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        </div>
        </div>
        </div>
        <script>
            new DataTable('#total_student');
        </script>
    </body>

    </html>
<?php
else:
    echo "This page is intentionally left blank";
endif;
?>
<?php

include 'master/dependancies.php';
include 'master/sidebar.php'; 
if($role == 0):
include 'php/search_details.php'; 
include 'php/dashboard_staff_details.php';
?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="container mb-5">
            <div class="row">
                <div class="">
                    <h1 class="h2">Staff Dashboard</h1>
                    <p><?php echo $date; ?></p>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="card bg-primary" data-bs-toggle="modal" data-bs-target="#totalModal">
                            <div class="card-body text-white">
                                <h5 class="card-title">Total Students</h5>
                                <p class="card-text display-6"><?php echo $total; ?></p>
                            </div>
                        </div>
                    </div>
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

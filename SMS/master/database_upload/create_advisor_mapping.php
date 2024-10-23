<?php include '../dependancies.php';
include '../session.php';
$role = $_SESSION['role_id'];
?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>Advisor Mapping</h3>
            </div>
            <div class="card mt-5">
                <div class="card-header">Info</div>
                <div class="card-body">
                    <p class="card-text">The data below maps a teacher to a class as their class advisor. If the teacher or course cannot be found, please ensure that their data exists in the database first.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Section</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include '../../php/get_advisor_details.php';
                        echo $advisor_mapping_data; ?>
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-between mt-4">
                <div class="col-3 ms-4 mb-3">
                    <?php if (in_array($role, [1, 8])): ?>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changeFormModal">Request Change Details</button>
                    <?php endif; ?>
                </div>
                <div class="col-1 ms-4 mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#advisorFormModal">Insert</button>
                </div>
            </div>
            <div class="modal fade" id="changeFormModal" tabindex="-1" aria-labelledby="changeFormModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changeFormModalLabel">Request Change Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="../../php/submit_request.php">
                                <div>
                                    <input type="hidden" name="origin" value="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <b><label class="form-label">Enter the changes :</label></b>
                                    <textarea class="form-control" id="changeFormTeaxtarea" name="request" rows="7" placeholder="Enter the changes"></textarea>
                                </div>
                                <button class="btn btn-success mt-3" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="advisorFormModal" tabindex="-1" aria-labelledby="advisorFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="advisorFormModalLabel">Advisor Mapping Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="../../php/database_upload/upload_advisor_mapping.php">

                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label"><b>Select Name :</b></label>
                                        <select class="form-select" name="user_id" required>
                                            <?php echo $users; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label"><b>Select Department:</b></label>
                                        <select class="form-select" name="mapping_id" required>
                                            <?php echo $department_mapping_data; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label"><b>Select Batch:</b></label>
                                        <select class="form-select" name="batch_id" required>
                                            <?php echo $batch; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label"><b>Select Section:</b></label>
                                        <select class="form-select" name="section_id" required>
                                            <?php echo $section; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="updateAdvisorModal" tabindex="-1" aria-labelledby="updateAdvisorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content justify-content-center ">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAdvisorModalLabel">Advisor Mapping Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post">
                        <input type="hidden" id="editId">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><b>Select Name :</b></label>
                                <select class="form-select" id="editUserId" required>
                                    <?php echo $users; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label"><b>Select Department:</b></label>
                                <select class="form-select" id="editMappingId" required>
                                    <?php echo $department_mapping_data; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><b>Select Batch:</b></label>
                                <select class="form-select" id="editBatchId" required>
                                    <?php echo $batch; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label"><b>Select Section:</b></label>
                                <select class="form-select" id="editSectionId" required>
                                    <?php echo $section; ?>
                                </select>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/update_advisor_mapping.js"></script>
</body>
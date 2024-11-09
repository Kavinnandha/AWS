<?php include '../dependancies.php';
include '../session.php';
$role = $_SESSION['role_id'];
?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>Course Department Batch Mapping</h3>
            </div>
            <div class="card mt-5">
                <div class="card-header">Info</div>
                <div class="card-body">
                    <p class="card-text">This table maps a course to a department,batch,semester and section. For example: CTPS maps to all departments if its a common course, the batch of the first year students,1st semester and all sections.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mt-5" id="course-mapping" >
                    <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Department</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include '../../php/get_course_department_batch_mapping_details.php';
                        echo $course_department_batch_mapping_data; ?>
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
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cdbmFormModal">Insert</button>
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
                                    <textarea class="form-control" name="request" id="changeFormTeaxtarea" rows="7" placeholder="Enter the changes"></textarea>
                                </div>
                                <button class="btn btn-success mt-3" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cdbmFormModal" tabindex="-1" aria-labelledby="cdbmFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cdbmFormModalLabel">Insert Course Deparment Batch Mapping Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="../../php/database_upload/upload_course_department_mapping.php">

                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label"><b>Select Course :</b></label>
                                        <select class="form-select" name="course_id" required>
                                            <?php echo $course; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label"><b>Select Department:</b></label>
                                        <select class="form-select" name="department_id" required>
                                            <?php echo $department; ?>
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
                                        <label class="form-label"><b>Select Semester:</b></label>
                                        <select class="form-select" name="semester" aria-label="Select Semester" required>
                                            <option value="">Select Semester</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
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

    <div class="modal fade" id="updateMappingModal" tabindex="-1" aria-labelledby="updateMappingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content justify-content-center ">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateMappingModalLabel">Update Course Deparment Batch Mapping Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post">:
                        <input type="hidden" id="editId">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label"><b>Select Course :</b></label>
                                <select class="form-select" id="editCourseId" required>
                                    <?php echo $course; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label"><b>Select Department:</b></label>
                                <select class="form-select" id="editMappingId" required>
                                    <?php echo $department; ?>
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
                                <label class="form-label"><b>Select Semester:</b></label>
                                <select class="form-select" id="editSemester" aria-label="Select Semester" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
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
    <script src="../js/update_course_department_batch_mapping.js"></script>
</body>

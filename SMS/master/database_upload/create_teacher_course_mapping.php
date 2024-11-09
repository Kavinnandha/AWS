<?php include '../dependancies.php';
include '../session.php';
$role = $_SESSION['role_id'];
?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>Teacher Course Mapping</h3>
            </div>
            <div class="card mt-5">
                <div class="card-header">Info</div>
                <div class="card-body">
                    <p class="card-text">This table maps a teacher to course, implying that the course is taught by the specified teacher for that class.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mt-5" id="teacher-course-map">
                    <thead>
                        <tr>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Course</th>
                            <th scope="col">Department</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Section</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include '../../php/get_teacher_course_mapping_details.php';
                        echo $teacher_course_mapping_data; ?>
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
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#teacherFormModal">Insert</button>
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
                                <input type="hidden" name="origin" value="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div>
                                    <b><label class="form-label">Enter the changes :</label></b>
                                    <textarea class="form-control" name="request" id="changeFormTeaxtarea" rows="7" placeholder="Enter the changes"></textarea>
                                </div>
                                <button class="btn btn-success mt-3" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="teacherFormModal" tabindex="-1" aria-labelledby="teacherFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="teacherFormModalLabel">Insert Teacher Course Mapping Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aMarksria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="../../php/database_upload/upload_teacher_course_mapping.php">
                                <div class="row">
                                    <div class="col">
                                        <b><label class="form-label">Select teacher:</label></b>
                                        <select class="form-select" name="user_id" required>
                                            <?php echo $user_data; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select course:</label></b>
                                        <select class="form-select" name="course_mapping_id" required>
                                            <?php echo $course_mapping_data; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select section:</label></b>
                                        <select class="form-select" name="section_id" required>
                                            <?php echo $section_data; ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="updateMappingModal" tabindex="-1" aria-labelledby="updateMappingModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateMappingModalLabel">Update Teacher Course Mapping Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="post">
                                <input id="editId" type="hidden">
                                <div class="row">
                                    <div class="col">
                                        <b><label class="form-label">Select teacher:</label></b>
                                        <select class="form-select" id="editUserId" required>
                                            <?php echo $user_data; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select course:</label></b>
                                        <select class="form-select" id="editCourseMappingId" required>
                                            <?php echo $course_mapping_data; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select section:</label></b>
                                        <select class="form-select" id="editSectionId" required>
                                            <?php echo $section_data; ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../js/update_teacher_course_mapping.js"></script>
</body>

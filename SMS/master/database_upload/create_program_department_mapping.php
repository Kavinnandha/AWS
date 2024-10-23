<?php include '../dependancies.php'; 
include '../session.php'; ?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
	<div class="container">
		<div class="text-center">
		<h3>Programme/Degree Department Mapping</h3>
		</div>
                <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Programme/Degree Name</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Action</th>
                      </tr>
                </thead>
                <tbody>
                    <?php include '../../php/get_program_department_mapping_details.php'; echo $program_department_mapping_data;?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#teacherFormModal">Insert</button>
            </div>
        <div class="modal fade" id="teacherFormModal" tabindex="-1" aria-labelledby="teacherFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherFormModalLabel">Insert Degree Department Mapping Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../../php/database_upload/upload_program_department_mapping.php">
                                <div class="row">
                                <div class="col">
                                <label class="form-label">select Programme/degree:</label>
                                <select class="form-select" name="programme_id" required>
                                <?php echo $programme; ?>
                                </select>
                                </div>
                                <div class="col">
                                <label class="form-label">select Department:</label>
                                <select class="form-select" name="department_id" required>
                                <?php echo $department; ?>
                                </select>
                                </div>
                                </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end col">
                                <button class="btn btn-success mt-3" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

          </div>

<div class="modal fade" id="updateMappingModal" tabindex="-1" aria-labelledby="updateMappingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateMappingModalLabel">Insert Degree Department Mapping Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post">
                                <div class="row">
                                <div class="col">
                                <input type="hidden" id="editId">
                                <label class="form-label">select Programme/degree:</label>
                                <select class="form-select" id="editProgrammeId" required>
                                <?php echo $programme; ?>
                                </select>
                                </div>
                                <div class="col">
                                <label class="form-label">select Department:</label>
                                <select class="form-select" id="editDepartmentId" required>
                                <?php echo $department; ?>
                                </select>
                                </div>
                                </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end col">
                                <button class="btn btn-success mt-3" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script src="../js/update_program_department_mapping.js"></script>
</body>



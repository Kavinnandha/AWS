<?php include '../dependancies.php'; 
include '../session.php'; ?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>HOD Mapping</h3>
            </div>
            
            <table class="table table-striped table-hover mt-5">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
			<?php include '../../php/get_hod_details.php'; echo $user_table; ?>
                </tbody>
            </table>

         
            <div class="d-flex justify-content-end mt-4">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#hodFormModal">Insert</button>
            </div>
        <div class="modal fade" id="hodFormModal" tabindex="-1" aria-labelledby="hodFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hodFormModalLabel">HOD Mapping Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../../php/database_upload/upload_hod_mapping.php">
                                
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label"><b>Select Name :</b></label>
					<select class="form-select" name="user_id" required>
					<?php echo $users; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label"><b>Select Department:</b></label>
					<select class="form-select" name="department_id" required>
					<?php echo $department; ?>
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
                        <h5 class="modal-title" id="updateMappingModalLabel">Update HOD Information</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post">
                                <input type="hidden" id="editId">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label"><b>Name:</b></label>
					<select class="form-select" id="userId" required>
					<?php echo $users; ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label"><b>Department:</b></label>
					<select class="form-select" id="departmentId" required>
					<?php echo $department; ?>
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
<script src="../js/update_hod.js"></script>
</body>

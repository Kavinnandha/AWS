<?php include '../dependancies.php'; 
include '../sidebar.php'; 
include '../session.php'; ?>
<body id="body-pd">

    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>Department details</h3>
            </div> 
            <table class="table table-hover mt-5" id="editable-table">
                <thead>
                    <tr>
                        <th scope="col">Department ID</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Action</th>
                    </tr

               </thead>
                <tbody>
                    <?php include '../../php/get_department_details.php'; echo $department_data;?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#departmentFormModal">Insert</button>
            </div>
            <div class="modal fade" id="departmentFormModal" tabindex="-1" aria-labelledby="departmentFormModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="departmentFormModalLabel">Insert Department Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="../../php/database_upload/upload_department_data.php">
                                <div class="row mb-3">
                                    <div class="col">
                                        <b><label class="form-label">Enter department ID:</label></b>
                                        <input placeholder="Department ID" class="form-control" name="department_id" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter department Name: </label></b>
                                        <input placeholder="Department Name" class="form-control" name="department_name" required />
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="updateDepartmentModal" tabindex="-1" aria-labelledby="updateDepartmentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateDepartmentModalLabel">Update Department Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <b><label class="form-label">Department ID: </label></b>
                                        <input class="form-control" name="department_id" id="editId" readonly>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter department Name: </label></b>
                                        <input placeholder="Department Name" class="form-control" name="department_name" id="editName" required />
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<script src="../js/update_department.js"></script>
</body>


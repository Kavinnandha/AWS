<?php include '../dependancies.php'; 
include '../session.php'; ?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="text-center">
            <h3>Academic Year Details</h3>
        <div>
        <div class="container mt-5">
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Academic Year</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include '../../php/get_academic_year_details.php'; echo $academic_year_data;?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#yearFormModal">Insert</button>
	        </div>
        <div class="modal fade" id="yearFormModal" tabindex="-1" aria-labelledby="yearFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="yearFormModalLabel">Insert Academic Year Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../../php/database_upload/upload_academic_year.php">
                            <div class="row mb-3">
                            <div class="container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Academic Year</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="yearEntries">
                                    <tr>
                                        <td><input type="text" name="years[0][academic_year]" class="form-control" placeholder="Enter Academic Year :" required></td>
                                        <td>
                                            <select name="years[0][type]" class="form-select" required>
                                                <option value="" selected>Select Type</option>
                                                <option value="ODD">Odd</option>
                                                <option value="EVEN">Even</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="years[0][status]" class="form-select" required>
                                                <option value="" selected>Select Status</option>
                                                <option value="ACTIVE">Active</option>
                                                <option value="INACTIVE">Inactive</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-success me-md-2" type="button" id="addEntry">Add Entry</button>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

        <script src="../js/update_academic_year.js"></script>
    </div>
   <div class="modal fade" id="updateYearModal" tabindex="-1" aria-labelledby="updateYearModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateYearModalLabel">Update Department Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row mb-3">
				                <div class="col">
                                    <input class="form-control" type="hidden" id="editId">
                                    <b><label class="form-label">Academic Year: </label></b>
                                                        <input placeholder="Academic Year" class="form-control" id="editName" required />
                                    <b><label class="form-label">Select Type: </label></b>
                                                         <select class="form-select" id="editType" required>
                                                                <option value="" selected>Select Type</option>
                                                                <option value="ODD">Odd</option>
                                                                <option value="EVEN">Even</option>
                                                            </select>
                                    <b><label class="form-label">Select Type: </label></b>
                                                            <select class="form-select" id="editStatus" required>
                                                                <option value="" selected>Select Status</option>
                                                                <option value="ACTIVE">Active</option>
                                                                <option value="INACTIVE">Inactive</option>
                                                            </select>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</body>


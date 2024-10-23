<?php include '../dependancies.php'; 
include '../session.php';
include '../sidebar.php'; ?>

<body id="body-pd">
    <div class="height-100 bg-light">
        <div class="text-center">
            <h3>Batch Details</h3>
        </div>
        <div class="container mt-5">
            <form action="../../php/database_upload/upload_batch_details.php" method="POST">
            <button type="submit" name="update" value="update" class="btn btn-success mb-4">Increment Current Semester</button>
            </form>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Batch</th>
                        <th scope="col">Current Semester</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include '../../php/get_batch_details.php'; echo $batch_data;?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#batchFormModal">Insert</button>
	        </div>
        <div class="modal fade" id="batchFormModal" tabindex="-1" aria-labelledby="batchFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center">
                    <div class="modal-header">
                        <h5 class="modal-title" id="batchFormModalLabel">Insert Batch Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                        <form method="post" action="../../php/database_upload/upload_batch_details.php">
                            <div class="row mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Current Semester</th>
                                    </tr>
                                </thead>
                                <tbody id="batchEntries">
                                    <tr>
                                        <td><input type="text" name="batch[0][batch_name]" class="form-control" placeholder="Enter Batch :" required></td>
                                        <td><input type="text" name="batch[0][current_semester]" class="form-control" placeholder="Enter Current Semester :" required></td>
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
         

        <script src="../js/update_batch.js"></script>
    </div>
   <div class="modal fade" id="updateBatchModal" tabindex="-1" aria-labelledby="updateBatchModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateBatchModalLabel">Update Department Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="hidden" name="batch_id" id="editId">
                                        <b><label class="form-label">Batch name: </label></b>
                                        <input placeholder="Batch Name" class="form-control" id="editName" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Current Semester: </label></b>
                                        <input placeholder="Current Semester" class="form-control" id="editSemester" required />
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</body>

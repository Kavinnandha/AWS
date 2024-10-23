<?php include '../dependancies.php';
include '../session.php';
include '../sidebar.php'; ?>
<body id="body-pd">
    <div class="height-100 bg-light">
    <div class="container">
        <div class="text-center">
            <h3>Programme details</h3>
        </div>
        <table class="table table-striped mt-5">
            <thead>
                <tr>
                    <th scope="col">Programme Name</th>
                    <th scope="col">Duration</th>
            <th scope="col">No of Semester</th>
            <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php include '../../php/get_programme.php'; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#degreeFormModal">Insert</button>
        </div>
    </div>
                
    <div class="modal fade" id="degreeFormModal" tabindex="-1" aria-labelledby="degreeFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content justify-content-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="degreeFormModalLabel">Insert Degree Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../../php/database_upload/upload_degree_details.php" id="degreeForm">
                        <div class="container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Programme Name</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">No of Semesters</th>
                                    </tr>
                                </thead>
                                <tbody id="degreeEntries">
                                    <tr>
                                        <td><input type="text" name="degree[1][programme_name]" class="form-control" placeholder="Enter Programme Name" required></td>
                                        <td><input type="text" name="degree[0][duration]" class="form-control" placeholder="Enter Duration" required></td>
                                        <td><input type="number" name="degree[0][no_of_semester]" class="form-control" placeholder="Enter Number of Semesters" required></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-success me-md-2" type="button" id="addEntry">Add Entry</button>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </div> 
                    </form>
                </div> 
            </div> 
        </div> 
    </div> 

            <div class="modal fade" id="updateDegreeModal" tabindex="-1" aria-labelledby="updateDegreeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateDepartmentModalLabel">Update Programme  Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input class="form-control" name="programme_id" id="editId" type="hidden">
                                        <b><label class="form-label">Enter Programme Name: </label></b>
                                        <input placeholder="Programme Name" class="form-control" name="programme_name" id="editName" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter Duration: </label></b>
                                        <input placeholder="Duration" class="form-control" name="duration" id="editDuration" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter No of semesters: </label></b>
                                        <input placeholder="no. of Semester" class="form-control" name="semester" id="editSemester" required />
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<script src="../js/update_degree.js"></script>
</div>
</body>

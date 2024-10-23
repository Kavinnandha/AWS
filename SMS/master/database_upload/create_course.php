<?php include '../dependancies.php'; 
include '../session.php'?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>Course details</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    Upload CSV for bulk upload
                </div>
                <div class="card-body">
                    <form action="php/upload_course_data.php" method="post" enctype="multipart/form-data">
                
                        <label for="file">Choose a CSV file:</label>
                        <input type="file" name="file" id="file" accept=".csv" required>
                        <input type="submit" class="btn btn-success" value="Upload">
                    </form>
                </div>
            </div>

            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Course ID</th>
                        <th scope="col">Course Name</th>
                        <th scope="col">Course Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include '../../php/get_course_details.php'; echo $course_data;?>
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#teacherFormModal">Insert</button>
	    </div>
        <div class="modal fade" id="teacherFormModal" tabindex="-1" aria-labelledby="teacherFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherFormModalLabel">Insert Course Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../../php/database_upload/upload_course_details.php">
                            <div class="row mb-3">
                            <div class="container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Course ID</th>
                                        <th scope="col">Course Name</th>
                                        <th scope="col">Type ID</th>
                                    </tr>
                                </thead>
                                <tbody id="courseEntries">
                                    <tr>
                                        <td><input type="text" name="courses[0][course_id]" class="form-control" placeholder="Enter Course ID :" required></td>
                                        <td><input type="text" name="courses[0][name]" class="form-control" placeholder="Enter Course Name :" required></td>
					                    <td>
						                    <select name="courses[0][type_id]" class="form-select" aria-label="Select Type ID" required>
									<?php echo $course_type; ?>
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
    </div>       
    <template id="courseTypeOptions">
    <?php echo $course_type; ?>
    </template>

             <div class="modal fade" id="updateCourseModal" tabindex="-1" aria-labelledby="updateCourseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateCourseModalLabel">Update Course Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <b><label class="form-label">Course ID : </label></b>
                                        <input class="form-control" name="course_id" id="editId" readonly>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter Course Name: </label></b>
                                        <input placeholder="Course Name" class="form-control" name="course_name" id="editName" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select Course Type: </label></b>
                                        <select class="form-select" name="course_type" id="editType">
                                            <?php echo $course_type; ?>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                   
        <script src="../js/update_course.js"></script>
</body>


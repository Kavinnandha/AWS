<?php include '../../php/search_students_details.php'; 
include '../dependancies.php'; 
include '../sidebar.php'; 
?>
<body id="body-pd">
    <div class="height-100 bg-light">
        <div class="text-center">
            <h3>Student Information</h3>
        </div>
	<div class="container">
	    <div class="card">
            <div class="card-header">Info</div>
            <div class="card-body">
            <p class="card-text">Select the department,batch and section below and choose csv file for upload.</p>
	    <p>For bulk upload, please follow the format mentioned below(name of the first columns in excel should exactly match): </p>
        <p><b>register_no,name,DOB(dd-mm-yyyy),gender(M for male and F for female),boarding_status(H for Hosteller, D for Dayscholar),email</b></p>
        <p>The default password for a student is siet@2024. </p>
          </div>
        </div>
            <div class="card mt-3">
                <div class="card-header">
                    Upload CSV for bulk upload
                </div>
                <div class="card-body">
                    <form action="../../php/database_upload/upload_student_data.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
			    <div class="col-md-3">
				<?php echo $bulk_department; ?>
			    </div>
			    <div class="col-md-3">
				<?php echo $bulk_batch; ?>
			    </div>
			    <div class="col-3">
				<?php echo $bulk_section; ?>
			    </div>
		    </div>


                        <label for="file">Choose a CSV file:</label>
                        <input type="file" name="file" id="file" accept=".csv" required>
                        <input type="submit" class="btn btn-success" value="Upload">
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="student-data">
                    <thead>
                        <tr>
                            <th scope="col">Reg No</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Email ID</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Boarding Status</th>
                            <th scope="col">Department</th>
                            <th scope="col">Section</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Programme</th>  
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $data;?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#studentFormModal">Insert</button>
            </div>
        </div>

        <div class="modal fade" id="studentFormModal" tabindex="-1" aria-labelledby="studentFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentFormModalLabel">Insert Student Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../../php/database_upload/upload_student_data.php">
                            <div class="row mb-3">
                                <div class="col">
                                    <?php

                                        echo $departmentModal;
                                    ?>
                                </div>
                                <div class="col">
                                    <?php
 
                                        echo $batchModal;
                                    ?>
                                </div>
                                <div class="col">
                                    <?php

                                        echo $sectionModal;
                                    ?>
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Register No</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">D.O.B</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Boarding Status</th>
                                    </tr>
                                </thead>
                                <tbody id="studentEntries">
                                    <tr>
                                        <td><input type="text" name="students[0][name]" class="form-control" placeholder="Enter Student Name :" required></td>
                                        <td><input type="text" name="students[0][register_no]" class="form-control" placeholder="Enter Register No :" required></td>
                                        <td><input type="text" name="students[0][email]" class="form-control" placeholder="Enter Email ID:" required></td>
                                        <td><input type="date" name="students[0][DOB]" class="form-control" required></td>
                                        <td>
                                            <select name="students[0][gender]" class="form-select" required>
                                                <option value="" selected>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="students[0][boarding_status]" class="form-select" required>
                                                <option value="" selected>Boarding Status</option>
                                                <option value="D">Dayscholar</option>
                                                <option value="H">Hosteller</option>
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
     <div class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStudentModalLabel">Insert Student Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post">
                            <div class="row mb-3">
                                    <label>Register no: </label>
                                    <input id="editId" name="register_no" class="form-control" readonly>
                                    <label>Name: </label>
                                    <input id="editName" class="form-control">
                                    <label>Email: </label>
                                    <input id="editEmail" class="form-control">
                                    <label>Date of Birth: </label>
                                        <input type="date" class="form-control" id="editDate">
                                    <label>Gender: </label>
                                    <select id="editGender" class="form-select">
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <label>Boarding status</label>
                                    <select id="editBoardingStatus" class="form-select">
                                            <option value="H">Hosteller</option>
                                            <option value="D">DayScholar</option>
                                    </select>
                                    <label>Select department:</label>
                                    <?php
                                            echo $department;
                                    ?>
                                    <label>Select batch: </label>
                                    <?php
                                            echo $batch;
                                    ?>
                                    <label>Select section: </label>
                                    <?php

                                        echo $section;
                                    ?>
                                </div>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </form>
                            </div>
        <script src="../js/update_student.js"> </script>
    </div>
</body>

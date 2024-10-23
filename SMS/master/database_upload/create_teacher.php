<?php include '../dependancies.php'; 
include '../session.php'; 

?>

<body id="body-pd">
    <?php include '../sidebar.php'; ?>
    <div class="height-100 bg-light">
        <div class="container">
            <div class="text-center">
                <h3>Staff details</h3>
	    </div>
	<div class="card">
	    <div class="card-header">Info</div>
	    <div class="card-body">
	    <p class="card-text">The default password for a newly created used is <b>siet@2024</b></p>
        <p>For bulk upload, please follow the format mentioned below: </p>
        <b><p>name,email_id,gender,designation</p></b>
	  </div>
	</div>
            <div class="card mt-5 mb-5">
                <div class="card-header">
                    Upload CSV for bulk upload
                </div>
                <div class="card-body">
		    <form action="../../php/database_upload/upload_teacher_data.php" method="post" enctype="multipart/form-data">
			<div class="row mt-3">
				<div class="col-5">
					<select name="department" class="form-select" aria-label="select department" required>
						<?php include '../../php/get_teacher_details.php';echo $department; ?>
					</select>
				</div>
				<div class="col-5">
					<select name="role" class="form-select" aria-label="select role" required>
						 <?php echo $role; ?>
					 </select>
				</div>
			</div>
			<div class="mt-3">
                        	<label for="file">Choose a CSV file:</label>
                        	<input type="file" name="file" id="file" accept=".csv" required>
                        	<input type="submit" name="submit" class="btn btn-success" value="Upload">
			</div>
                    </form>
                </div>
            </div>
            <table class="table table-striped" id="teacher-data">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email ID</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $teacher_data;?>
                </tbody>
            </table>
            <template id="departmentOptions">
    <?php echo $department; ?>
</template>

<template id="roleOptions">
    <?php echo $role; ?>
</template>
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#teacherFormModal">Insert</button>
        </div>

        <div class="modal fade" id="teacherFormModal" tabindex="-1" aria-labelledby="teacherFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content justify-content-center">
                    <div class="modal-header">
                        <h5 class="modal-title" id="teacherFormModalLabel">Insert Teacher Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="../../php/database_upload/upload_teacher_data.php">
                            <div class="row mb-3">
                            <div class="container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email ID</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Role</th>
                                    </tr>
                                </thead>
                                <tbody id="teacherEntries">
                                    <tr>
                                        <td><input type="text" name="teachers[0][name]" class="form-control" placeholder="Enter Teacher Name :" required></td>
                                        <td><input type="email" name="teachers[0][email_id]" class="form-control" placeholder="Enter Email ID :" required></td>
					                <td>
						                <select name="teachers[0][department]" class="form-select" aria-label="select department" required>
						                    <?php echo $department; ?>
						                </select>
					                </td>
                                        <td>
                                            <select name="teachers[0][gender]" class="form-select" required>
                                                <option value="" selected>Gender</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="teachers[0][designation]" class="form-control" placeholder="Enter Designation :" required></td>
                                        <td>
						                    <select name="teachers[0][role]" class="form-select" aria-label="select role" required>
						                        <?php echo $role; ?>
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


            <div class="modal fade" id="updateTeacherModal" tabindex="-1" aria-labelledby="updateTeacherModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content justify-content-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateTeacherModalLabel">Update Staff Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input class="form-control" name="user_id" id="editId" type="hidden">
                                        <b><label class="form-label">Enter Staff Name: </label></b>
                                                            <input placeholder="Name" class="form-control" name="staff_name" id="editName" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter Email ID: </label></b>
                                                            <input placeholder="Email" class="form-control" name="staff_email" id="editEmail" type="mail" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select Department</label></b>
                                                            <select name="department_id" class="form-select" id="editDepartment" required>
                                                            <?php echo $department; ?> 
                                                            </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <b><label class="form-label">Select Gender</label></b>
                                                    <select name="gender" class="form-select" id="editGender" required>
                                                        <option value="" selected>Gender</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>
                                                    </select>
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Enter Designation</label></b>
                                                    <input placeholder="Designation" class="form-control" name="designation" id="editDesignation" required />
                                    </div>
                                    <div class="col">
                                        <b><label class="form-label">Select Role</label></b>
                                                    <select id="editRole" class="form-select" aria-label="select role" required>
                                                        <?php echo $role; ?>
                                                    </select>

                                    </div>
                                </div>
                                <button class="btn btn-success mt-3" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <script src="../js/update_teacher.js"></script>
</body>


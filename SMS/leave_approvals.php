<?php
include 'master/dependancies.php';
include 'master/sidebar.php';
include 'php/leave_approval_details.php';
?>

<body id="body-pd">

    <div class="container">
        <h2 class="text-center">Manage Leave Requests</h2>
        <?php if (in_array($_SESSION['role_id'], [1, 2, 3, 4])): ?>
            <h3>Faculty Requests</h3>
            <?php 
                if ($_SESSION['role_id'] == '1') {
                    echo $faculty_leave_data; 
                }
                else if ($_SESSION['role_id'] == '2') {
                    echo $faculty_leave_data_principal;
                }
            ?>
        <?php endif; ?>
    </div>

    <div class="container mt-5">
        <h3>Student Requests</h3>
        <?php
        if ($_SESSION['role_id'] == '6') {
            echo $advisor_leave_data;
        }
        if ($_SESSION['role_id'] == '1') {
            echo $hod_leave_data;
        }
        if ($_SESSION['role_id'] == '2') {
            echo $student_leave_data_principal;
        }
        ?>

    </div>
<?php if($_SESSION['role_id'] == '1'): ?>
	<div class="container mt-5">
		<h3>History</h3>
		<table id="history" class="table table-striped">
			<thead>
				<tr>
					<th>Name-Register No</th>
					<th>Request For</th>
					<th>No of Days</th>
					<th>From</th>
					<th>To</th>
					<th>Reason</th>
					<th>Remark</th>
					<th>Status</th>
				</tr>
			</thead>		
			<tbody>
                <?php echo $student_leave_history; ?>
                <?php echo $staff_leave_history; ?>
			</tbody>
		</table>	
    </div>
    <script>new DataTable('#history');</script>
<?php endif; ?>
</body>

<?php include 'master/dependancies.php';
include 'master/sidebar.php';
?>
<body id="body-pd">
<table class="table table-bordered table-striped">
    <div class="container">
        <div class="text-center">
            <h2>Attendance Report</h2>
        </div>
    <?php if(in_array($role,[1,2,3,4,5,6])): ?>
    <h3>Class Report</h3>
    <form method="POST" action="php/generate_report.php">
    <div class="row">

        <?php
                include 'php/get_report_details.php';
                if($role == 6): ?>
                    <h5><?php echo $advisor_class_details;?></h5>

    <?php echo $advisor_value; ?>
    <label class="form-label">Academic Year: </label>
        <?php
                echo $academic_year;
        ?>
    <div class="col-md-6">
	<label class="form-label">From:</label>
	<input type="date" name="date-from" class="form-control" required>
	</div>
	 <div class="col-md-6">
        <label class="form-label">To:</label>
    <input type="date" name="date-to" class="form-control" required>
	</div>
        <div>

<?php else: ?>
        <div class="col-md-3">
            
            <?php 
            if($role != 1){
            echo $department;
            }else{
            echo $hod_department;
}
 ?>
        </div>
        <div class="col-md-3">
        <?php
                echo $batch;
        ?>
	</div>
	<div class="col-md-3">
        <?php
                echo $academic_year;
        ?>
	</div>
        <div class="col-md-3">
                <select name="section" class="form-select" aria-label="default select example" required>
                <option selected value="">Section</option>
                <option value="1">A</option>
		<option value="2">B</option>
		<option value="3">C</option>
		<option value="4">D</option>
                </select>
        </div>
</div>
        <div class="row g-5">
	<div class="col-md-6">
	<label class="form-label">From:</label>
	<input type="date" name="date-from" class="form-control" required>
	</div>
	 <div class="col-md-6">
        <label class="form-label">To:</label>
    <input type="date" name="date-to" class="form-control" required>
    <?php endif; ?>
	</div>
        <div class='mt-5'>
                <button type="submit" class="btn btn-success" name="class_report" value="class_report">Get Class Report</button>
        </div>
<?php endif; ?>
    </form>

    <?php if (in_array($role,[0,1,6])): ?>
    <div class="container">
    <h3>Subject Report </h3>
    <form method="POST" action="php/generate_report.php">
    <div class="row">
        <div class="col">
        <label class="form-label">Academic Year: </label>
        <?php
                include 'php/get_report_details.php';
                echo $academic_year;
        ?>

        <label class="form-label">Subject: </label>
        <?php echo $main_dropdown; ?>
    </div>
    <div class="row">
	<div class="col-md-6">
	<label class="form-label">From:</label>
	<input type="date" name="date-from" class="form-control" required>
	</div>
	 <div class="col-md-6">
        <label class="form-label">To:</label>
	<input type="date" name="date-to" class="form-control mb-5" required>
    </div>
        <div>
         <button type="submit" class="btn btn-success" name="subject_report" value="subject_report">Get Subject Report</button>
        </div>
    </div>
    </form>
</div>
<?php endif; ?>
</body>

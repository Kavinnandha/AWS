<?php include 'master/dependancies.php';
include 'master/sidebar.php';
?>
<body id="body-pd">
<table class="table table-bordered table-striped">
    <div class="container">
        <div class="text-center">
            <h3>Attendance Report</h3>
        </div>
    <form method="POST" action="php/generate_report.php">
    <div class="row">
        <div class="col-md-3">
        <?php
                include 'php/get_report_details.php';
                echo $department;
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
	</div>
        <div>
                <button type="submit" class="btn btn-success" value="submit">Submit</button>
        </div>
 	
    </form>
    <div>

    </div>
</body>

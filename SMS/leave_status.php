<?php 
include 'master/dependancies.php';
include 'master/sidebar.php';
include 'master/config.php';
include 'php/staff_leave_details.php';

?>
<body>
    <div class="container">
        <div class="text-center"><h3>Leave Status</h3></div>
        <div class="mt-3 table-responsive">
	   <label><h4>Status of current leave / OD request : </h4></label>
	   <table class="table table-striped" id="current-leave" >
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>No of Days</th>
                    <th>Type of leave</th>
                    <th>Reason</th>
                    <th>Remark</th>
                    <th>Out time</th>
                    <th>In time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php echo $current_leave_data; ?>
            </tbody>
            </table>

        </div>
        <div class="mt-3 table-responsive">
            <label><h4>History:</h4></label>
            <table id="history" class="table table-striped">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>No of Days</th>
                    <th>Type of leave</th>
                    <th>Reason</th>
                    <th>Remark</th>
                    <th>Out time</th>
                    <th>In time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php echo $leave_data; ?>
            </tbody>
            </table>
        </div>
    </div>
    <script>new DataTable('#history');new DataTable('#current-leave');</script>
</body>

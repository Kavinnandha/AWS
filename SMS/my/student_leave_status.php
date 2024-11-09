<?php include '../master/config.php';
include 'leave_history.php';
?>
<head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js" rel="stylesheet"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.js" rel="stylesheet"></script>


</head>
<body>
    <div class="container">
        <div class="text-center"><h3>Leave Status</h3></div>
        <div class="mt-3 table-responsive">
	    <label><h4>Status of current leave / OD request : </h4></label>
	    <table class="table table-striped" id="applied">
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
    <script>new DataTable('#history');new DataTable('#applied');</script>
</body>

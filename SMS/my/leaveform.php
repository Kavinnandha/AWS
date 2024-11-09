<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave/On-Duty Request Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/leaveform.css">
</head>
<?php include '../php/leave_request_details.php';
?>
<body id="body-pd">

    <div class="container mt-5">
        <h2 class="text-center">Leave/OD Request Form</h2>

        <form action="../php/leave_request_details.php" method="post">
            <div class="container">
                <div class="row mt-5">
                    <div class="col">
                        <div class="input-group grp21">
                            <span class="input-group-text" id="basic-addon1">From</span>
                            <input type="date" class="form-control" id="startDate" name="start_date" min="<?php echo date('Y-m-d');?>" required onchange="calculateDays()">
                        </div>
                    </div>

                    <div class="col">
                        <div class="input-group grp21">
                            <span class="input-group-text" id="basic-addon1">To</span>
                            <input type="date" class="form-control" id="endDate" name="end_date" required onchange="calculateDays()">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group grp11">
                            <span class="input-group-text" id="basic-addon1">No of Days</span>
                            <input type="text" class="form-control" id="noOfDays" name="no_of_days" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <div class="input-group grp21">
                            <span class="input-group-text" id="basic-addon1">Out time</span>
                            <input type="time" class="form-control para" name="out_time" placeholder="TO" required >
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group grp11">
                            <span class="input-group-text" id="basic-addon1">In time</span>
                            <input type="time" class="form-control para in" name="in_time" placeholder="IN" required >
                        </div>
                    </div>
                    <div class="col">
                        <select class="form-select" id="leaveType" name="type_id" aria-label="Type of leave" required>
			    <option value="" disabled selected>Select Type</option>
			    <?php echo $leave_type ?>
                        </select>
                    </div>
                </div>

                <div class="mt-5">
                    <label for="leaveReason" class="form-label">Reason for Leave</label>
                    <textarea class="form-control" id="leaveReason" name="reason" rows="3" required></textarea>
                </div>
	</div>
                <button type="submit" class="btn btn-success mt-5">Submit Request</button>
        </form>
    </div>

    <script>
        function calculateDays() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const diffTime = end - start;
                const diffDays = diffTime / (1000 * 60 * 60 * 24) + 1;
                document.getElementById('noOfDays').value = diffDays;
            }
        }
        $(document).on("change","#startDate",function(){
            var date = $(this).val();
            $('#endDate').attr('min',date);
        });
    
    </script>

</body>

</html>

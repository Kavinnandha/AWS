<?php include 'attendance_report.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/Attendance.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5><strong>From:</strong> <?php echo $start_date ?> </h5>
            </div>
            <div class="col-md-4">
                <h5><strong>TO:</strong> <?php echo date("d-m-Y") ?> </h5>
            </div>
            <div class="col-md-4">
                <h5><strong>Total Attendance Percentage:</strong> <?php echo $attendance_percentage ?></h5>
            </div>
        </div>
        <div class="attendtable table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                      <th scope="col">Subject Code</th>
                      <th scope="col">Subjects</th>
                      <th scope="col">Total No Periods</th>
                      <th scope="col">Total No Of Periods Attended</th>
                      <th scope="col">Attendance percentage per period</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $data_attend; ?>
                  </tbody>
            </table>
        </div>
    </div>
</body>
</html>
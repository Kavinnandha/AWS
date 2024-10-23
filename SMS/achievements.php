<?php 
include 'master/dependancies.php';
include 'master/sidebar.php';
include 'php/achievements_tab.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/Attendance.css">
</head>
<body>
    <div class="container">
        <div class="attendtable table-responsive">
            <h3>Competition</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Register number</th>
                      <th scope="col">Competition name</th>
                      <th scope="col">Position secured</th>
                      <th scope="col">held On</th>
                      <th scope="col">info</th>
                      <th scope="col">view</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $data;?>
                  </tbody>
            </table>
        </div>
        <div class="attendtable table-responsive">
        <h3>Research Papers Published</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Register number</th>
                      <th scope="col">Paper Title</th>
                      <th scope="col">Related field</th>
                      <th scope="col">Info</th>
                      <th scope="col">View</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php echo $data2;?>
                  </tbody>
            </table>
        </div>
        <div class="attendtable table-responsive">
        <h3>Internships completed</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Register number</th>
                      <th scope="col">Company name</th>
                      <th scope="col">Role</th>
                      <th scope="col">Info</th>
                      <th scope="col">View</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php echo $data3;?>
                  </tbody>
            </table>
        </div>
        <div class="attendtable table-responsive">
        <h3>Extra Courses Completed</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Register number</th>
                      <th scope="col">Certification Name</th>
                      <th scope="col">Issued By</th>
                      <th scope="col">Info</th>
                      <th scope="col">View</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php echo $data4;?>
                  </tbody>
            </table>
        </div>
    </div>
</body>
</html>

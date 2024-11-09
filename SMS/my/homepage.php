<?php include '../master/session.php';
include 'retrive_attendance.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/students.css">
    
</head>
<body>
    <div class="container">
        <div class="details">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <form action="/SMS/profile.php" method="get" style="margin: 0;">
    <button class="btn btn-success" type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
</svg>
    View Profile
    </button>
</form>

    
    <form action="../logout.php" method="post" style="margin: 0;">
        <button class="btn btn-light" type="submit">
            <i class="bi bi-box-arrow-right log"></i> 
        </button>
    </form>
    </div>

            <div class="row">
                <div class="col-md-4">
                    <h5><strong>Register Number:</strong><?php echo " $student_register";?></h5>
                </div>
                <div class="col-md-4">
                    <h5><strong>Name:</strong> <?php echo " $student_name";?> </h5>
                </div>
                <div class="col-md-4">
                    <h5><strong>Date of Birth:</strong> <?php echo " $student_dob";?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h5><strong>Semester:</strong><?php echo " $current_sem";?></h5>
                </div>
                <div class="col-md-4">
                    <h5><strong>Batch:</strong><?php echo " $student_batch";?></h5> 
                </div>
                <div class="col-md-4">
                    <h5><strong>Degree and Branch:</strong><?php echo " $student_degree";?></h5>
                </div>
            </div>
        </div>
     
        <div class="na">
            <ul class="nav nav-tabs">
            <li class="nav-item">
                    <a class="nav-link active" href="#content0" data-bs-toggle="tab">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#content1" data-bs-toggle="tab">Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#content2" data-bs-toggle="tab">Internal Marks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#content3" data-bs-toggle="tab">Leaderboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#content4" data-bs-toggle="tab">Leave submission</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-success" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Extra Curricular Achievements
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-success" href="#contenta" data-bs-toggle="tab">Competitions and Hackathons</a></li>
                        <li><a class="dropdown-item text-success" href="#contentb" data-bs-toggle="tab">Extra-courses Done</a></li>
                        <li><a class="dropdown-item text-success" href="#contentc" data-bs-toggle="tab">Research Paper & Publications</a></li>
                        <li><a class="dropdown-item text-success" href="#contentd" data-bs-toggle="tab">Completed Internships</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link pro" href="#content6" data-bs-toggle="tab">Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#content7" data-bs-toggle="tab">Semester Results</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#content8" data-bs-toggle="tab">Leave Status/History</a>
                </li>
            </ul>
        </div>
        
        <div class="tab-content">
        <div id="content0" class="tab-pane active">
                <?php include 'studashboard.php'; ?>
            </div>
            <div id="content1" class="tab-pane fade">
                <?php include 'Attendance.php'; ?>
            </div>
            <div id="content2" class="tab-pane fade">
                <?php include 'internals.php'; ?>
            </div>
            <div id="content3" class="tab-pane fade">
                <?php include 'Leaderboard.php'; ?>
            </div>
            <div id="content4" class="tab-pane fade">
                <?php include 'leaveform.php'; ?>
            </div>
            <div id="content5" class="tab-pane fade">
                <?php include 'main.html';?>
            </div>
            <div id="content6" class="tab-pane fade">
                <?php include 'request.php'; ?>
            </div>
            <div id="content7" class="tab-pane fade">
                <?php include 'semresult.php'; ?>
            </div>
            <div id="content8" class="tab-pane fade">
                <?php include 'student_leave_status.php'; ?>
            </div>
            <div id="contenta" class="tab-pane fade">
                <?php include 'competitions.php'; ?>
            </div>
            <div id="contentb" class="tab-pane fade">
                <?php include 'extra_courses.php'; ?>
            </div>
            <div id="contentc" class="tab-pane fade">
                <?php include 'research_papers.php'; ?>
            </div>
            <div id="contentd" class="tab-pane fade">
                <?php include 'internships.php'; ?>
            </div>
        </div>
    </div>    
</body>
</html>

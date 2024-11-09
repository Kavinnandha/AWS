<?php
include 'master/dependancies.php';
include 'master/sidebar.php';
include 'php/lms_portal_report_details.php';

$department = mysqli_fetch_row(mysqli_query($connection, "SELECT department_id FROM login WHERE user_id = $user_id"))[0];
?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="master/css/lms_portal_report_styles.css">
</head>

<body>
    <div class="container-flex mt-5">
        <div class="position-absolute">
            <a tabindex="0" class="btn btn-outline-info popover-dismiss" role="button" id="infoPopover"
                data-bs-toggle="popover" data-bs-trigger="focus" data-bs-html="true"
                title="LMS Report Info"
                data-bs-content="
<pre>
<?php if (in_array($role, [2, 3, 4, 5])): ?>
<b>Upload Requirements:</b>
- The file should follow this format: Register Number, course1, course2, course3, ...
- Once uploaded, course names in the file will be checked against the database.
- If a course name is missing, it will be automatically added to the database.

<b>Course Management:</b>
- View, edit, or remove existing courses through the course management interface.
- Add new courses manually using the Add Course button within the Courses modal.
<?php endif; ?>

<b>Data Filtering:</b>
- Course Completion Section: Displays the total number of students who have started the courses.
- Overall Performance: Provides scores for each course and each student. 
- Performance Difference: Provides a comparison of scores from previous days.

<b>Custom View Settings:</b>
- Use the Custom Visibility button in Overall Performance section to display only selected columns.
- Horizontal scrolling can be achieved by holding the Shift key and using the mouse wheel.

(<b>Note:</b> 
- Selecting 'All Batches' does not apply in the Course Completion section.
- Rank and Total Score are also considered as courses.)
</pre>">
                Info
            </a>

        </div>

        <h1 class="text-center">LMS Report</h1>

        <?php
        if (isset($_GET['message'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($_GET['message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            echo "<script>
            if (window.history.replaceState) {
                const url = new URL(window.location.href);
                url.searchParams.delete('message');
                window.history.replaceState(null, '', url);
            }
          </script>";
        }

        // Display session messages if available
        if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
            foreach ($_SESSION['messages'] as $message) {
                echo htmlspecialchars($message) . '<br>';
            }
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';

            unset($_SESSION['messages']);
        }
        ?>

        <?php if (in_array($role, [2, 3, 4, 5])): ?>
            <div class="container">
                <div class="row pb-2">
                    <form action="/SMS/php/lms_portal_report_parse.php" method="post" enctype="multipart/form-data">
                        <div class="row align-items-end">
                            <!-- File Upload Field -->
                            <div class="col">
                                <div class="form-group">
                                    <label for="file" class="form-label fw-medium mb-1">Select XLSX File</label>
                                    <input type="file" class="form-control" name="file" id="file" accept=".xlsx" required />
                                </div>
                            </div>

                            <!-- Date Field -->
                            <div class="col">
                                <div class="form-group">
                                    <label for="date" class="form-label fw-medium mb-1">Select Date</label>
                                    <input type="date" class="form-control" name="date" id="date" value="<?php echo $selected_date; ?>" required />
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-auto d-flex gap-3">
                                <button type="submit" class="btn btn-success px-4 mt-2">Upload</button>
                                <button type="button" class="btn btn-secondary px-4 mt-2" data-bs-toggle="modal" data-bs-target="#courseModal" name="fileUpload">Courses</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row py-2">
                    <form action="/SMS/php/lms_portal_report_details.php" method="post" enctype="multipart/form-data">
                        <div class="row align-items-end">
                            <!-- Start Date Field -->
                            <div class="col">
                                <div class="form-group">
                                    <label for="startDate" class="form-label fw-medium mb-1">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                                </div>
                            </div>

                            <!-- End Date Field -->
                            <div class="col">
                                <div class="form-group">
                                    <label for="endDate" class="form-label fw-medium mb-1">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                                </div>
                            </div>

                            <!-- Truncate Button -->
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger px-4 mt-2" name="truncateData">Delete Data in Database</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Modal for displaying courses -->
            <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn btn-success d-flex align-items-center justify-content-center text-nowrap"
                                id="addCourseBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#addCourseFormModal">
                                <i class="fi fi-rr-book-plus"></i> &nbsp;&nbsp;Add Course
                            </button>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <table class="table table-striped" id="coursesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">Course ID</th>
                                        <th style="width: 600px;">Course Name</th>
                                        <th style="width: 130px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="courseList">
                                    <!-- Course rows will be populated here -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Course Form Modal -->
            <div class="modal fade" id="addCourseFormModal" tabindex="-1" aria-labelledby="addCourseFormModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCourseFormModalLabel">Create New Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addCourseForm">
                                <label for="courseName" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="courseName" required>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="closeCourseFormBtn">Close</button>
                            <button type="button" class="btn btn-success" id="submitCourseBtn">Add Course</button>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

        <!-- Common Filter Form -->
        <?php if (!in_array($role, [0, 6, 7])): ?>
            <div class="container-fluid mb-3 py-2">
                <form method="POST" action="" id="filterForm" class="row gy-3 align-items-center">
                    <input type="hidden" name="tab" value="common">

                    <!-- Batch Filter -->
                    <div class="col-12 col-md-auto">
                        <label for="batchFilter" class="form-label me-2">Batch:</label>
                        <select id="batchFilter" name="batch" class="form-select">
                            <option value="NULL">ALL Batch</option>
                            <?php echo $batch_data; ?>
                        </select>
                    </div>

                    <!-- Department Filter (Conditional) -->
                    <?php if (in_array($role, [2, 3, 4, 5])): ?>
                        <div class="col-12 col-md-auto">
                            <label for="departmentFilter" class="form-label me-2">Department:</label>
                            <select id="departmentFilter" name="department" class="form-select">
                                <option value="NULL">All Departments</option>
                                <?php echo $department_data; ?>
                            </select>
                        </div>
                    <?php elseif (in_array($role, [1, 8])): ?>
                        <input type="hidden" name="department" value="<?php echo $department; ?>">
                    <?php endif; ?>

                    <!-- Date Filter -->
                    <div class="col-12 col-md-auto ms-md-auto">
                        <label for="dateFilter" class="form-label me-2">Select Date:</label>
                        <input type="date" id="dateFilter" name="date" class="form-control" value="<?php echo $selected_date; ?>">
                    </div>
                </form>
            </div>

        <?php endif; ?>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs justify-content-center mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="course-tab" data-bs-toggle="tab" data-bs-target="#course" type="button" role="tab" aria-controls="course" aria-selected="true">Course Completion</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="performance-tab" data-bs-toggle="tab" data-bs-target="#performance" type="button" role="tab" aria-controls="performance" aria-selected="false">Overall Performance</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="difference-tab" data-bs-toggle="tab" data-bs-target="#difference" type="button" role="tab" aria-controls="difference" aria-selected="false">Performance Difference</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="radar-tab" data-bs-toggle="tab" data-bs-target="#studentRadar" type="button" role="tab" aria-controls="radar" aria-selected="false">Student Radar Chart</button>
            </li>
        </ul>

        <!-- Download and Filter Row -->
        <div class="d-flex mb-3" id="downloadRow">
            <div id="excelPdfDownload">
                <button class="download-button" id="excelDownload" onclick="handleDownload(this, 'excel')">
                    <i class="fas fa-download icon-download"></i>
                    <span>Download as Excel</span>
                    <i class="fas fa-spinner fa-spin icon-spinner" style="display: none;"></i>
                </button>
                <button class="download-button" id="pdfDownload" onclick="handleDownload(this, 'pdf')">
                    <i class="fas fa-download icon-download"></i>
                    <span>Download as PDF</span>
                    <i class="fas fa-spinner fa-spin icon-spinner" style="display: none;"></i>
                </button>
            </div>

            <!-- Radar Student Data -->
            <div id="radarStudentDetails">
                <h5 id="radarStudentData"></h5>
            </div>

            <!-- Previous Report Comparison Dropdown -->
            <div class="col-12 col-md-auto ms-md-auto mt-2" id="comparisonDropdown" style="display: none;">
                <select id="previousDays" name="days" class="form-select">
                    <?php echo $PreviousDaysDropdown; ?>
                </select>
            </div>

            <!-- Register Number Input Field for Radar Chart -->
            <div class="col-12 col-md-auto ms-md-auto mt-2" id="radarInput" style="display: none;">
                <input type="number" class="form-control" id="radarRegisterNumber" placeholder="Enter Register Number" min="1">
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Course Completion Section -->
            <div class="tab-pane fade show active" id="course" role="tabpanel" aria-labelledby="course-tab">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover modern-table">
                        <thead class="table-primary" id="table-header">
                            <!-- Dynamic Header will load here -->
                        </thead>
                        <tbody id="table-body">
                            <!-- Dynamic Content will load here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="loading-spinner" style="display:none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div id="loadingOverlay">
                    <div class="loading-text">
                        Loading...
                    </div>
                </div>
            </div>


            <!-- Overall Performance Section -->
            <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                <div class="table-responsive">
                    <table id="performanceTable" class="table table-striped table-bordered table-hover"></table>
                </div>
            </div>


            <!-- Performance Difference Section -->
            <div class="tab-pane fade" id="difference" role="tabpanel" aria-labelledby="difference-tab">
                <div class="table-responsive">
                    <table id="differenceTable" class="table table-striped table-bordered table-hover"></table>
                </div>
            </div>

            <!-- Student Radar Chart -->
            <div class="tab-pane fade" id="studentRadar" role="tabpanel" aria-labelledby="radar-tab">
                <div class="row">
                    <div class="container col-md-6">
                        <canvas id="studentRadarChart" width="400" height="400"></canvas>
                    </div>
                    <div class="container col-md-6">
                        <p>gadf</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap core CSS and JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables core CSS and JS for Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <!-- DataTables FixedColumns CSS and JS for Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.3/css/fixedColumns.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.3/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.3/js/fixedColumns.bootstrap5.js"></script>

    <!-- DataTables Buttons CSS and JS for Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>


    <!-- Excel and PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <!-- Custom script -->
    <script src="/SMS/master/js/lms_portal_report_script.js"></script>

</body>
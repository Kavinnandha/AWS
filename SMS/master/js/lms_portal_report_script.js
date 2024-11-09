$(document).ready(function () {
    $('#infoPopover').popover({
        trigger: 'focus',
        html: true,
        placement: 'bottom',
        animation: true,
        delay: { show: 50, hide: 100 },
        offset: [370, 10]
    });
});

function downloadTableAsExcel() {
    const activeTabId = $('.tab-pane.active').attr('id');
    let table;

    if (activeTabId === 'course') {
        table = $("#course .table")[0];
    } else if (activeTabId === 'performance') {
        table = $("#performanceTable")[0];
    }

    if (!table) {
        alert("No table available to download.");
        return;
    }

    const workbook = XLSX.utils.table_to_book(table, {
        sheet: activeTabId
    });

    XLSX.writeFile(workbook, `${activeTabId}_data.xlsx`);
}

function downloadTableAsPDF() {
    const { jsPDF } = window.jspdf;

    const tempCanvas = document.createElement('canvas');
    const ctx = tempCanvas.getContext('2d');

    const activeTabId = $('.tab-pane.active').attr('id');
    let table;

    if (activeTabId === 'course') {
        table = $("#course .table")[0];
    } else if (activeTabId === 'performance') {
        table = $("#performanceTable")[0];
    }

    if (!table) {
        alert("No table available to download.");
        return;
    }

    const tableWidth = $(table).outerWidth();
    const doc = new jsPDF('landscape', 'pt', [tableWidth + 40, 800]);

    doc.autoTable({
        html: table,
        startY: 30,
        theme: 'grid',
        headStyles: {
            fillColor: "#097d3f"
        },
        margin: {
            top: 10
        },
        styles: {
            fontSize: 20,
            cellPadding: 2,
            overflow: 'linebreak',
            halign: 'center',
            valign: 'middle'
        },
    });
    doc.save(`${activeTabId}_data.pdf`);
}

function handleDownload(button, type) {
    $(button).addClass("downloading");
    const iconDownload = $(button).find(".icon-download");
    const iconSpinner = $(button).find(".icon-spinner");

    iconDownload.hide();
    iconSpinner.show();

    setTimeout(() => {
        $(button).removeClass("downloading");
        iconDownload.show();
        iconSpinner.hide();

        if (type === 'excel') {
            downloadTableAsExcel();
        } else if (type === 'pdf') {
            downloadTableAsPDF();
        }
    }, 700);
}

function loadCourses() {
    $.ajax({
        url: '/SMS/php/database_update/lms_course_actions.php?action=fetch',
        method: 'POST',
        dataType: 'json',
        success: function (courses) {
            const courseList = $('#courseList');
            courseList.empty();
            $.each(courses, function (index, course) {
                courseList.append(`
                    <tr>
                        <td>${course.lms_course_id}</td>
                        <td>
                            <span class="course-name" data-id="${course.lms_course_id}">${course.lms_course_name}</span>
                            <input type="text" class="edit-input d-none" data-id="${course.lms_course_id}" value="${course.lms_course_name}">
                        </td>
                        <td>
                            <div class="d-flex flex-nowrap align-items-center">
                                <button class="btn btn-warning edit-course me-1 me-sm-2" data-id="${course.lms_course_id}" onclick="toggleEdit(this)">Edit</button>
                                <button class="btn btn-success save-course d-none me-1 me-sm-2" data-id="${course.lms_course_id}" onclick="saveEdit(this)">Save</button>
                                <button class="btn btn-danger delete-course me-1 me-sm-2" data-id="${course.lms_course_id}" onclick="deleteCourse(this)">Delete</button>
                            </div>
                        </td>
                    </tr>
                `);
            });

            // Destroy existing DataTable if it exists
            if ($.fn.DataTable.isDataTable('#coursesTable')) {
                $('#coursesTable').DataTable().destroy();
            }

            // Reinitialize DataTable
            $('#coursesTable').DataTable({
                responsive: true,
                destroy: true
            });
        },
        error: function (error) {
            console.error('Error fetching courses:', error);
        }
    });
}

// Event listener to load courses when the modal opens
$('#courseModal').on('show.bs.modal', loadCourses);

function toggleEdit(button) {
    const row = $(button).closest('tr');
    const courseNameSpan = row.find('.course-name');
    const editInput = row.find('.edit-input');
    const saveButton = row.find('.save-course');
    $(button).addClass('d-none'); // Hide Edit button
    courseNameSpan.addClass('d-none'); // Hide span
    editInput.removeClass('d-none'); // Show input
    saveButton.removeClass('d-none'); // Show Save button
}

function saveEdit(button) {
    const row = $(button).closest('tr');
    const courseNameSpan = row.find('.course-name');
    const editInput = row.find('.edit-input');
    const editButton = row.find('.edit-course');
    const courseId = editInput.data('id');
    const updatedName = editInput.val().trim();

    if (confirm('Are you sure you want to change the course name?')) {
        $.ajax({
            url: '/SMS/php/database_update/lms_course_actions.php?action=update',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: courseId, name: updatedName }),
            success: function (result) {
                if (result.success) {
                    courseNameSpan.text(updatedName);
                } else {
                    console.error('Error updating course:', result.message);
                }

                $(button).addClass('d-none'); // Hide Save button
                editButton.removeClass('d-none'); // Show Edit button
                courseNameSpan.removeClass('d-none'); // Show span
                editInput.addClass('d-none'); // Hide input
            },
            error: function (error) {
                console.error('Error saving course:', error);
            }
        });
    }
}

// Delete course handler
function deleteCourse(button) {
    const courseId = $(button).data('id'); // Get the course ID from the button's data attribute
    if (confirm('Are you sure you want to delete this course?')) {
        $.ajax({
            url: `/SMS/php/database_update/lms_course_actions.php?action=delete&id=${courseId}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    alert('Course deleted successfully!');
                    loadCourses(); // Refresh the course list
                } else {
                    alert('Failed to delete course: ' + data.error);
                }
            },
            error: function (error) {
                console.error('Error deleting course:', error);
            }
        });
    }
}

// Insert New Course Handler, Handle switching between modals
$(document).ready(function () {
    // Clear any existing event listeners
    $('#addCourseBtn').off('click');
    $('#closeCourseFormBtn').off('click');
    $('#submitCourseBtn').off('click');
    $('#closeAddCourseFormBtn').off('click');

    // Handle Add Course button click
    $('#addCourseBtn').on('click', function () {
        $('#courseModal').modal('hide');
        removeBackdrop();
        setTimeout(() => {
            $('#addCourseFormModal').modal('show');
        }, 100);
    });

    // Handle close button in Add Course Form Modal
    $('#closeAddCourseFormBtn, #closeCourseFormBtn').on('click', function () {
        $('#addCourseFormModal').modal('hide');
        removeBackdrop();
        setTimeout(() => {
            $('#courseModal').modal('show');
        }, 100);
    });

    // Update submit course button handling
    $('#submitCourseBtn').on('click', function () {
        const courseName = $('#courseName').val();

        if (courseName) {
            $.ajax({
                url: '/SMS/php/database_update/lms_course_actions.php?action=insert',
                type: 'POST',
                data: {
                    course_name: courseName,
                },
                success: function (response) {
                    if (response.success) {
                        alert('Course added successfully!');
                        $('#addCourseForm')[0].reset();
                        $('#addCourseFormModal').modal('hide');
                        removeBackdrop();
                        setTimeout(() => {
                            $('#courseModal').modal('show');
                            loadCourses();
                        }, 100);
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('An error occurred while adding the course.');
                }
            });
        } else {
            alert('Please fill in the course name.');
        }
    });

    // Handle main modal hidden event
    $('#courseModal').on('hidden.bs.modal', function () {
        removeBackdrop();
    });

    // Handle add course form modal hidden event
    $('#addCourseFormModal').on('hidden.bs.modal', function () {
        removeBackdrop();
    });
});

// Function to remove modal backdrop
function removeBackdrop() {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    $('body').css('padding-right', '');
}

// Function to ensure proper modal state
function resetModalState() {
    removeBackdrop();
    $('body').addClass('modal-open');
}

// Show dropdown only when the Performance Difference tab is selected
$(document).ready(function () {
    $('#myTab button[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
        if (event.target.id === 'difference-tab') {
            $('#comparisonDropdown').show();
        } else {
            $('#comparisonDropdown').hide();
        }
        if (event.target.id === 'radar-tab') {
            $('#radarStudentDetails').show();
            $('#radarInput').show();
            $('#excelPdfDownload').hide();
            $('#comparisonDropdown').hide();
        }
        else {
            $('#radarInput').hide(); 
            $('#radarStudentDetails').hide();
        }
    });
});

$(document).ready(function () {

    let isInitialLoad = true;
    loadData();

    $('#batchFilter, #departmentFilter, #dateFilter, #previousDays').on('change', function (event) {
        isInitialLoad = false;
        loadData(event.target.id);
    });

    function loadData(changedFilter) {
        $('#loading-spinner').show();
        $('#loadingOverlay').show();

        let dataToSend = {};

        if (isInitialLoad) {
            dataToSend = {
                batch: $('#batchFilter').val(),
                department: $('#departmentFilter').val(),
                date: $('#dateFilter').val(),
                previousDays: $('#previousDays').val()
            };
        } else if (changedFilter === 'previousDays') {
            dataToSend = { previousDays: $('#previousDays').val() };
        } else {
            dataToSend = {
                batch: $('#batchFilter').val(),
                department: $('#departmentFilter').val(),
                date: $('#dateFilter').val()
            };
        }

        $.ajax({
            url: '/SMS/php/lms_portal_report_update.php',
            type: 'POST',
            data: dataToSend,
            dataType: 'json',
            success: function (response) {
                $('#loadingOverlay').hide();
                if (response.course_completion && response.performance && response.difference) {
                    if (isInitialLoad || changedFilter !== 'previousDays') {
                        renderCourseCompletion(response.course_completion);
                        renderPerformanceData(response.performance);
                        initializePerformanceTable();
                    }
                    if (isInitialLoad || changedFilter === 'previousDays') {
                        renderDifferenceData(response.difference);
                        initializeDifferenceTable();
                    }
                } else {
                    alert("Unexpected response format.");
                }
            },
            error: function () {
                $('#loadingOverlay').hide();
                alert('Error loading data');
            },
            complete: function () {
                $('#loading-spinner').hide();
                isInitialLoad = false;
            }
        });
    }

    function renderCourseCompletion(courseData) {
        if (!courseData.courses.length || !Object.keys(courseData.data).length) {
            $('#table-header').html('<tr><th colspan="100%" class="text-center">No data available</th></tr>');
            $('#table-body').html('');
            return;
        }

        let headerHtml = '<tr><th>Department - Section</th>';
        courseData.courses.forEach(course => {
            headerHtml += `<th>${course}</th>`;
        });
        headerHtml += '</tr>';
        $('#table-header').html(headerHtml);

        let bodyHtml = '';
        courseData.departments.forEach(department => {
            if (courseData.data[department]) {
                for (const section in courseData.data[department]) {
                    bodyHtml += `<tr><th>${department} - ${section}</th>`;
                    courseData.courses.forEach(course => {
                        const count = courseData.data[department][section][course] || 0;
                        bodyHtml += `<td>${count}</td>`;
                    });
                    bodyHtml += '</tr>';
                }
            }
        });

        if (!bodyHtml) {
            bodyHtml = '<tr><td colspan="' + (courseData.courses.length + 1) + '" class="text-center">No data available</td></tr>';
        }

        $('#table-body').html(bodyHtml);
    }

    function renderPerformanceData(performanceData) {
        if ($.fn.DataTable.isDataTable('#performanceTable')) {
            $('#performanceTable').DataTable().destroy();
        }

        let tableHtml = '<thead class="table-success"><tr>';
        tableHtml += '<th>S No</th><th>Register Number</th><th>Name</th><th>Department</th><th>Section</th>';
        performanceData.performance_courses.forEach(course => {
            tableHtml += `<th>${course}</th>`;
        });
        tableHtml += '</tr></thead><tbody>';

        performanceData.performance_students.forEach(student => {
            tableHtml += '<tr>';
            tableHtml += `<td>${student.s_no}</td>`;
            tableHtml += `<td>${student.register_no}</td>`;
            tableHtml += `<td>${student.student_name}</td>`;
            tableHtml += `<td>${student.department_name}</td>`;
            tableHtml += `<td>${student.section_name}</td>`;
            performanceData.performance_courses.forEach(course => {
                tableHtml += `<td>${student.courses[course] || '-'}</td>`;
            });
            tableHtml += '</tr>';
        });
        tableHtml += '</tbody>';

        $('#performanceTable').html(tableHtml);
    }

    function renderDifferenceData(differenceData) {
        // Destroy existing DataTable instance if present
        if ($.fn.DataTable.isDataTable('#differenceTable')) {
            $('#differenceTable').DataTable().destroy();
        }

        let tableHtml = '<thead class="table-warning"><tr>';
        tableHtml += '<th>S No</th><th>Register Number</th><th>Name</th><th>Department</th><th>Section</th>';
        differenceData.difference_courses.forEach(course => {
            tableHtml += `<th>${course}</th>`;
        });
        tableHtml += '</tr></thead><tbody>';

        differenceData.difference_students.forEach(student => {
            tableHtml += '<tr>';
            tableHtml += `<td>${student.s_no}</td>`;
            tableHtml += `<td>${student.register_no}</td>`;
            tableHtml += `<td>${student.student_name}</td>`;
            tableHtml += `<td>${student.department_name}</td>`;
            tableHtml += `<td>${student.section_name}</td>`;
            differenceData.difference_courses.forEach(course => {
                tableHtml += `<td>${student.scores[course] || '-'}</td>`;
            });
            tableHtml += '</tr>';
        });
        tableHtml += '</tbody>';

        $('#differenceTable').html(tableHtml);
    }

    function initializePerformanceTable() {
        const performanceTable = $('#performanceTable').DataTable({
            dom: "<'row mb-3'<'col-sm-6'B><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: ['colvis'],
            pageLength: -1,
            paging: false,
            scrollY: 500,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 3
            }
        });

        $('#performanceTable tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });

        let state = true;
        $('#performance-tab').on('click', function () {
            if (state) {
                performanceTable.order([0, 'asc']).draw();
                state = false;
            }
        });
    }

    function initializeDifferenceTable() {
        // Check if DataTable exists and destroy it safely
        if ($.fn.DataTable.isDataTable('#differenceTable')) {
            $('#differenceTable').DataTable().destroy();
        }
        let totalScoreIndex;
        const differenceTable = $('#differenceTable').DataTable({
            dom: "<'row mb-3'<'col-sm-6'B><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: ['colvis'],
            pageLength: -1,
            paging: false,
            scrollX: true,
            scrollY: 500,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 3
            },
            ordering: true,
            initComplete: function () {
                const api = this.api();

                // Find the 'Total score' column and set the index
                api.columns().every(function (index) {
                    const columnHeader = $(api.column(index).header()).text().trim();
                    if (columnHeader === 'Total score') {
                        totalScoreIndex = index;
                        return false; // Exit loop once found
                    }
                });

                if (typeof totalScoreIndex !== 'undefined') {
                    api.order([totalScoreIndex, 'asc']).draw();
                }
            }
        });

        // Toggle row selection
        $('#differenceTable tbody').on('click', 'tr', function () {
            $(this).toggleClass('selected');
        });

        let state = true;
        $('#difference-tab').on('click', function () {
            if (state && typeof totalScoreIndex !== 'undefined') {
                differenceTable.order([totalScoreIndex, 'asc']).draw();
                state = false;
            }
        });
    }

    initializePerformanceTable();
    initializeDifferenceTable();
});

// Student Radar Chart
$(document).ready(function () {
    $('#radarRegisterNumber').on('change', loadRadarChart);

    function loadRadarChart() {
        const registerNumber = $('#radarRegisterNumber').val();
        if (!registerNumber) return;

        $.ajax({
            url: '/SMS/php/lms_portal_report_update.php',
            type: 'POST',
            data: { register_no: registerNumber },
            dataType: 'json',
            success: function (radar_score_data) {
                renderStudentRadarChart(radar_score_data.radar_data.radar_chart_data);
                renderRadarStudentDetails(radar_score_data.radar_data.radar_student_details);
            },
            error: function() {
                alert("Unexpected response from server");
            }
        });
    }
    function renderRadarStudentDetails(radarStudentDetails) {
        // Select the element where you want to display the student details
        const radarStudentDataElement = document.getElementById('radarStudentData');
    
        // Set the content of the element to the student's name
        radarStudentDataElement.textContent = radarStudentDetails;
    }

    function renderStudentRadarChart(radarChartData) {
        const labels = Object.keys(radarChartData);
        const dataValues = Object.values(radarChartData).map(Number);
    
        // If a chart already exists, destroy it to avoid overlapping
        if (window.studentRadarChart instanceof Chart) {
            window.studentRadarChart.destroy();
        }
    
        const ctx = document.getElementById('studentRadarChart').getContext('2d');
    
        // Applying the gradient color for the background
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 204, 102, 0.3)');
        gradient.addColorStop(1, 'rgba(0, 204, 102, 0.05)');
    
        window.studentRadarChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Course Scores',
                    data: dataValues,
                    fill: true,
                    backgroundColor: gradient,               
                    borderColor: '#00cc66',                 
                    borderWidth: 2,
                    pointBackgroundColor: '#00cc66',        
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#00cc66',     
                    pointRadius: 4,                          
                    pointHoverRadius: 6                    
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: 'rgba(0, 0, 0, 0.1)' }, 
                        grid: { color: 'rgba(0, 0, 0, 0.1)' },       
                        pointLabels: {
                            color: '#4a4a4a',                        
                            font: { size: 12, weight: 'bold' }
                        },
                        ticks: {
                            backdropColor: 'transparent',           
                            display: false                            
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                }
            }
        });
    }
    
});
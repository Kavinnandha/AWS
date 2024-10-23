<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Internships</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <p class="navbar-brand">Extra-curricular Activities</p>
    </div>
</nav>

<div class="container mt-4 p-4 shadow-lg rounded">
    <h1 class="text-center">Completed Internships</h1>

    <section class="mb-4">
        <div>
        <form action="internship_upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="Companyn" class="form-label">Company Name:</label>
                <select class="form-select" id="companySelect" name="company_name" required></select>
            </div>
            <div class="mb-3" id="otherCompanyField" style="display:none;">
                <label for="otherCompany" class="form-label">Enter Company Name:</label>
                <input type="text" class="form-control" name="name" id="otherCompany">
            </div>
            <input type="hidden" id="type" value="internship" name="type">
            <div class="mb-3">
                <label for="Positionn" class="form-label">Role:</label>
                <input type="text" class="form-control" id="Positionn" name="role" required>
            </div>
            <div class="mb-3">
                <label for="durationn" class="form-label">Duration:</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">From</span>
                            <input type="date" class="form-control" id="from_date" required name="from_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Till</span>
                            <input type="date" class="form-control" id="to_date" required name="to_date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="uploadss" class="form-label">Upload:</label>
                <input type="file" class="form-control" id="uploadss" name="userFile" required>
            </div>
            <div class="mb-3">
                <label for="des" class="form-label">Description:</label>
                <input type="text" class="form-control" id="des" name="des" required>
            </div>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var courseSelect = document.getElementById('companySelect');
        var otherCourseField = document.getElementById('otherCompanyField');
        var otherCourseInput = document.getElementById('otherCompany');
    
        
        var type = "internship";
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'event.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.status === 200) {
                courseSelect.innerHTML = this.responseText;
                 
            }
        };
        xhr.send('type=' + encodeURIComponent(type));

        // Show/Hide custom course name input
        courseSelect.addEventListener('change', function () {
            if (courseSelect.value === 'Others') {
                otherCourseField.style.display = 'block'; 
                otherCourseInput.required = true;
                otherCourseInput.value = ''; 
            } else {
                otherCourseField.style.display = 'none';
                otherCourseInput.required = false;
                otherCourseInput.value = courseSelect.value; 
            }
        });
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extra Courses Done</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <p class="navbar-brand">Extra-curricular Activities</p>
    </div>
</nav>

<div class="container mt-4 p-4 shadow-lg rounded">
    <h1 class="text-center">Extra Courses Done</h1>

    <section class="mb-4">
    <form action="extra_course_upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="courseSelect" class="form-label">Course Name:</label>
                <select class="form-select" id="courseSelect" name="course_name" required></select>
            </div>
            <div class="mb-3" id="otherCourseField" style="display:none;">
                <label for="otherCourse" class="form-label">Enter Course Name:</label>
                <input type="text" class="form-control" name="name" id="otherCourse">
            </div>
            <input type="hidden" id="type" value="extra_courses_done" name="type">
            <div class="mb-3">
                <label for="description" class="form-label">Course Description:</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <div class="mb-3">
                <label for="issued" class="form-label">Issued By:</label>
                <input type="text" class="form-control" id="issued" name="issued" required>
            </div>
            <div class="mb-3">
                <label for="upload" class="form-label">Upload:</label>
                <input type="file" class="form-control" id="upload" name="userFile" required>
            </div>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var courseSelect = document.getElementById('courseSelect');
        var otherCourseField = document.getElementById('otherCourseField');
        var otherCourseInput = document.getElementById('otherCourse');
    
         
        var type = "extra_courses_done";
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

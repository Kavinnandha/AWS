<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Paper and Publications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <p class="navbar-brand">Extra-curricular Activities</p>
    </div>
</nav>

<div class="container mt-4 p-4 shadow-lg rounded">
    <h1 class="text-center">Research Paper & Publications</h1>

    <section class="mb-4">
    <form action="research_paper_upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="paper" class="form-label">Paper Title:</label>
                <select class="form-select" id="paperSelect" name="paper_name" required></select>
            </div>
            <div class="mb-3" id="otherPaperField" style="display:none;">
                <label for="otherPaper" class="form-label">Enter Paper Title:</label>
                <input type="text" class="form-control" name="name" id="otherPaper">
            </div>
            <input type="hidden" id="type" value="research" name="type">
            <div class="mb-3">
                <label for="publication" class="form-label">Publication Name:</label>
                <input type="text" class="form-control" id="publication" name="publication" required>
            </div>
            <div class="mb-3">
            <label for="link" class="form-label">Publication Link:</label>
            <input type="text" class="form-control" id="link" name="link" required>
            </div>
            <div class="mb-3">
            <label for="des" class="form-label">Description:</label>
            <input type="text" class="form-control" id="des" name="des" required>
            </div>
            <div class="mb-3">
                <label for="uploadss" class="form-label">Upload:</label>
                <input type="file" class="form-control" id="uploadss" name="userFile" required>
            </div>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var courseSelect = document.getElementById('paperSelect');
        var otherCourseField = document.getElementById('otherPaperField');
        var otherCourseInput = document.getElementById('otherPaper');
    
        var type = "research";
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'event.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.status === 200) {
                courseSelect.innerHTML = this.responseText;
                 
            }
        };
        xhr.send('type=' + encodeURIComponent(type));

        
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

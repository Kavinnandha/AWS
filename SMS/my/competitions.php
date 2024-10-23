<?php include 'event.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competitions and Hackathons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <p class="navbar-brand">Extra-curricular Activities</p>
    </div>
</nav>

<div class="container mt-4 p-4 shadow-lg rounded">
    <h1 class="text-center">Competitions and Hackathons</h1>

    <section class="mb-4">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="Competition" class="form-label">Competition Name:</label>
                <select class="form-select" id="competitionSelect" required></select>
            </div>
            <div class="mb-3" id="otherCompetitionField" style="display:none;">
                <label for="otherCompetition" class="form-label">Enter Competition Name:</label>
                <input type="text" class="form-control" name="name" id="otherCompetition">
            </div>

            <input type="hidden" id="type" value="competition" name="type">
            <div class="mb-3">
                <label for="Positionn" class="form-label">Position secured:</label>
                <input type="text" class="form-control" name="position" id="Positionn">
            </div>
            <div class="mb-3">
                <label for="durationn" class="form-label">Held On:</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Date:</span>
                            <input type="date" class="form-control" id="fromDate" name="From" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="des" class="form-label">Description:</label>
                <input type="text" class="form-control" name="des" id="des" required>
            </div>
            <div class="mb-3">
                <label for="uploadss" class="form-label">Upload:</label>
                <input type="file" name="userFile" class="form-control" id="uploadss" required>
            </div>
            
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </form>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var competitionSelect = document.getElementById('competitionSelect');
        var otherCompetitionField = document.getElementById('otherCompetitionField');
        var otherCompetitionInput = document.getElementById('otherCompetition');
          
        var type = "competition";
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'event.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.status === 200) {
                competitionSelect.innerHTML = this.responseText; 
            }
        };
        xhr.send('type=' + encodeURIComponent(type));

        
        competitionSelect.addEventListener('change', function () {
            if (competitionSelect.value === 'Others') {
                otherCompetitionField.style.display = 'block'; 
                otherCompetitionInput.required = true;
                otherCompetitionInput.value = ''; 
            } else {
                otherCompetitionField.style.display = 'none';
                otherCompetitionInput.required = false; 
                otherCompetitionInput.value = competitionSelect.value; 
            }
        });
    });
</script>
</body>
</html>

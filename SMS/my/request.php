<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
    <link rel="stylesheet" href = "css/request.css">
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel = "stylesheet">
</head>
<body>
    <div >
        <div class= "title"><h1>REQUEST / FEEDBACK</h1></div>
    </div>
    <div class =" container">
    <div class="col-17">
    <form method="POST" action="../php/submit_request.php">
    <input type="hidden" name="origin" value="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <label for="inputAddress" class="form-label">Description</label>
      <div class="mb-3">
        <textarea class="form-control" name="request" id="exampleFormControlTextarea1" rows="7" placeholder="Tell us your feedback"></textarea>
      </div>
    </div>

    <div class="col-12">
      <div class="d-flex justify-content-center" >
      <button type="submit" class="btn-primary" class="d-flex justify-content-center">Submit</button>
      </div>
    </div>
  </form></div>
</body>
</html>

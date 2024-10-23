<?php include 'php/search_details.php'; 
include 'master/dependancies.php';
include 'master/sidebar.php'; ?>
<style>
  .modal-xxl {
            max-width: 90%;
            margin: 1.75rem auto;
        }

        .modal-content {
            height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #video {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
</style>
<form method="POST" action="php/upload_attendance.php">
    <div class="row">
	<div class="col-md-2">
	<?php
		echo $academic_year;
	?>
	</div>
	<div class="col-md-8">
	<?php echo $main_dropdown; ?>
	</div>
    <div class="col-md-2">

	    <select name="period" id="period" class="form-select" aria-label="Default select example" required>
		    <option value="">Periods</option>
		    <option value="1">1</option>
		    <option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
              </select>
    </div>
    </div>
    <div class="form-group" id="form-group" >
        <div class="input-group mx-auto" >
            <input type="text" class="form-control" name="topics" id="topic-covered" placeholder="Topics covered" style="text-align: center;border:1px solid black">
        </div>
    </div>
    <div class="mt-5">
    <h5 id="studentCount"></h4>
    </div>
    <div style="padding-top: 45px;">
        <table class="table table-striped" >
            <thead>
                <tr>
                  <th scope="col">Register Number</th>
                  <th scope="col">Name</th>
                  <th scope="col">Attendance</th>
                  <th scope="col">Remarks</th>
                </tr>
              </thead>
              <tbody id="student-information">
              </tbody>
          </table>
        </div>
	<button id="submit-attendance" class="btn btn-success" value="submit">Submit</button>
	<input id="new-id" name="new-id" type="hidden" value="0"/>
</form>
<div class="modal fade" id="captureModal" tabindex="-1" aria-labelledby="captureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xxl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="captureModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container text-center">
                        <video id="video" width="100%" height="100%" autoplay></video> 
                        <canvas id="canvas" width="1460px" height="820px" style="display:none;"></canvas> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="save">Capture</button>
                </div>
            </div>
        </div>
    </div>
    
<script src="master/js/capture.js">
</script>
$(document).ready(function(){

    $('#main-dropdown').on('change', function() {
        var main_data = $('#main-dropdown').val();
        var values = main_data.split(',');
        
        $.ajax({
            url: 'php/select_students.php',
            type: 'POST',
            data: { batch_id: values[0], section_id: values[3]},
            dataType: 'json',
            success: function(data){
                $('#student-information').empty();
                    var student_count = 0;
                $.each(data.students, function(key, value){
                    var attendanceOptions = '';
                    $.each(data.attendance_type, function(key, type){
                        attendanceOptions += `<option value="${type.value}" class="attendance-type">${type.description}</option>`;

                    });
                    student_count++;
                    $('#student-information').append(`
                        <tr>
                            <th scope="row">${value.register_no}</th>
                            <td>${value.name}</td>
                            <td>
                                <select class="form-select attendance-select" aria-label="Default select example">
                                    ${attendanceOptions}
                                </select>
                            </td>
                            <td>
                                <div class="form-group" style="width: auto;">
                                    <div class="input-group mx-auto">
                                        <input type="text" class="form-control remarks-input" placeholder="Remarks" style="text-align: center; border:1px solid black"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                });
                   document.getElementById('studentCount').textContent = `Total Strength: ${student_count}`;
                    console.log(student_count);

		$('.attendance-select').on('change', function() {
			    var selectedValue = $(this).val();
			    $(this).css('background-color','');
			    if (selectedValue === '0') {
				$(this).css('background-color', 'red'); 
			    } else if (selectedValue === '-1') {
				$(this).css('background-color', 'orange'); 
			    } 
			});

            },
            error: function(xhr, status, error){
                console.error('Error fetching students:', error);
            }
        });
    });


    $('#main-dropdown').on('change', function() {
        var main_data = $('#main-dropdown').val();
	var batchid = main_data.split(',');
        if(batchid){
            $.ajax({
                url: 'php/select_new_id.php',
                type: 'POST',
                data: { batch_id: batchid[0],
                        course_id: batchid[2],
                        section_id: batchid[3],
                        department_id: batchid[1]
                },
                dataType: 'json',
                success: function(data){
                    	$('#new-id').val(data.new_id);
                },
                error: function(xhr, status, error){
                    console.error('error fetching sections', error);
                }
            });
        }
    });
   
    $("#submit-attendance").click(function(e) {
        e.preventDefault(); 
    
        var tableData = [];
        var attendanceCount = { present: 0, absent: 0, OD: 0 };
        var newId = $("#new-id").val();
        var topicCovered = $("#topic-covered").val(); 
        var periodTaken = $("#period").val();
        var year = $("#year-dropdown").val(); 
        
      
        $("#student-information tr").each(function() {
            var $row = $(this);
            var stat = $row.find("select").val();
            var rowData = {
                register_no: $row.find("th").text(), 
                status: stat, 
                remarks: $row.find(".remarks-input").val()
            };
            tableData.push(rowData);
    
            
            if (stat == "0") {
                attendanceCount.absent++;
            } else if (stat == "-1") {
                attendanceCount.OD++;
            } else {
                attendanceCount.present++;
            }
        });
    
        if (!newId || !topicCovered || !periodTaken || !year) {
            alert("Please fill all required fields.");
            return;
        }
    
       
        $.ajax({
            url: 'php/upload_attendance.php',
            method: 'POST',
            data: {
                new_id: newId, 
                year: year, 
                period: periodTaken,
                topic: topicCovered, 
                attendance_data: JSON.stringify(tableData),
                attendance_count: JSON.stringify(attendanceCount) 
            },
            dataType: 'json',
            success: function(result) {
                if (result.status === 'exists') {
                    alert('Data already exists for this period and date.'); 
                    $('#student-information').empty();
                    result.data.forEach(function(session){
                        $('#student-information').append(`
                        <tr>
                            <th scope="row">${session.register_no}</th>
                            <td>${session.name}</td>
                            <td>${session.description}</td>
                            <td>${session.remark}</td>
                        </tr>`);
                    });
                } else if (result.status === 'success') {
                    alert('Data submitted successfully.'); 
                } else {
                    alert('Error: ' + result.message); 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error submitting data: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });

});

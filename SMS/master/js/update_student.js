$(document).ready(function () {
                let studentCount = 1;

                $('#addEntry').click(function () {
                    let newEntry = `
                        <tr>
                            <td><input type="text" name="students[${studentCount}][name]" class="form-control" placeholder="Enter Student Name :" required></td>
                            <td><input type="text" name="students[${studentCount}][register_no]" class="form-control" placeholder="Enter Register No :" required></td>
                            <td><input type="text" name="students[${studentCount}][email]" class="form-control" placeholder="Enter Email ID :" required></td>
                            <td><input type="date" name="students[${studentCount}][DOB]" class="form-control" required></td>
                            <td>
                                <select name="students[${studentCount}][gender]" class="form-select" required>
                                    <option value="" selected>Gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </td>
                            <td>
                                <select name="students[${studentCount}][boarding_status]" class="form-select" required>
                                    <option value="" selected>Boarding Status</option>
                                    <option value="D">Dayscholar</option>
                                    <option value="H">Hosteller</option>
                                </select>
                            </td>
                        </tr>`;

                    $('#studentEntries').append(newEntry);
                    studentCount++;
                });
	    });    	
	new DataTable('#student-data');

$(function() {
    $('table').on('click', 'button[data-bs-target="#updateStudentModal"]', function (ele) {
        var tr = ele.target.closest('tr');
        var register_no = tr.cells[0].textContent;
        var name = tr.cells[1].textContent;
        var email = tr.cells[2].textContent;
        var dob = tr.cells[3].textContent;
        var [day,month,year] = dob.split('-');
        var formatted_dob = `${year}-${month.padStart(2,'0')}-${day.padStart(2,'0')}`;  
        var gender = tr.cells[4].textContent;
        var boarding_status = tr.cells[5].textContent == "Day Scholar" ? "D" : "H";
        var department_id = tr.querySelector('input.department_id').value;
        var section_id = tr.querySelector('input.section_id').value;
        var batch_id = tr.querySelector('input.batch_id').value;
        var programme_id = tr.querySelector('input.programme_id').value;
        $('#editName').val(name);
        $('#editId').val(register_no);
        $('#editEmail').val(email);
        $('#editDate').val(formatted_dob);
        $('#editGender').val(gender);
        $('#editBoardingStatus').val(boarding_status);
        $('#editDepartment').val(department_id);
        $('#editSection').val(section_id);
        $('#editBatch').val(batch_id);
        $('#updateStudentModal').data('row', tr);
    });

    $('#updateStudentModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            name:$('#editName').val(),
            register_no:$('#editId').val(),
            email:$('#editEmail').val(),
            date:$('#editDate').val(),
            gender:$('#editGender').val(),
            boarding_status:$('#editBoardingStatus').val(),
            department_id:$('#editDepartment').val(),
            section_id:$('#editSection').val(),
            batch_id:$('#editBatch').val()

        };

        $.ajax({
            url: '../../php/database_update/update_student.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Student data updated successfully!');
                var tr = $('#updateStudentModal').data('row');
                tr.cells[0].textContent = formData.register_no;
                tr.cells[1].textContent = formData.name;
                tr.cells[2].textContent = formData.email;
                tr.cells[3].textContent = formData.date;
                tr.cells[4].textContent = formData.gender;
                tr.cells[5].textContent = $('#editBoardingStatus option:selected').text();
                tr.cells[6].textContent = $('#editDepartment option:selected').text();
                tr.cells[7].textContent = $('#editSection option:selected').text();
                tr.cells[8].textContent = $('#editBatch option:selected').text();
                $('#updateStudentModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-student-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.cells[0].textContent;
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                url: '../../php/database_update/update_student.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Student data deleted successfully!');
                    } else {
                        alert('Cannot Delete the entry, It is being referenced somewhere else!');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        }
    });
});



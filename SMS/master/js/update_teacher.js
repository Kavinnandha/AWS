         $(document).ready(function () {
                let teacherCount = 1;
                const departmentOptions = $('#departmentOptions').html();
                const roleOptions = $('#roleOptions').html();
                
                $('#addEntry').click(function () {
                    let newEntry = `
                        <tr>
                            <td><input type="text" name="teachers[${teacherCount}][name]" class="form-control" placeholder="Enter Teacher Name :" required></td>
                            <td><input type="email" name="teachers[${teacherCount}][email_id]" class="form-control" placeholder="Enter Email ID :" required></td>
			            <td>
			    	        <select name="teachers[${teacherCount}][department]" class="form-select" aria-label="select department" required>
				                ${departmentOptions}
				            </select>
			            </td>
                            <td>
                                <select name="teachers[${teacherCount}][gender]" class="form-select" required>
                                    <option value="" selected>Gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </td>
                            <td><input type="text" name="teachers[${teacherCount}][designation]" class="form-control" placeholder="Enter Designation :" required></td>
                            <td>
			    	            <select name="teachers[${teacherCount}][role]" class="form-select" aria-label="select role" required>
				                    ${roleOptions}
				                </select>
			                </td>
                            <td><button class="btn btn-outline-danger mt-1 removeEntry"><i class ="fi fi-rr-trash"></i></button></td>   
                        </tr>`;

                    $('#teacherEntries').append(newEntry);
                    teacherCount++;
                });
                $(document).on('click', '.removeEntry', function () {
                    $(this).closest('tr').remove();
                });
            });

            new DataTable('#teacher-data');

$(function() {
    $('table').on('click', 'button[data-bs-target="#updateTeacherModal"]', function (ele) {
        var tr = ele.target.closest('tr');
        var name = tr.cells[0].textContent;
        var user_id = tr.querySelector('input.user_id').value;
        var email = tr.cells[1].textContent;
        var department_id = tr.querySelector('input.department_id').value;
        var gender = tr.cells[3].textContent;
        var designation = tr.cells[4].textContent;
        var role = tr.querySelector('input.role_id').value;
        $('#editName').val(name);
        $('#editId').val(user_id);
        $('#editEmail').val(email);
        $('#editGender').val(gender);
        $('#editDepartment').val(department_id);
        $('#editRole').val(role);
        $('#editDesignation').val(designation);
        $('#updateTeacherModal').data('row', tr);
    });

    $('#updateTeacherModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            user_id: $('#editId').val(),          
            name: $('#editName').val(),
            email: $('#editEmail').val(),
            gender: $('#editGender').val(),
            role_id: $('#editRole').val(),
            department_id: $('#editDepartment').val(),
            designation: $('#editDesignation').val()
        };

        $.ajax({
            url: '../../php/database_update/update_teacher.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Staff data updated successfully!');
                var tr = $('#updateTeacherModal').data('row');
                tr.cells[0].textContent = formData.name;
                tr.cells[1].textContent = formData.email;
                tr.cells[2].textContent = $('#editDepartment option:selected').text();
                tr.cells[3].textContent = formData.gender;
                tr.cells[4].textContent = formData.designation;
                tr.cells[5].textContent = $('#editRole option:selected').text();
                $('#updateTeacherModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-teacher-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.user_id').value;
        if (confirm('Are you sure you want to delete this Staff?')) {
            $.ajax({
                url: '../../php/database_update/update_teacher.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Staff data deleted successfully!');
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


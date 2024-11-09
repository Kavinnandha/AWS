            $(document).ready(function () {
                let courseCount = 1;
                const courseTypeOptions = $('#courseTypeOptions').html();

                $('#addEntry').click(function () {
                    let newEntry = `
                        <tr>
                            <td><input type="text" name="courses[${courseCount}][course_id]" class="form-control" placeholder="Enter Course ID :" required></td>
                            <td><input type="text" name="courses[${courseCount}][name]" class="form-control" placeholder="Enter Course Name:" required></td>
					        <td>
						        <select name="courses[${courseCount}][type_id]" class="form-select" aria-label="Select Type ID" required>
								    ${courseTypeOptions}
						        </select>
					        </td>
                            <td><button class="btn btn-outline-danger mt-1 removeEntry"><i class ="fi fi-rr-trash"></i></button></td>
                        </tr>`;

                    $('#courseEntries').append(newEntry);
                    courseCount++;
                });
                $(document).on('click', '.removeEntry', function () {
                    $(this).closest('tr').remove();
                });
            });

$(function() {
    $('table').on('click', 'button[data-bs-target="#updateCourseModal"]', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.cells[0].textContent;
        var name = tr.cells[1].textContent; 
        var type = tr.querySelector('input.type_id').value;
        $('#editName').val(name);
        $('#editId').val(id);
        $('#editType').val(type);
        $('#updateCourseModal').data('row', tr);
    });

    $('#updateCourseModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            course_id: $('#editId').val(),          
            course_name: $('#editName').val(),
            type_id : $('#editType').val()
        };

        $.ajax({
            url: '../../php/database_update/update_course.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Course updated successfully!');
                var tr = $('#updateCourseModal').data('row');
                tr.cells[0].textContent = formData.course_id;
                tr.cells[1].textContent = formData.course_name;
                tr.cells[2].textContent = $('#editType option:selected').text();
                $('#updateCourseModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-course-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.cells[0].textContent.trim();  

        if (confirm('Are you sure you want to delete this course?')) {
            $.ajax({
                url: '../../php/database_update/update_course.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Course deleted successfully!');
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

new DataTable('#course-table');


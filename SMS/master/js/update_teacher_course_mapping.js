$(function() {
    $('table').on('click', 'button[data-bs-target="#updateMappingModal"]', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.new_id').value;
        var user_id = tr.querySelector('input.user_id').value;
        var section_id = tr.querySelector('input.section_id').value;
        var course_mapping_id = tr.querySelector('input.course_mapping_id').value;
        $('#editId').val(id);
        $('#editUserId').val(user_id);
        $('#editCourseMappingId').val(course_mapping_id);
        $('#editSectionId').val(section_id);
        $('#updateMappingModal').data('row', tr);
    });

    $('#updateMappingModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            new_id: $('#editId').val(),
            user_id: $('#editUserId').val(),
            course_mapping_id: $('#editCourseMappingId').val(),
            section_id: $('#editSectionId').val()
        };

        $.ajax({
            url: '../../php/database_update/update_teacher_course_mapping.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Teacher Course Mapping updated successfully!');
                var tr = $('#updateMappingModal').data('row');
                var array = $('#editCourseMappingId option:selected').text().split(" - ");
                tr.cells[0].textContent = $('#editUserId option:selected').text();
                tr.cells[1].textContent = array[0];
                tr.cells[2].textContent = array[1];
                tr.cells[3].textContent = array[2];
                tr.cells[4].textContent = array[3];
                tr.cells[5].textContent = $('#editSectionId option:selected').text();
                $('#updateMappingModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-mapping-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.new_id').value;

        if (confirm('Are you sure you want to delete this Mapping?')) {
            $.ajax({
                url: '../../php/database_update/update_teacher_course_mapping.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Mapping deleted successfully!');
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
new DataTable('#teacher-course-map');

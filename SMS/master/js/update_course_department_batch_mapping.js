$(function() {
    $('table').on('click', 'button[data-bs-target="#updateMappingModal"]', function (event) {
        var tr = event.target.closest('tr');
        var id = tr.querySelector('input.course_mapping_id').value;
        var course_id = tr.querySelector('input.course_id').value;
        var mapping_id = tr.querySelector('input.mapping_id').value;
        var batch_id = tr.querySelector('input.batch_id').value;
        var semester = tr.cells[3].textContent;
        var section_id = tr.querySelector('input.section_id').value;
     
        $('#editId').val(id);
        $('#editCourseId').val(course_id);
        $('#editMappingId').val(mapping_id);
        $('#editBatchId').val(batch_id);
        $('#editSemester').val(semester);
        $('#updateMappingModal').data('row', tr);
    });

    $('#updateMappingModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            course_mapping_id: $('#editId').val(),
            course_id: $('#editCourseId').val(),
            mapping_id: $('#editMappingId').val(), 
            batch_id: $('#editBatchId').val(),
            semester: $('#editSemester').val(),
        };
        $.ajax({
            url: '../../php/database_update/update_course_department_batch_mapping.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Course Department Batch Mapping Updated successfully!');
                var tr = $('#updateMappingModal').data('row');
                tr.cells[0].textContent = $('#editCourseId option:selected').text();
                tr.cells[1].textContent = $('#editMappingId option:selected').text();
                tr.cells[2].textContent = $('#editBatchId option:selected').text();
                tr.cells[3].textContent = $('#editSemester option:selected').text();
                $('#updateMappingModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
    $('table').on('click', '.delete-cdb-mapping-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.course_mapping_id').value;

        if (confirm('Are you sure you want to delete this Mapping?')) {
            $.ajax({
                url: '../../php/database_update/update_course_department_batch_mapping.php',  
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


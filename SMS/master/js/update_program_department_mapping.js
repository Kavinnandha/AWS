$(function() {
    $('table').on('click', 'button[data-bs-target="#updateMappingModal"]', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.mapping_id').value;
        var programme_id = tr.querySelector('input.programme_id').value;
        var department_id = tr.querySelector('input.department_id').value;
        $('#editId').val(id);
        $('#editProgrammeId').val(programme_id);
        $('#editDepartmentId').val(department_id);
        $('#updateMappingModal').data('row', tr);
    });

    $('#updateMappingModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            mapping_id: $('#editId').val(),          
            programme_id: $('#editProgrammeId').val(),
            department_id : $('#editDepartmentId').val()
        };

        $.ajax({
            url: '../../php/database_update/update_program_department_mapping.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Programme Department Mapping updated successfully!');
                var tr = $('#updateMappingModal').data('row');
                tr.cells[0].textContent = $('#editProgrammeId option:selected').text();
                tr.cells[1].textContent = $('#editDepartmentId option:selected').text();
                $('#updateMappingModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-program-department-mapping-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.mapping_id').value;

        if (confirm('Are you sure you want to delete this course?')) {
            $.ajax({
                url: '../../php/database_update/update_program_department_mapping.php',  
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


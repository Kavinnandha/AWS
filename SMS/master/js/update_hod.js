$(function() {
    $('table').on('click', 'button[data-bs-target="#updateMappingModal"]', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.hod_mapping_id').value;
        var user_id = tr.querySelector('input.user_id').value;
        var department_id = tr.querySelector('input.department_id').value;
        $('#departmentId').val(department_id);
        $('#userId').val(user_id);
        $('#editId').val(id);
        $('#updateMappingModal').data('row', tr);
    });

    $('#updateMappingModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            hod_mapping_id: $('#editId').val(),
            user_id: $('#userId').val(),
            department_id: $('#departmentId').val()
        };

        $.ajax({
            url: '../../php/database_update/update_hod_mapping.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Department updated successfully!');
                var tr = $('#updateMappingModal').data('row');
                tr.cells[0].textContent = $('#userId option:selected').text();
                tr.cells[1].textContent = $('#departmentId option:selected').text();
                $('#updateMappingModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-hod-mapping-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.hod_mapping_id').value;
        if (confirm('Are you sure you want to delete this HOD mapping?')) {
            $.ajax({
                url: '../../php/database_update/update_hod_mapping.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove(); 
                        alert('HOD mapping deleted successfully!');
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


$(function() {
    $('table').on('click', 'button[data-bs-target="#updateDepartmentModal"]', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.cells[0].textContent;
        var name = tr.cells[1].textContent;  
        $('#editName').val(name);
        $('#editId').val(id);
        $('#updateDepartmentModal').data('row', tr);
    });

    $('#updateDepartmentModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            department_id: $('#editId').val(),          
            department_name: $('#editName').val(),      
        };

        $.ajax({
            url: '../../php/database_update/update_department.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Department updated successfully!');
                var tr = $('#updateDepartmentModal').data('row');
                tr.cells[1].textContent = formData.department_name;
                $('#updateDepartmentModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-department-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.cells[0].textContent.trim();  

        if (confirm('Are you sure you want to delete this department?')) {
            $.ajax({
                url: '../../php/database_update/update_department.php',  
                type: 'POST',
                data: { department_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Department deleted successfully!');
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


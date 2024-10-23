            $(document).ready(function () {
                let yearCount = 1;

                $('#addEntry').click(function () {
                    let newEntry = `
                        <tr>
                            <td><input type="text" name="years[${yearCount}][academic_year]" class="form-control" placeholder="Enter Academic Year :" required></td>
                            <td>
                                <select name="years[${yearCount}][type]" class="form-select" required>
                                    <option value="" selected>Select Type</option>
                                    <option value="ODD">Odd</option>
                                    <option value="EVEN">Even</option>
                                    </select>
                            </td>
                            <td>
                                <select name="years[${yearCount}][status]" class="form-select" required>
                                    <option value="" selected>Select Status</option>
                                    <option value="ACTIVE">Active</option>
                                    <option value="INACTIVE">Inactive</option>
                                </select>
                                <td><button class="btn btn-outline-danger mt-1 removeEntry"><i class ="fi fi-rr-trash"></i></button></td>
                            </td>
                        </tr>`;

                    $('#yearEntries').append(newEntry);
                    yearCount++;
                });
                $(document).on('click', '.removeEntry', function () {
                    $(this).closest('tr').remove();
                });
            });
$(function() {
    $('table').on('click', 'button[data-bs-target="#updateYearModal"]', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.academic_year_id').value;
        var name = tr.cells[0].textContent; 
        var type = tr.cells[1].textContent;
        var status = tr.cells[2].textContent;
        $('#editName').val(name);
        $('#editId').val(id);
        $('#editType').val(type);
        $('#editStatus').val(status);
        $('#updateYearModal').data('row', tr);
    });

    $('#updateYearModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            year_id: $('#editId').val(),
            name: $('#editName').val(),
            type: $('#editType').val(),
            status: $('#editStatus').val()
        };

        $.ajax({
            url: '../../php/database_update/update_academic_year.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Academic Year updated successfully!');
                var tr = $('#updateYearModal').data('row');
                tr.cells[0].textContent = formData.name;
                tr.cells[1].textContent = formData.type;
                tr.cells[2].textContent = formData.status;
                $('#updateYearModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-year-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.academic_year_id').value;

        if (confirm('Are you sure you want to delete this Academic Year?')) {
            $.ajax({
                url: '../../php/database_update/update_academic_year.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Academic Year deleted successfully!');
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


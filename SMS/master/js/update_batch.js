            $(document).ready(function () {
                let batchCount = 1;

                // Add new entry
                $('#addEntry').click(function () {
                    let newEntry = `
                        <tr>
                            <td><input type="text" name="batch[${batchCount}][batch_name]" class="form-control" placeholder="Enter Batch :" required></td>
                            <td><input type="text" name="batch[${batchCount}][current_semester]" class="form-control" placeholder="Enter Current Semester :" required></td>
                            <td><button class="btn btn-outline-danger mt-1 removeEntry"><i class ="fi fi-rr-trash"></i></button></td>
                        </tr>`;

                    $('#batchEntries').append(newEntry);
                    batchCount++;
                });
                $(document).on('click', '.removeEntry', function () {
                    $(this).closest('tr').remove();
                });
            });
$(function() {
    $('table').on('click', 'button[data-bs-target="#updateBatchModal"]', function (ele) {
        var tr = ele.target.closest('tr');
        var id = tr.querySelector('input.batch_id').value;
        $('#editId').val(id);
        var name = tr.cells[0].textContent; 
        var current_sem = tr.cells[1].textContent;
        $('#editName').val(name);
        $('#editSemester').val(current_sem);
        $('#updateBatchModal').data('row', tr);
    });

    $('#updateBatchModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            batch_id: $('#editId').val(),          
            batch_name: $('#editName').val(), 
            current_semester: $('#editSemester').val()
        };

        $.ajax({
            url: '../../php/database_update/update_batch.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Batch updated successfully!');
                var tr = $('#updateBatchModal').data('row');
                tr.cells[0].textContent = formData.batch_name;
                tr.cells[1].textContent = formData.current_semester;
                $('#updateBatchModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
   $('table').on('click', '.delete-batch-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.batch_id').value;

        if (confirm('Are you sure you want to delete this batch?')) {
            $.ajax({
                url: '../../php/database_update/update_batch.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Batch deleted successfully!');
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


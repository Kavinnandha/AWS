$(function() {
    $('table').on('click', 'button[data-bs-target="#updateAdvisorModal"]', function (event) {
        var tr = event.target.closest('tr');
        var id = tr.querySelector('input.advisor_mapping_id').value;
        var mapping_id = tr.querySelector('input.mapping_id').value;
        var batch_id = tr.querySelector('input.batch_id').value;
        var user_id = tr.querySelector('input.user_id').value;
        var section_id = tr.querySelector('input.section_id').value;
        $('#editId').val(id);
        $('#editMappingId').val(mapping_id);
        $('#editBatchId').val(batch_id);
        $('#editUserId').val(user_id);
        $('#editSectionId').val(section_id);
        
        $('#updateAdvisorModal').data('row', tr);
    });

    $('#updateAdvisorModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            advisor_mapping_id: $('#editId').val(),
            user_id: $('#editUserId').val(),
            mapping_id: $('#editMappingId').val(), 
            batch_id: $('#editBatchId').val(),
            section_id: $('#editSectionId').val()
        };
        $.ajax({
            url: '../../php/database_update/update_advisor_mapping.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Advisor Mapping Updated successfully!');
                var tr = $('#updateAdvisorModal').data('row');
                tr.cells[0].textContent = $('#editUserId option:selected').text();
                tr.cells[1].textContent = $('#editMappingId option:selected').text();
                tr.cells[2].textContent = $('#editBatchId option:selected').text();
                tr.cells[3].textContent = $('#editSectionId option:selected').text();

                $('#updateAdvisorModal').modal('hide');  
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
   $('table').on('click', '.delete-advisor-mapping-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input.advisor_mapping_id').value;

        if (confirm('Are you sure you want to delete this batch?')) {
            $.ajax({
                url: '../../php/database_update/update_advisor_mapping.php',  
                type: 'POST',
                data: { delete_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Advisor Mapping deleted successfully!');
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


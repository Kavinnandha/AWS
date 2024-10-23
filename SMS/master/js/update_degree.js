$(document).ready(function () {
    let degreeCount = 1;

    $('#addEntry').click(function () {
        let newEntry = `
            <tr>
                <td><input type="text" name="degree[${degreeCount}][programme_name]" class="form-control" placeholder="Enter Programme Name" required></td>
                <td><input type="text" name="degree[${degreeCount}][duration]" class="form-control" placeholder="Enter Duration" required></td>
                <td><input type="number" name="degree[${degreeCount}][no_of_semester]" class="form-control" placeholder="Enter Number of Semesters" required></td>
                <td><button class="btn btn-outline-danger mt-1 removeEntry"><i class="fi fi-rr-trash"></i></button></td>
            </tr>`;

        $('#degreeEntries').append(newEntry);
        degreeCount++;
    });

    $(document).on('click', '.removeEntry', function () {
        $(this).closest('tr').remove();
    });
});


$(function() {
    $('table').on('click', 'button[data-bs-target="#updateDegreeModal"]', function (ele) {
        var tr = ele.target.closest('tr');
        var name = tr.cells[0].textContent;
        var id = tr.querySelector('input[type="hidden"]').value;
        var duration = tr.cells[1].textContent;  
        var semester = tr.cells[2].textContent;
        $('#editName').val(name);
        $('#editId').val(id);
        $('#editDuration').val(duration);
        $('#editSemester').val(semester);
        $('#updateDegreeModal').data('row', tr);
    });

    $('#updateDegreeModal').on('submit', function (event) {
        event.preventDefault();  
        var formData = {
            id: $('#editId').val(),          
            name: $('#editName').val(),  
            duration: $('#editDuration').val(),
            semester: $('#editSemester').val()
        };

        $.ajax({
            url: '../../php/database_update/update_degree.php',        
            type: 'POST',
            data: formData,                  
            success: function(response) {
                alert('Department updated successfully!');
                var tr = $('#updateDegreeModal').data('row');
                tr.cells[0].textContent = formData.name;
                tr.cells[1].textContent = formData.duration;
                tr.cells[2].textContent = formData.semester;
                $('#updateDegreeModal').modal('hide');  
            },
            error: function(xhr, status, error) {var id = tr.querySelector('input[type="hidden"]').value;

                alert('Error: ' + error);
            }
        });
    });

    $('table').on('click', '.delete-degree-button', function (ele) {
        var tr = ele.target.closest('tr');  
        var id = tr.querySelector('input[type="hidden"]').value;

        if (confirm('Are you sure you want to delete this Programme?')) {
            $.ajax({
                url: '../../php/database_update/update_degree.php',  
                type: 'POST',
                data: { degree_id: id },  
                success: function(response) {
                    if (response === 'success') {
                        $(tr).remove();
                        alert('Programme deleted successfully!');
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


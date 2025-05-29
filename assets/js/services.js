// services.js: Handles service menu CRUD

$(function() {
    function showMessage(msg, isError = false) {
        $('#serviceMessage').html(`<div style="color:${isError ? 'red' : 'green'};margin-bottom:10px;">${msg}</div>`);
        setTimeout(() => $('#serviceMessage').html(''), 3000);
    }

   $(function() {
    function loadServices() {
        $.get('/api/services.php', function(data) {
            let html = '';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(service => {
                    html += `<tr>
                        <td data-label="Name">${service.name}</td>
                        <td data-label="Description">${service.description}</td>
                        <td data-label="Price ($)">${service.price}</td>
                        <td data-label="Duration (minutes)">${service.duration_minutes}</td>
                        <td data-label="Actions">
                            <button class="editServiceBtn" data-id="${service.id}" title="Edit"><i class="fa fa-pencil-alt"></i></button>
                            <button class="deleteServiceBtn" data-id="${service.id}" title="Delete"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="5">No services found.</td></tr>';
            }
            $('#servicesTableBody').html(html);
        });
    }

    // Initial load
    loadServices();

    // You can add your add/edit/delete handlers here as before
});

    // Open modal for add
    $('#addServiceBtn').on('click', function() {
        $('#serviceModalTitle').text('Add Service');
        $('#serviceForm')[0].reset();
        $('#serviceId').val('');
        $('#serviceModal').show();
    });

    // Open modal for edit
    $(document).on('click', '.editServiceBtn', function() {
        const id = $(this).data('id');
        $.get('/api/services.php?id=' + id, function(service) {
            $('#serviceModalTitle').text('Edit Service');
            $('#serviceId').val(service.id);
            $('#serviceName').val(service.name);
            $('#serviceDesc').val(service.description);
            $('#servicePrice').val(service.price);
            $('#serviceDuration').val(service.duration);
            $('#serviceModal').show();
        });
    });

    // Save (add/edit) service
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#serviceId').val();
        const payload = {
            name: $('#serviceName').val(),
            description: $('#serviceDesc').val(),
            price: $('#servicePrice').val(),
            duration_minutes: $('#serviceDuration').val() // <-- FIXED
        };
        let method = id ? 'PUT' : 'POST';
        if (id) payload.id = id;

        $.ajax({
            url: '/api/services.php',
            method: method,
            contentType: 'application/json',
            data: JSON.stringify(payload),
            success: function(res) {
                showMessage(res.success ? res.success : 'Saved!');
                $('#serviceModal').hide();
                loadServices();
            },
            error: function(xhr) {
                let msg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error';
                showMessage(msg, true);
            }
        });
    });

    // Delete service
    $(document).on('click', '.deleteServiceBtn', function() {
        if (!confirm('Delete this service?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: '/api/services.php',
            method: 'DELETE',
            contentType: 'application/json',
            data: JSON.stringify({ id }),
            success: function(res) {
                showMessage(res.success ? res.success : 'Deleted!');
                loadServices();
            },
            error: function(xhr) {
                let msg = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error';
                showMessage(msg, true);
            }
        });
    });

    // Close modal
    $('.close-modal').on('click', function() { $('#serviceModal').hide(); });

    // Initial load
    loadServices();
});
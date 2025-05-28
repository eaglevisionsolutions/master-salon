// appointments.js: Handles appointment CRUD via AJAX

$(function() {
    // Load appointments on page load
    function loadAppointments() {
        $.get('api/appointments.php', function(data) {
            // Render your appointments table or calendar here
            // Example:
            let html = "";
            data.forEach(function(app) {
                html += `<tr>
                    <td>${app.scheduled_at}</td>
                    <td>${app.service_id}</td>
                    <td>${app.staff_id}</td>
                    <td>${app.status}</td>
                    <td>
                        <button class="edit-app" data-id="${app.id}">Edit</button>
                        <button class="del-app" data-id="${app.id}">Delete</button>
                    </td>
                </tr>`;
            });
            $("#appointmentsTable tbody").html(html);
        });
    }

    loadAppointments();

    // Add appointment
    $("#addAppointmentForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            staff_id: $("#appStaff").val(),
            service_id: $("#appService").val(),
            scheduled_at: $("#appDateTime").val(),
            notes: $("#appNotes").val(),
            csrf_token: window.CSRF_TOKEN || $("#csrf_token_appointment").val()
        };
        $.ajax({
            url: 'api/appointments.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Appointment booked!');
                loadAppointments();
                $("#addAppointmentForm")[0].reset();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to add appointment');
            }
        });
    });

    // TODO: Add edit and delete handlers if you implement those endpoints
});
// appointments.js: Handles appointment CRUD via AJAX

$(function() {
    // Load appointments on page load (for appointments view/table)
    function loadAppointments() {
        $.get('/api/appointments.php', function(data) {
            let html = "";
            if (Array.isArray(data) && data.length > 0) {
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
            } else {
                html = '<tr><td colspan="5">No appointments found.</td></tr>';
            }
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
            url: '/api/appointments.php',
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

    // For staff/admin: fetch and render calendar appointments
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('calendar')) {
            fetch('/api/appointments/all')
                .then(res => res.json())
                .then(data => {
                    let html = '<ul>';
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(appt => {
                            html += `<li>${appt.date} ${appt.time} - ${appt.customer} (${appt.service})</li>`;
                        });
                    } else {
                        html += '<li>No appointments found.</li>';
                    }
                    html += '</ul>';
                    document.getElementById('calendar').innerHTML = html;
                });
        }

        // --- Dashboard Today's Appointments ---
        if (document.getElementById('todayAppointments')) {
            fetch('/api/appointments.php?dashboard_today=1')
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (Array.isArray(data) && data.length > 0) {
                        html = '<ul>';
                        data.forEach(function(appt) {
                            html += `<li>${appt.scheduled_at ? appt.scheduled_at.substring(11, 16) : ''} - ${appt.service}`;
                            if (appt.customer) {
                                html += ` (Customer: ${appt.customer})`;
                            }
                            html += `</li>`;
                        });
                        html += '</ul>';
                    } else {
                        html = '<div>No appointments to display for today.</div>';
                    }
                    document.getElementById('todayAppointments').innerHTML = html;
                });
        }
    });

    // Optionally, handle reminders via AJAX if you want dynamic updates
    // TODO: Add edit and delete handlers if you implement those endpoints
});
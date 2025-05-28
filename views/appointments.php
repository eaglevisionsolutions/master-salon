<?php
require_once 'templates/header.php';
include 'templates/modals/appointment_modal.php';
?>
<h2>Appointments</h2>
<button onclick="$('#addAppointmentModal').show();">Book Appointment</button>
<table id="appointmentsTable">
    <thead>
        <tr>
            <th>Date & Time</th>
            <th>Service</th>
            <th>Staff</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/appointments.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once 'templates/footer.php';
?>
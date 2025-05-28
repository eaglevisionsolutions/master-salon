<!-- Appointment Modal -->
<div id="addAppointmentModal" class="modal">
    <form id="addAppointmentForm">
        <h3>Book Appointment</h3>
        <label>Staff:</label>
        <select id="appStaff" required></select><br>
        <label>Service:</label>
        <select id="appService" required></select><br>
        <label>Date & Time:</label>
        <input type="datetime-local" id="appDateTime" required><br>
        <label>Notes:</label>
        <textarea id="appNotes"></textarea><br>
        <button type="submit">Book</button>
        <button type="button" class="close-modal">Cancel</button>
    </form>
</div>
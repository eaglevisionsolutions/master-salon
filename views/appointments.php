<?php
require_once 'templates/header.php';
include 'templates/modals/appointment_modal.php';
session_start();
$userRole = $_SESSION['role'] ?? 'guest'; // 'customer', 'staff', 'admin'
?>
<div class="appointments-container">
    <?php if ($userRole === 'customer'): ?>
        <h2>Book an Appointment</h2>
        <form method="POST" action="/appointments/book">
            <label>Date: <input type="date" name="date" required></label>
            <label>Time: <input type="time" name="time" required></label>
            <label>Service:
                <select name="service_id">
                    <?php foreach ($services as $service): ?>
                        <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Book</button>
        </form>

        <h2>Your Appointments</h2>
        <ul>
            <?php foreach ($customerAppointments as $appt): ?>
                <li>
                    <?= htmlspecialchars($appt['date']) ?> at <?= htmlspecialchars($appt['time']) ?> - <?= htmlspecialchars($appt['service']) ?>
                    <form method="POST" action="/appointments/reschedule" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                        <input type="date" name="new_date" required>
                        <input type="time" name="new_time" required>
                        <button type="submit">Reschedule</button>
                    </form>
                    <form method="POST" action="/appointments/cancel" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                        <button type="submit" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($userRole === 'staff' || $userRole === 'admin'): ?>
        <h2>Appointments Calendar</h2>
        <div id="calendar"></div>
        <script>
        // Example: Integrate a JS calendar library like FullCalendar here
        // fetch appointments via AJAX and render
        </script>

        <h2>Reminders</h2>
        <ul>
            <?php foreach ($reminders as $reminder): ?>
                <li>
                    <?= htmlspecialchars($reminder['message']) ?> - <?= htmlspecialchars($reminder['date']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Please log in to manage appointments.</p>
    <?php endif; ?>
</div>
<!-- Add your CSS/JS as needed -->
<script src="assets/js/appointments.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once 'templates/footer.php';
?>
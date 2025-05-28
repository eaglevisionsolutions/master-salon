<?php
require_once 'templates/header.php';
?>
<h2>Reports & Analytics</h2>
<div class="dashboard-cards">
    <div class="card">
        <h3>Today's Sales</h3>
        <div id="todaySales">Loading...</div>
    </div>
    <div class="card">
        <h3>Today's Appointments</h3>
        <div id="todayAppointments">Loading...</div>
    </div>
    <div class="card">
        <h3>Staff Performance</h3>
        <ul id="staffPerformance"></ul>
    </div>
</div>
<script src="assets/js/reports.js"></script>
<?php
require_once 'templates/footer.php';
?>
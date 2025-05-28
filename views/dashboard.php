<?php
require_once 'templates/header.php';
?>
<h2>Dashboard</h2>
<p>Welcome, <?= $_SESSION['full_name'] ?? 'User' ?>!</p>
<div class="dashboard-cards">
    <div class="card">
        <h3>Today's Appointments</h3>
        <div id="todayAppointments">Loading...</div>
    </div>
    <div class="card">
        <h3>Sales Today</h3>
        <div id="todaySales">Loading...</div>
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
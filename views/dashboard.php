<?php
require_once __DIR__ . '/../templates/header.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$role = $_SESSION['role'] ?? '';
?>
<h2>Dashboard</h2>
<p>Welcome, <span id="userFullName">Loading...</span>!</p>
<div class="dashboard-cards">
    <div class="card">
        <h3>Today's Appointments</h3>
        <div id="todayAppointments">
            Loading...
        </div>
    </div>
    <?php if ($role === 'staff' || $role === 'admin'): ?>
        <div class="card">
            <h3>Sales Today</h3>
            <div id="todaySales">Loading...</div>
        </div>
        <div class="card">
            <h3>Staff Performance</h3>
            <ul id="staffPerformance"></ul>
        </div>
    <?php endif; ?>
</div>
<script>
    window.USER_ROLE = "<?= $role ?>";
</script>
<script src="/assets/js/users.js"></script>
<script src="/assets/js/reports.js"></script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
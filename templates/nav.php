<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? '';
?>
<nav>
    <ul>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="appointments.php">Appointments</a></li>
            <li><a href="staff.php">Staff</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="pos.php">POS</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="promotions.php">Promotions</a></li>
            <li><a href="reviews.php">Reviews</a></li>
            <?php if ($role === 'admin'): ?>
                <li><a href="users.php">Users</a></li>
            <?php endif; ?>
            <li><a href="#" id="logoutBtn">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
<script>
$(function() {
    $('#logoutBtn').on('click', function(e) {
        e.preventDefault();
        $.get('api/logout.php', function() {
            window.location.href = 'login.php';
        });
    });
});
</script>
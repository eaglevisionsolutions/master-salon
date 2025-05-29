<!-- Sidebar -->
<div class="sidebar">
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="appointments.php"><i class="fa fa-calendar"></i> Appointments</a></li>
                <?php if ($userRole === 'staff' || $userRole === 'admin'): ?>
                    <li><a href="staff.php"><i class="fa fa-users"></i> Staff</a></li>
                    <li><a href="customers.php"><i class="fa fa-user-friends"></i> Customers</a></li>
                    <li><a href="services.php"><i class="fa fa-scissors"></i> Services</a></li>
                    <li><a href="inventory.php"><i class="fa fa-boxes"></i> Inventory</a></li>
                    <li><a href="pos.php"><i class="fa fa-cash-register"></i> POS</a></li>
                    <li><a href="reports.php"><i class="fa fa-chart-bar"></i> Reports</a></li>
                    <li><a href="promotions.php"><i class="fa fa-bullhorn"></i> Promotions</a></li>
                    <li><a href="users.php"><i class="fa fa-id-badge"></i> Users</a></li>
                <?php endif; ?>
                <li><a href="reviews.php"><i class="fa fa-star"></i> Reviews</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<!-- End of Sidebar -->
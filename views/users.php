<?php
require_once __DIR__ . '/../templates/header.php';
include 'templates/modals/user_modal.php';
?>
<h2>User Management</h2>
<table id="usersTable">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/users.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
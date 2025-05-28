<?php
require_once __DIR__ . '/../templates/header.php';
include 'templates/modals/customer_modal.php';
?>
<h2>Customers</h2>
<table id="customersTable">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Username</th>
            <th>Loyalty Points</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/customers.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
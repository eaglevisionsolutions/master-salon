<?php
require_once 'templates/header.php';
include 'templates/modals/staff_modal.php';
?>
<h2>Staff</h2>
<table id="staffTable">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Username</th>
            <th>Bio</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/staff.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once 'templates/footer.php';
?>
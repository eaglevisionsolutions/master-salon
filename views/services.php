<?php
require_once __DIR__ . '/../templates/header.php';
include 'templates/modals/service_modal.php';
?>
<h2>Services Menu</h2>
<button onclick="$('#addServiceModal').show();">Add Service</button>
<table id="servicesTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price ($)</th>
            <th>Duration</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/services.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
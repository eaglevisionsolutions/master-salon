<?php
require_once 'templates/header.php';
include 'templates/modals/inventory_modal.php';
?>
<h2>Inventory</h2>
<button onclick="$('#addInventoryModal').show();">Add Product</button>
<table id="inventoryTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Quantity (oz)</th>
            <th>Bulk Price</th>
            <th>Price per oz</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/inventory.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once 'templates/footer.php';
?>
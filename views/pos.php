<?php
require_once __DIR__ . '/../templates/header.php';
include 'templates/modals/pos_modal.php';
?>
<h2>Point of Sale (POS)</h2>
<button onclick="$('#posModal').show();">New Transaction</button>
<!-- You can add a sales history table here if desired -->
<script src="assets/js/pos.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
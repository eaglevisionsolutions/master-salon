<?php
require_once __DIR__ . '/../templates/header.php';
include 'templates/modals/promotion_modal.php';
?>
<h2>Promotions & Gift Cards</h2>
<button onclick="$('#addPromotionModal').show();">Add Promotion/Gift Card</button>
<table id="promotionsTable">
    <thead>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th>Type</th>
            <th>Value</th>
            <th>Valid</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/promotions.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
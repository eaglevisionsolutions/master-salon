<?php
require_once 'templates/header.php';
include 'templates/modals/review_modal.php';
?>
<h2>Customer Reviews</h2>
<button onclick="$('#addReviewModal').show();">Leave a Review</button>
<table id="reviewsTable">
    <thead>
        <tr>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
      <!-- Filled by JS -->
    </tbody>
</table>
<script src="assets/js/reviews.js"></script>
<script>
$('.close-modal').on('click', function() { $(this).closest('.modal').hide(); });
</script>
<?php
require_once 'templates/footer.php';
?>
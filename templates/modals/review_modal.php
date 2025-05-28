<!-- Review Modal -->
<div id="addReviewModal" class="modal">
    <form id="addReviewForm">
        <h3>Leave a Review</h3>
        <label>Appointment ID:</label>
        <input type="number" id="revAppointmentId" required><br>
        <label>Staff ID:</label>
        <input type="number" id="revStaffId" required><br>
        <label>Rating (1-5):</label>
        <input type="number" id="revRating" min="1" max="5" required><br>
        <label>Comment:</label>
        <textarea id="revComment"></textarea><br>
        <button type="submit">Submit</button>
        <button type="button" class="close-modal">Cancel</button>
    </form>
</div>
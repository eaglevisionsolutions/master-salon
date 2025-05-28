<!-- Promotion Modal -->
<div id="addPromotionModal" class="modal">
    <form id="addPromotionForm">
        <h3>Add Promotion / Gift Card</h3>
        <label>Code:</label>
        <input type="text" id="promoCode" required><br>
        <label>Description:</label>
        <textarea id="promoDesc"></textarea><br>
        <label>Discount Type:</label>
        <select id="promoType">
            <option value="percent">Percent</option>
            <option value="amount">Amount</option>
        </select><br>
        <label>Discount Value:</label>
        <input type="number" id="promoValue" min="0" step="0.01" required><br>
        <label>Valid From:</label>
        <input type="date" id="promoFrom" required><br>
        <label>Valid To:</label>
        <input type="date" id="promoTo" required><br>
        <button type="submit">Add Promotion</button>
        <button type="button" class="close-modal">Cancel</button>
    </form>
</div>
<!-- POS Modal -->
<div id="posModal" class="modal">
    <form id="posForm">
        <h3>Point of Sale</h3>
        <label>Appointment ID:</label>
        <input type="number" id="posAppointmentId" required><br>
        <label>Customer ID:</label>
        <input type="number" id="posCustomerId" required><br>
        <label>Staff ID:</label>
        <input type="number" id="posStaffId" required><br>
        <label>Inventory Product:</label>
        <input type="number" id="posInventoryId" required><br>
        <label>Scoops Used (oz):</label>
        <input type="number" id="posScoops" min="0" step="0.01" required><br>
        <label>Product Price per oz ($):</label>
        <input type="number" id="posProductPricePerOz" min="0" step="0.0001" required><br>
        <label>Service Duration (minutes):</label>
        <input type="number" id="posServiceDuration" min="1" required><br>
        <label>Staff Hourly Rate ($):</label>
        <input type="number" id="posHourlyRate" min="0" step="0.01" required><br>
        <label>Payment Method:</label>
        <select id="posPaymentMethod">
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="gift_card">Gift Card</option>
        </select><br>
        <label>Product Cost ($):</label>
        <input type="text" id="posProductCost" readonly><br>
        <label>Suggested Price ($):</label>
        <input type="text" id="posSuggestedPrice" readonly><br>
        <button type="submit">Complete Sale</button>
        <button type="button" class="close-modal">Cancel</button>
    </form>
</div>
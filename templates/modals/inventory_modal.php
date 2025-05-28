<!-- Inventory Modal -->
<div id="addInventoryModal" class="modal">
    <form id="addInventoryForm">
        <h3>Add Inventory Product</h3>
        <label>Name:</label>
        <input type="text" id="invName" required><br>
        <label>Type:</label>
        <input type="text" id="invType" required><br>
        <label>Quantity (oz):</label>
        <input type="number" id="invQty" min="0" step="0.01" required><br>
        <label>Bulk Price ($):</label>
        <input type="number" id="invBulkPrice" min="0" step="0.01" required><br>
        <label>Bulk Size (oz):</label>
        <input type="number" id="invBulkSize" min="1" required><br>
        <label>Low Stock Threshold (oz):</label>
        <input type="number" id="invLowStock" min="0" step="0.01"><br>
        <button type="submit">Add Product</button>
        <button type="button" class="close-modal">Cancel</button>
    </form>
</div>
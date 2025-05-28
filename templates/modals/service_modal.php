<!-- Service Modal -->
<div id="addServiceModal" class="modal">
    <form id="addServiceForm">
        <h3>Add Service</h3>
        <label>Name:</label>
        <input type="text" id="svcName" required><br>
        <label>Description:</label>
        <textarea id="svcDescription"></textarea><br>
        <label>Price:</label>
        <input type="number" id="svcPrice" min="0" step="0.01" required><br>
        <label>Duration (minutes):</label>
        <input type="number" id="svcDuration" min="1" required><br>
        <button type="submit">Add Service</button>
        <button type="button" class="close-modal">Cancel</button>
    </form>
</div>
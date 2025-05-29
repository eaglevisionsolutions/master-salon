<?php
require_once __DIR__ . '/../templates/header.php';
include __DIR__ . '/../templates/modals/service_modal.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<h2>Services Menu</h2>
<div id="serviceMessage"></div>
<table id="servicesTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price ($)</th>
            <th>Duration</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="servicesTableBody">
      <!-- Filled by JS -->
    </tbody>
</table>
<button id="addServiceBtn">Add Service</button>
<!-- Add/Edit Service Modal -->
<div id="serviceModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-modal" style="float:right;cursor:pointer;">&times;</span>
        <h3 id="serviceModalTitle">Add Service</h3>
        <form id="serviceForm">
            <input type="hidden" id="serviceId" name="id">
            <label>Name: <input type="text" id="serviceName" name="name" required></label><br>
            <label>Description: <input type="text" id="serviceDesc" name="description"></label><br>
            <label>Price ($): <input type="number" id="servicePrice" name="price" step="0.01" required></label><br>
            <label>Duration (minutes): <input type="number" id="serviceDuration" name="duration" required></label><br>
            <button type="submit" id="serviceSaveBtn">Save</button>
        </form>
    </div>
</div>

<script src="/assets/js/services.js"></script>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>
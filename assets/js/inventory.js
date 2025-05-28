// inventory.js: Handles inventory management, including bulk/scoop logic

$(function() {
    function loadInventory() {
        $.get('api/inventory.php', function(data) {
            let html = "";
            data.forEach(function(prod) {
                html += `<tr>
                    <td>${prod.product_name}</td>
                    <td>${prod.product_type}</td>
                    <td>${prod.quantity} oz</td>
                    <td>$${Number(prod.bulk_price).toFixed(2)} / ${prod.bulk_size} oz</td>
                    <td>$${Number(prod.price_per_ounce).toFixed(4)} per oz</td>
                    <td>
                        <button class="edit-inv" data-id="${prod.id}">Edit</button>
                    </td>
                </tr>`;
            });
            $("#inventoryTable tbody").html(html);
        });
    }

    loadInventory();

    // Add product (admin)
    $("#addInventoryForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            product_name: $("#invName").val(),
            product_type: $("#invType").val(),
            quantity: $("#invQty").val(),
            bulk_price: $("#invBulkPrice").val(),
            bulk_size: $("#invBulkSize").val(),
            low_stock_threshold: $("#invLowStock").val()
        };
        $.ajax({
            url: 'api/inventory.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Product added!');
                loadInventory();
                $("#addInventoryForm")[0].reset();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to add product');
            }
        });
    });
});
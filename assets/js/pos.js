// pos.js: Handles checkout, product use, and price calculation

$(function() {
    // Calculate total cost for POS form
    function calculatePrice() {
        let scoops = parseFloat($("#posScoops").val()) || 0;
        let hourly = parseFloat($("#posHourlyRate").val()) || 0;
        let duration = parseFloat($("#posServiceDuration").val()) || 0;
        let pricePerOunce = parseFloat($("#posProductPricePerOz").val()) || 0;

        let productCost = scoops * pricePerOunce;
        let serviceCost = (hourly / 60) * duration;
        let suggested = productCost + serviceCost;

        $("#posProductCost").val(productCost.toFixed(2));
        $("#posSuggestedPrice").val(suggested.toFixed(2));
    }

    $("#posScoops, #posHourlyRate, #posServiceDuration, #posProductPricePerOz").on("input", calculatePrice);

    $("#posForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            appointment_id: $("#posAppointmentId").val(),
            customer_id: $("#posCustomerId").val(),
            staff_id: $("#posStaffId").val(),
            products: [{
                inventory_id: $("#posInventoryId").val(),
                scoops_used: $("#posScoops").val()
            }],
            payment_method: $("#posPaymentMethod").val(),
            hourly_rate: $("#posHourlyRate").val()
        };
        $.ajax({
            url: 'api/pos.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(res) {
                alert('Transaction complete! Suggested charge: $' + res.suggested_price.toFixed(2));
                // Optionally refresh sales report or clear POS form
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Checkout failed');
            }
        });
    });
});
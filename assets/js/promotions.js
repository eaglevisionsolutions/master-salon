// promotions.js: Handles promotions and gift cards CRUD

$(function() {
    function loadPromotions() {
        $.get('api/promotions.php', function(data) {
            let html = "";
            data.forEach(function(promo) {
                html += `<tr>
                    <td>${promo.code}</td>
                    <td>${promo.description}</td>
                    <td>${promo.discount_type}</td>
                    <td>${promo.discount_value}</td>
                    <td>${promo.valid_from} - ${promo.valid_to}</td>
                </tr>`;
            });
            $("#promotionsTable tbody").html(html);
        });
    }

    loadPromotions();

    // Admin: Add promotion
    $("#addPromotionForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            code: $("#promoCode").val(),
            description: $("#promoDesc").val(),
            discount_type: $("#promoType").val(),
            discount_value: $("#promoValue").val(),
            valid_from: $("#promoFrom").val(),
            valid_to: $("#promoTo").val()
        };
        $.ajax({
            url: 'api/promotions.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Promotion added!');
                loadPromotions();
                $("#addPromotionForm")[0].reset();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to add promotion');
            }
        });
    });
});
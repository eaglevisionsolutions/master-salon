// services.js: Handles service menu CRUD

$(function() {
    function loadServices() {
        $.get('api/services.php', function(data) {
            let html = "";
            data.forEach(function(svc) {
                html += `<tr>
                    <td>${svc.name}</td>
                    <td>${svc.description}</td>
                    <td>${svc.price}</td>
                    <td>${svc.duration_minutes} min</td>
                </tr>`;
            });
            $("#servicesTable tbody").html(html);
        });
    }

    loadServices();

    // Admin: Add service
    $("#addServiceForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            name: $("#svcName").val(),
            description: $("#svcDescription").val(),
            price: $("#svcPrice").val(),
            duration_minutes: $("#svcDuration").val()
        };
        $.ajax({
            url: 'api/services.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Service added!');
                loadServices();
                $("#addServiceForm")[0].reset();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to add service');
            }
        });
    });
});
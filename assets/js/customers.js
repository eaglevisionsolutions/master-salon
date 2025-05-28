// customers.js: Handles customer listing and loyalty management

$(function() {
    function loadCustomers() {
        $.get('api/customers.php', function(data) {
            let html = "";
            data.forEach(function(cust) {
                html += `<tr>
                    <td>${cust.full_name}</td>
                    <td>${cust.username}</td>
                    <td>${cust.loyalty_points || 0}</td>
                    <td>
                        <button class="edit-cust" data-id="${cust.id}">Edit</button>
                    </td>
                </tr>`;
            });
            $("#customersTable tbody").html(html);
        });
    }

    loadCustomers();

    // Edit loyalty points (admin)
    $(document).on('click', '.edit-cust', function() {
        const id = $(this).data("id");
        $("#editCustomerModal").data("user-id", id).modal('show');
    });

    $("#editCustomerForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            user_id: $("#editCustomerModal").data("user-id"),
            loyalty_points: $("#custLoyaltyPoints").val()
        };
        $.ajax({
            url: 'api/customers.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Customer updated!');
                loadCustomers();
                $("#editCustomerModal").modal('hide');
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to update customer');
            }
        });
    });
});
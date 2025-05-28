// staff.js: Handles staff listing and profile editing via AJAX

$(function() {
    function loadStaff() {
        $.get('api/staff.php', function(data) {
            let html = "";
            data.forEach(function(staff) {
                html += `<tr>
                    <td>${staff.full_name}</td>
                    <td>${staff.username}</td>
                    <td>${staff.bio || ''}</td>
                    <td>
                        <img src="${staff.photo || 'assets/images/default-avatar.png'}" width="40"/>
                    </td>
                    <td>
                        <button class="edit-staff" data-id="${staff.id}">Edit</button>
                    </td>
                </tr>`;
            });
            $("#staffTable tbody").html(html);
        });
    }

    loadStaff();

    // Example: Edit staff (admin only)
    $(document).on('click', '.edit-staff', function() {
        const id = $(this).data("id");
        // Prefill modal, show, then on form submit:
        $("#editStaffModal").data("user-id", id).modal('show');
    });

    $("#editStaffForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            user_id: $("#editStaffModal").data("user-id"),
            bio: $("#staffBio").val(),
            photo: $("#staffPhoto").val()
        };
        $.ajax({
            url: 'api/staff.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('Staff updated!');
                loadStaff();
                $("#editStaffModal").modal('hide');
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to update staff');
            }
        });
    });
});
// users.js: Admin user management (roles, profile edits)
$(function() {
    // Fetch and display the user's full name
    $.get('/api/users.php?me=1', function(data) {
        if (data && data.full_name) {
            $('#userFullName').text(data.full_name);
        } else {
            $('#userFullName').text('User');
        }
    }).fail(function() {
        $('#userFullName').text('User');
    });

    function loadUsers() {
        $.get('/api/users.php', function(data) {
            let html = "";
            data.forEach(function(user) {
                html += `<tr>
                    <td>${user.full_name}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>
                        <button class="edit-user" data-id="${user.id}">Edit Role</button>
                    </td>
                </tr>`;
            });
            $("#usersTable tbody").html(html);
        });
    }
    loadUsers();

    $(document).on('click', '.edit-user', function() {
        const id = $(this).data("id");
        $("#editUserModal").data("user-id", id).modal('show');
    });

    $("#editUserForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            user_id: $("#editUserModal").data("user-id"),
            role: $("#userRole").val()
        };
        $.ajax({
            url: '/api/users.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('User updated!');
                loadUsers();
                $("#editUserModal").modal('hide');
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to update user');
            }
        });
    });
});

$(function() {
    function updateTopbarUser() {
        $.get('/api/user.php?me=1', function(data) {
            if (data && data.full_name) {
                $('#userFullName').text(data.full_name);
            }
            if (data && data.profile_pic) {
                $('#userProfilePic').attr('src', data.profile_pic);
            }
        });
    }

    // Call on page load
    updateTopbarUser();

    function loadUsers() {
        $.get('/api/users.php', function(data) {
            let html = "";
            data.forEach(function(user) {
                html += `<tr>
                    <td>${user.full_name}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>
                        <button class="edit-user" data-id="${user.id}">Edit Role</button>
                    </td>
                </tr>`;
            });
            $("#usersTable tbody").html(html);
        });
    }
    loadUsers();

    // After a successful user update, also update the topbar if the current user was edited
    $("#editUserForm").on("submit", function(e) {
        e.preventDefault();
        const data = {
            user_id: $("#editUserModal").data("user-id"),
            role: $("#userRole").val()
        };
        $.ajax({
            url: '/api/users.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function() {
                alert('User updated!');
                loadUsers();
                $("#editUserModal").modal('hide');
                updateTopbarUser(); // Refresh topbar info
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || 'Failed to update user');
            }
        });
    });
});
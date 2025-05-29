$(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        // Remove any previous error message
        $('#loginForm .form-error').remove();

        $.ajax({
            url: 'api/login.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: $('#loginUsername').val(),
                password: $('#loginPassword').val(),
                csrf_token: window.CSRF_TOKEN || $('#csrf_token').val()
            }),
            success: function(res) {
                alert('Logged in as ' + res.role);
                window.location.href = 'index.php';
            },
            error: function(xhr) {
                let msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Login failed';
                // Show error above the form's submit button
                $('#loginForm').prepend('<div class="form-error" style="color:red;margin-bottom:10px;">' + msg + '</div>');
            }
        });
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $('#registerForm .form-error').remove();

        $.ajax({
            url: 'api/register.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                username: $('#regUsername').val(),
                password: $('#regPassword').val(),
                email: $('#regEmail').val(),
                full_name: $('#regFullName').val(),
                csrf_token: window.CSRF_TOKEN || $('#csrf_token').val()
            }),
            success: function(res) {
                alert('Registration successful!');
                window.location.href = 'login.php';
            },
            error: function(xhr) {
                let msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Registration failed';
                $('#registerForm').prepend('<div class="form-error" style="color:red;margin-bottom:10px;">' + msg + '</div>');
            }
        });
    });

    // Handle logout
    $('#logoutBtn').on('click', function(e) {
        e.preventDefault();
        $.get('/api/logout.php', function() {
            window.location.href = '/login.php';
        });
    });
});
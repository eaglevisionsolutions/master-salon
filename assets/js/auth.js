$(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
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
                alert(xhr.responseJSON.error || 'Login failed');
            }
        });
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
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
                alert(xhr.responseJSON.error || 'Registration failed');
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
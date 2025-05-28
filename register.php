<?php
session_start();
require_once 'includes/csrf.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require_once 'templates/header.php';
$csrf_token = generate_csrf_token();
?>
<h2>Register</h2>
<form id="registerForm">
    <input type="text" id="regUsername" name="username" placeholder="Username" required><br>
    <input type="password" id="regPassword" name="password" placeholder="Password" required><br>
    <input type="email" id="regEmail" name="email" placeholder="Email" required><br>
    <input type="text" id="regFullName" name="full_name" placeholder="Full Name" required><br>
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_token ?>">
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login</a></p>
<script>
window.CSRF_TOKEN = "<?= $csrf_token ?>";
</script>
<script src="assets/js/auth.js"></script>
<?php require_once 'templates/footer.php'; ?>
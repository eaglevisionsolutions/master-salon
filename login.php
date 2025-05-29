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
<h2>Login</h2>
<div class="formContainer">
    <p>Please enter your username and password to log in.</p>
    <form id="loginForm">
        <div id="loginError"></div> <!-- Error message will be injected here -->
        <input type="text" id="loginUsername" name="username" placeholder="Username" required><br>
        <input type="password" id="loginPassword" name="password" placeholder="Password" required><br>
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_token ?>">
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>
<script>
window.CSRF_TOKEN = "<?= $csrf_token ?>";
</script>
<script src="assets/js/auth.js"></script>
<?php require_once 'templates/footer.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!-- Topbar -->
<nav class="topbar">
    <h1 class="app-title"><?= defined('APP_NAME') ? APP_NAME : "SalonWare" ?></h1>
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="user-profile">
        <img id="userProfilePic" src="<?= htmlspecialchars($_SESSION['profile_pic'] ?? '/assets/img/default-profile.png') ?>" alt="Profile" class="profile-pic">
        <span class="profile-name" id="userFullName"><?= htmlspecialchars($_SESSION['full_name'] ?? 'User') ?></span>
        <div class="profile-dropdown">
            <a id="logoutBtn" href="#">Logout</a>
            
        </div>
    </div>
    <?php else: ?>
    <div class="guest-actions">
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="register.php" class="btn btn-secondary">Register</a>
    <?php endif; ?>
</nav>
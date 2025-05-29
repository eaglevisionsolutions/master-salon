<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$userRole = $_SESSION['role'] ?? 'guest'; // 'customer', 'staff', 'admin'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= defined('APP_NAME') ? APP_NAME : "SalonWare" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include 'nav.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="container">

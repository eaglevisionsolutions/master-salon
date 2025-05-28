<?php
header('Content-Type: application/json');
require_once '../includes/auth.php';
session_destroy();
echo json_encode(['success' => true]);
?>
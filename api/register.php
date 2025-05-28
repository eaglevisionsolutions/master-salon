<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/csrf.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!validate_csrf_token($data['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}
$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';
$email    = trim($data['email'] ?? '');
$full_name = trim($data['full_name'] ?? '');
if (!$username || !$password || !$email || !$full_name) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->execute([$username, $email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'Username or email already taken']);
    exit;
}
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email, full_name, role) VALUES (?, ?, ?, ?, 'customer')");
$stmt->execute([$username, $hash, $email, $full_name]);
echo json_encode(['success' => true]);
?>
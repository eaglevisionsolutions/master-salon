<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if (current_user_role() !== 'admin') {
    http_response_code(403);
    echo json_encode(['error'=>'Forbidden']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT id, username, full_name, role, email FROM users");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['user_id'] ?? null;
    $role = $data['role'] ?? 'customer';
    if ($user_id) {
        $stmt = $pdo->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->execute([$role, $user_id]);
        echo json_encode(['success'=>true]);
        exit;
    }
}
?>
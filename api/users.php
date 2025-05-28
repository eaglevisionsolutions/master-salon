<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();

// Add this block before the admin check to allow all logged-in users to get their own info
if (isset($_GET['me'])) {
    $user_id = current_user_id();
    $stmt = $pdo->prepare("SELECT id, full_name, email, role FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
    exit;
}

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
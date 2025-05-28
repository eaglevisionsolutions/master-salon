<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT u.id, u.username, u.full_name, c.loyalty_points FROM users u LEFT JOIN customers c ON u.id=c.user_id WHERE u.role='customer'");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_role() === 'admin') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['user_id'] ?? null;
    $loyalty_points = $data['loyalty_points'] ?? 0;
    if ($user_id) {
        $stmt = $pdo->prepare("UPDATE customers SET loyalty_points=? WHERE user_id=?");
        $stmt->execute([$loyalty_points, $user_id]);
    } else {
        http_response_code(400);
        echo json_encode(['error'=>'Missing user_id']);
    }
    echo json_encode(['success'=>true]);
    exit;
}
?>
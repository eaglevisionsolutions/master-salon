<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT * FROM promotions WHERE active=1");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_role() === 'admin') {
    $data = json_decode(file_get_contents('php://input'), true);
    $code = $data['code'] ?? '';
    $desc = $data['description'] ?? '';
    $type = $data['discount_type'] ?? 'amount';
    $value = $data['discount_value'] ?? 0;
    $valid_from = $data['valid_from'] ?? date('Y-m-d H:i:s');
    $valid_to = $data['valid_to'] ?? date('Y-m-d H:i:s', strtotime('+1 month'));
    $stmt = $pdo->prepare("INSERT INTO promotions (code, description, discount_type, discount_value, active, valid_from, valid_to) VALUES (?,?,?,?,1,?,?)");
    $stmt->execute([$code, $desc, $type, $value, $valid_from, $valid_to]);
    echo json_encode(['success'=>true]);
    exit;
}
?>
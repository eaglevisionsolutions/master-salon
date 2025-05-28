<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT * FROM services WHERE active=1");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_role() === 'admin') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'] ?? '';
    $description = $data['description'] ?? '';
    $price = $data['price'] ?? 0;
    $duration = $data['duration_minutes'] ?? 30;
    $stmt = $pdo->prepare("INSERT INTO services (name, description, price, duration_minutes, active) VALUES (?,?,?,?,1)");
    $stmt->execute([$name, $description, $price, $duration]);
    echo json_encode(['success'=>true]);
    exit;
}
?>
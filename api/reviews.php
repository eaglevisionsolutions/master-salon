<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 50");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $appointment_id = $data['appointment_id'] ?? null;
    $customer_id = current_user_id();
    $staff_id = $data['staff_id'] ?? null;
    $rating = $data['rating'] ?? 5;
    $comment = $data['comment'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO reviews (appointment_id, customer_id, staff_id, rating, comment) VALUES (?,?,?,?,?)");
    $stmt->execute([$appointment_id, $customer_id, $staff_id, $rating, $comment]);
    echo json_encode(['success'=>true]);
    exit;
}
?>
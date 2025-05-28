<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT *, (bulk_price/bulk_size) AS price_per_ounce FROM inventory");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_role() === 'admin') {
    $data = json_decode(file_get_contents('php://input'), true);
    $product_name = $data['product_name'] ?? '';
    $product_type = $data['product_type'] ?? '';
    $quantity = $data['quantity'] ?? 0;
    $bulk_price = $data['bulk_price'] ?? 0;
    $bulk_size = $data['bulk_size'] ?? 1;
    $low_stock = $data['low_stock_threshold'] ?? 0;
    $stmt = $pdo->prepare("INSERT INTO inventory (product_name, product_type, quantity, bulk_price, bulk_size, low_stock_threshold) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$product_name, $product_type, $quantity, $bulk_price, $bulk_size, $low_stock]);
    echo json_encode(['success'=>true]);
    exit;
}
?>
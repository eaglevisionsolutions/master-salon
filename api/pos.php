<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $appointment_id = $data['appointment_id'] ?? null;
    $customer_id = $data['customer_id'] ?? null;
    $staff_id = $data['staff_id'] ?? null;
    $products = $data['products'] ?? []; // [{inventory_id, scoops_used}]
    $payment_method = $data['payment_method'] ?? 'cash';
    $hourly_rate = $data['hourly_rate'] ?? 0;

    // Calculate product cost
    $total_product_cost = 0;
    foreach ($products as $p) {
        $inv = $pdo->prepare("SELECT bulk_price, bulk_size FROM inventory WHERE id=?");
        $inv->execute([$p['inventory_id']]);
        $row = $inv->fetch();
        $cost_per_ounce = $row ? ($row['bulk_price']/$row['bulk_size']) : 0;
        $total_product_cost += $cost_per_ounce * $p['scoops_used'];
    }

    // Calculate suggested price
    // Assume service duration is fetched from appointment->service_id
    $stmt = $pdo->prepare("SELECT service_id FROM appointments WHERE id=?");
    $stmt->execute([$appointment_id]);
    $service_id = $stmt->fetchColumn();
    $duration = 60;
    if ($service_id) {
        $sdur = $pdo->prepare("SELECT duration_minutes FROM services WHERE id=?");
        $sdur->execute([$service_id]);
        $duration = $sdur->fetchColumn();
    }
    $service_cost = ($hourly_rate / 60) * $duration;
    $suggested_price = $service_cost + $total_product_cost;

    // Save transaction
    $stmt = $pdo->prepare("INSERT INTO transactions (appointment_id, customer_id, staff_id, total_amount, payment_method) VALUES (?,?,?,?,?)");
    $stmt->execute([$appointment_id, $customer_id, $staff_id, $suggested_price, $payment_method]);
    $transaction_id = $pdo->lastInsertId();
    foreach ($products as $p) {
        $inv = $pdo->prepare("SELECT bulk_price, bulk_size FROM inventory WHERE id=?");
        $inv->execute([$p['inventory_id']]);
        $row = $inv->fetch();
        $cost_per_ounce = $row ? ($row['bulk_price']/$row['bulk_size']) : 0;
        $cost = $cost_per_ounce * $p['scoops_used'];
        $stmt = $pdo->prepare("INSERT INTO transaction_products (transaction_id, inventory_id, scoops_used, product_cost) VALUES (?,?,?,?)");
        $stmt->execute([$transaction_id, $p['inventory_id'], $p['scoops_used'], $cost]);
    }
    echo json_encode(['suggested_price'=>$suggested_price, 'success'=>true]);
    exit;
}
?>
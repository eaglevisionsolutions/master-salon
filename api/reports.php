<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();

$role = current_user_role();
$today = date('Y-m-d');
$response = [];

// Today's appointments count
if ($role === 'staff' || $role === 'admin') {
    $stmt = $pdo->prepare("SELECT COUNT(*) as num_appointments FROM appointments WHERE DATE(scheduled_at) = ?");
    $stmt->execute([$today]);
    $response['appointments'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['num_appointments' => 0];

    // Sales Today
    $stmt = $pdo->prepare("SELECT SUM(amount) as total_sales FROM transactions WHERE DATE(created_at) = ?");
    $stmt->execute([$today]);
    $response['sales'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['total_sales' => 0];

    // Staff Performance
    $stmt = $pdo->prepare(
        "SELECT u.id as staff_id, u.name as staff_name, COUNT(a.id) as num_appointments
         FROM users u
         LEFT JOIN appointments a ON a.staff_id = u.id AND DATE(a.scheduled_at) = ? AND a.status = 'completed'
         WHERE u.role = 'staff'
         GROUP BY u.id, u.name"
    );
    $stmt->execute([$today]);
    $response['staff_performance'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Customer: only their own appointments
    $user_id = current_user_id();
    $stmt = $pdo->prepare("SELECT COUNT(*) as num_appointments FROM appointments WHERE customer_id = ? AND DATE(scheduled_at) = ?");
    $stmt->execute([$user_id, $today]);
    $response['appointments'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['num_appointments' => 0];
}

echo json_encode($response);
?>
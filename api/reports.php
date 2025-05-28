<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if (current_user_role() !== 'admin' && current_user_role() !== 'staff') {
    http_response_code(403);
    echo json_encode(['error'=>'Forbidden']);
    exit;
}
$sales = $pdo->query("SELECT COUNT(*) as num_sales, SUM(total_amount) as total_sales FROM transactions WHERE created_at >= CURDATE()")->fetch();
$appointments = $pdo->query("SELECT COUNT(*) as num_appointments FROM appointments WHERE scheduled_at >= CURDATE()")->fetch();
$staff_perf = $pdo->query("SELECT staff_id, COUNT(*) as num_appointments FROM appointments WHERE scheduled_at >= CURDATE() GROUP BY staff_id")->fetchAll();
echo json_encode(['sales'=>$sales, 'appointments'=>$appointments, 'staff_performance'=>$staff_perf]);
?>
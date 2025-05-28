<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/csrf.php';
require_login();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Fetch for user or all for admin/staff
    $user_id = current_user_id();
    $role = current_user_role();
    if ($role === 'admin' || $role === 'staff') {
        $stmt = $pdo->query("SELECT * FROM appointments ORDER BY scheduled_at DESC LIMIT 50");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE customer_id=? ORDER BY scheduled_at DESC LIMIT 50");
        $stmt->execute([$user_id]);
    }
    $appointments = $stmt->fetchAll();
    echo json_encode($appointments);
    exit;
}

if ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!validate_csrf_token($data['csrf_token'] ?? '')) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
    $customer_id = current_user_id();
    $staff_id = $data['staff_id'] ?? null;
    $service_id = $data['service_id'] ?? null;
    $scheduled_at = $data['scheduled_at'] ?? null;
    $notes = $data['notes'] ?? '';
    if (!$staff_id || !$service_id || !$scheduled_at) {
        http_response_code(400);
        echo json_encode(['error'=>'Missing fields']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO appointments (customer_id, staff_id, service_id, scheduled_at, notes) VALUES (?,?,?,?,?)");
    $stmt->execute([$customer_id, $staff_id, $service_id, $scheduled_at, $notes]);
    echo json_encode(['success'=>true]);
    exit;
}

if ($method == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!validate_csrf_token($data['csrf_token'] ?? '')) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
    $appointment_id = $data['id'] ?? null;
    $staff_id = $data['staff_id'] ?? null;
    $service_id = $data['service_id'] ?? null;
    $scheduled_at = $data['scheduled_at'] ?? null;
    $notes = $data['notes'] ?? '';
    
    if (!$appointment_id || !$staff_id || !$service_id || !$scheduled_at) {
        http_response_code(400);
        echo json_encode(['error'=>'Missing fields']);
        exit;
    }
    
    $stmt = $pdo->prepare("UPDATE appointments SET staff_id=?, service_id=?, scheduled_at=?, notes=? WHERE id=?");
    $stmt->execute([$staff_id, $service_id, $scheduled_at, $notes, $appointment_id]);
    echo json_encode(['success'=>true]);
    exit;
}

if ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!validate_csrf_token($_DELETE['csrf_token'] ?? '')) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
    
    $appointment_id = $_DELETE['id'] ?? null;
    
    if (!$appointment_id) {
        http_response_code(400);
        echo json_encode(['error'=>'Missing appointment ID']);
        exit;
    }
    
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id=?");
    $stmt->execute([$appointment_id]);
    echo json_encode(['success'=>true]);
    exit;
}

http_response_code(405);
echo json_encode(['error'=>'Method not allowed']);
?>
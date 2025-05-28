<?php
header('Content-Type: application/json');
require_once '../templates/modals/appointment_modal.php'; // Adjust path if needed
require_login();

$user_id = current_user_id();
$role = current_user_role();
$today = date('Y-m-d');

// Dashboard today's appointments
if (isset($_GET['dashboard_today'])) {
    $appointments = AppointmentModel::getTodaysAppointments($role, $user_id, $today);
    echo json_encode($appointments);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $appointments = AppointmentModel::getAllAppointments($role, $user_id);
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
    $staff_id = $data['staff_id'] ?? null;
    $service_id = $data['service_id'] ?? null;
    $scheduled_at = $data['scheduled_at'] ?? null;
    $notes = $data['notes'] ?? '';
    if (!$staff_id || !$service_id || !$scheduled_at) {
        http_response_code(400);
        echo json_encode(['error'=>'Missing fields']);
        exit;
    }
    $success = AppointmentModel::createAppointment($user_id, $staff_id, $service_id, $scheduled_at, $notes);
    echo json_encode(['success' => $success]);
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
    $success = AppointmentModel::updateAppointment($role, $appointment_id, $staff_id, $service_id, $scheduled_at, $notes, $user_id);
    echo json_encode(['success' => $success]);
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
    $success = AppointmentModel::deleteAppointment($role, $appointment_id, $user_id);
    echo json_encode(['success' => $success]);
    exit;
}

http_response_code(405);
echo json_encode(['error'=>'Method not allowed']);
?>
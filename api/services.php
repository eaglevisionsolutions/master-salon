<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../templates/modals/service_modal.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $service = ServiceModel::getById($_GET['id']);
        if ($service) {
            echo json_encode($service);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Service not found']);
        }
        exit;
    }
    echo json_encode(ServiceModel::getAll());
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data['name'] || !$data['price'] || !$data['duration_minutes']) {
        http_response_code(400);
        echo json_encode(['error' => 'Name, price, and duration required']);
        exit;
    }
    $success = ServiceModel::add($data['name'], $data['description'] ?? '', $data['price'], $data['duration_minutes']);
    echo json_encode(['success' => $success ? 'Service added.' : 'Failed to add service.']);
    exit;
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data['id'] || !$data['name'] || !$data['price'] || !$data['duration_minutes']) {
        http_response_code(400);
        echo json_encode(['error' => 'ID, name, price, and duration required']);
        exit;
    }
    $success = ServiceModel::edit($data['id'], $data['name'], $data['description'] ?? '', $data['price'], $data['duration_minutes']);
    echo json_encode(['success' => $success ? 'Service updated.' : 'Failed to update service.']);
    exit;
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data['id']) {
        http_response_code(400);
        echo json_encode(['error' => 'ID required']);
        exit;
    }
    $success = ServiceModel::remove($data['id']);
    echo json_encode(['success' => $success ? 'Service deleted.' : 'Failed to delete service.']);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
?>
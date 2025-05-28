<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT u.id, u.username, u.full_name, s.bio, s.photo FROM users u LEFT JOIN staff_profiles s ON u.id=s.user_id WHERE u.role='staff'");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_role() === 'admin') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['user_id'] ?? null;
    $bio = $data['bio'] ?? '';
    $photo = $data['photo'] ?? null;
    if ($user_id) {
        $stmt = $pdo->prepare("UPDATE staff_profiles SET bio=?, photo=? WHERE user_id=?");
        $stmt->execute([$bio, $photo, $user_id]);
    } else {
        http_response_code(400);
        echo json_encode(['error'=>'Missing user_id']);
    }
    echo json_encode(['success'=>true]);
    exit;
}
?>
<?php
header('Content-Type: application/json');

// Add this at the top to include DB connection if not already present
if (!isset($pdo)) {
    require_once __DIR__ . '/../includes/db.php';
    require_once __DIR__ . '/../includes/auth.php'; // <-- Handles session_start()
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

// --- ADD: Endpoint for fetching current user's info asynchronously ---
if (isset($_GET['me']) && $_GET['me'] == '1') {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT full_name, profile_pic FROM users WHERE id = ?");
    if ($stmt->execute([$user_id])) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo json_encode([
                'full_name' => $user['full_name'] ?? 'User',
                'profile_pic' => $user['profile_pic'] ?? '/assets/img/default-profile.png'
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
    exit;
}
// --- END ADD ---

if (current_user_role() !== 'admin') {
    http_response_code(403);
    echo json_encode(['error'=>'Forbidden']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $pdo->query("SELECT id, username, full_name, role, email FROM users");
    echo json_encode($stmt->fetchAll());
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['user_id'] ?? null;
    $role = $data['role'] ?? 'customer';
    if ($user_id) {
        $stmt = $pdo->prepare("UPDATE users SET role=? WHERE id=?");
        $stmt->execute([$role, $user_id]);
        echo json_encode(['success'=>true]);
        exit;
    }
}
?>
<?php
// Database connection file
$host = 'localhost';
$db   = 'hairbynatalie_msapp';
$user = 'hairbynatalie_msapp_admin';
$pass = 'j&GFG]RIef}Q';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset", 
        $user, $pass, $options
    );
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// ADD THIS FUNCTION:
function getDb() {
    global $pdo;
    return $pdo;
}
?>
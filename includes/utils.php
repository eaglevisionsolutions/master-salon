<?php
// Common utility functions

function respond_json($data, $http_code = 200) {
    http_response_code($http_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sanitize($value) {
    // Basic sanitization for string input
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function format_date($date_str, $format = 'Y-m-d H:i:s') {
    $date = new DateTime($date_str);
    return $date->format($format);
}
?>
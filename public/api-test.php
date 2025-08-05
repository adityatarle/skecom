<?php
// Simple API test file to verify routes are working
header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'API test file is accessible',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'laravel_version' => app()->version() ?? 'Unknown'
]);
<?php

require_once __DIR__ . '/../core/admin_client.php';

header('Content-Type: application/json; charset=utf-8');

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Invalid admin access path']);
    exit;
}

adminClientStartSession();
if (!adminClientIsAuthenticated()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Authentication required']);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$file = $_FILES['image'] ?? null;
$storedPath = adminClientMoveUploadedFile($file, 'image');
if ($storedPath === null) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Image upload failed']);
    exit;
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/coffee-shop/admin-client/media_upload.php';
$basePath = rtrim(str_replace('\\', '/', dirname(dirname($scriptName))), '/');
$siteUrl = $scheme . $host . ($basePath !== '' ? $basePath . '/' : '/');

http_response_code(200);
echo json_encode([
    'success' => true,
    'path' => $storedPath,
    'url' => $siteUrl . ltrim($storedPath, '/'),
    'name' => basename($storedPath),
]);
exit;
?>

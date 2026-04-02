<?php

require_once __DIR__ . '/../core/admin_client.php';
require_once __DIR__ . '/../core/entities.php';

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$section = trim((string) ($_GET['section'] ?? ''));
$entityId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    exit('Invalid admin access path');
}

adminClientStartSession();
if (!adminClientIsAuthenticated()) {
    header('Location: login.php');
    exit;
}

if ($entityId > 0) {
    deleteEntityAttributeDataByEntityId($entityId);
    deleteEntity($entityId);
}

$redirectUrl = 'index.php';
if ($section !== '') {
    $redirectUrl .= '?section=' . urlencode($section);
}

header('Location: ' . $redirectUrl);
exit;
?>

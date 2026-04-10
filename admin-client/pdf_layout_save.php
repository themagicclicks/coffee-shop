<?php
require_once __DIR__ . '/../core/admin_client.php';

$configFile = __DIR__ . '/../config/admin_client.json';
$config = loadAdminClientConfig($configFile);
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'message' => 'Invalid admin access path']);
    exit;
}

adminClientStartSession();
if (!adminClientIsAuthenticated()) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'message' => 'Authentication required']);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['ok' => false, 'message' => 'Invalid request method']);
    exit;
}

$html = (string) ($_POST['html'] ?? '');
$saved = adminClientSaveFormattedMenuPdfHtml($html);

header('Content-Type: application/json');
echo json_encode([
    'ok' => $saved,
    'message' => $saved ? 'PDF layout saved successfully.' : 'PDF layout could not be saved.',
    'html' => $saved ? adminClientLoadFormattedMenuPdfHtml() : '',
]);
exit;
?>

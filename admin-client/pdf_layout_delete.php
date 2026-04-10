<?php
require_once __DIR__ . '/../core/admin_client.php';
require_once __DIR__ . '/../core/env.php';

loadEnv(__DIR__ . '/../.env');
define('BASE', $_ENV['BASE']);
define('SITE', $_ENV['SITE']);
require_once BASE . 'includes/functions.php';

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

$deleted = adminClientDeleteFormattedMenuPdfHtml();

$menuPdfSections = getPrintableMenuSections();
ob_start();
include BASE . 'includes/menu-template.php';
$templateHtml = ob_get_clean();
$templateHtml = str_replace(
    'class="menu-pdf-source"',
    'class="menu-pdf-source" style="position: relative; left: 0; top: 0; width: 210mm; color: #2b211a; padding: 0; opacity: 1; pointer-events: none; z-index: -1;"',
    $templateHtml
);

header('Content-Type: application/json');
echo json_encode([
    'ok' => $deleted,
    'message' => $deleted ? 'Saved PDF layout deleted. Dynamic template restored.' : 'Saved PDF layout could not be deleted.',
    'html' => $templateHtml,
]);
exit;
?>

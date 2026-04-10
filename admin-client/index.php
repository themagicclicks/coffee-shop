<?php
require_once __DIR__ . '/../core/env.php';
loadEnv(__DIR__ . '/../.env');

define('BASE', $_ENV['BASE']);
define('SITE', $_ENV['SITE']);
require_once __DIR__ . '/../core/admin_client.php';

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$appTitle = 'Client Admin';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$requestedPage = isset($_GET['page']) ? strtolower(trim((string) $_GET['page'])) : 'dashboard';
$currentSection = isset($_GET['section']) ? trim((string) $_GET['section']) : '';

$routes = [
    'dashboard' => [
        'file' => __DIR__ . '/dashboard.php',
        'title' => 'Dashboard',
    ],
    'settings' => [
        'file' => __DIR__ . '/settings.php',
        'title' => 'Settings',
    ],
    'navigation' => [
        'file' => __DIR__ . '/navigation.php',
        'title' => 'Navigation',
    ],
    'orders' => [
        'file' => __DIR__ . '/orders.php',
        'title' => 'Orders',
    ],
    'pdf-layout' => [
        'file' => __DIR__ . '/pdf_layout.php',
        'title' => 'PDF Layout',
    ],
];

$currentPage = array_key_exists($requestedPage, $routes) ? $requestedPage : 'dashboard';
$pageFile = $routes[$currentPage]['file'];
$pageTitle = $routes[$currentPage]['title'];
$pageStyles = '';
$pageBodyClass = '';

if ($currentSection !== '') {
    $pageFile = __DIR__ . '/section.php';
    $sectionMenuItem = adminClientFindMenuItemByEntityType($config['menu'], $currentSection);
    $pageTitle = $sectionMenuItem['label'] ?? 'Section';
}

if ($currentPage === 'pdf-layout') {
    $activeThemeName = htmlspecialchars((string) ($config['theme_name'] ?? 'dark-coffee'), ENT_QUOTES, 'UTF-8');
    $pageBodyClass = 'admin-pdf-layout-page';
    $pageStyles .= '<link rel="stylesheet" href="../themes/' . $activeThemeName . '/css/styles.css">';
    $pageStyles .= '<style>'
        . 'body.admin-pdf-layout-page{font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif !important;}'
        . 'body.admin-pdf-layout-page .admin-shell,'
        . 'body.admin-pdf-layout-page .admin-sidebar,'
        . 'body.admin-pdf-layout-page .admin-main,'
        . 'body.admin-pdf-layout-page .admin-content,'
        . 'body.admin-pdf-layout-page .admin-card,'
        . 'body.admin-pdf-layout-page .admin-card h1,'
        . 'body.admin-pdf-layout-page .admin-card h2,'
        . 'body.admin-pdf-layout-page .admin-card h3,'
        . 'body.admin-pdf-layout-page .admin-card h4,'
        . 'body.admin-pdf-layout-page .admin-card h5,'
        . 'body.admin-pdf-layout-page .admin-card h6,'
        . 'body.admin-pdf-layout-page .admin-card p,'
        . 'body.admin-pdf-layout-page .admin-card .btn,'
        . 'body.admin-pdf-layout-page .admin-card .btn-flat,'
        . 'body.admin-pdf-layout-page .admin-card .helper-note,'
        . 'body.admin-pdf-layout-page .admin-pdf-toolbar,'
        . 'body.admin-pdf-layout-page .admin-pdf-toolbar *{font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif !important;}'
        . '</style>';
}

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invalid admin access path</title>
        <link rel="stylesheet" href="../css/materialize.min.css">
    </head>
    <body class="amber lighten-5">
        <div class="container" style="padding-top: 80px; max-width: 680px;">
            <div class="card-panel white">
                <h4>Invalid admin access path</h4>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

adminClientStartSession();

if (isset($_GET['logout']) && $_GET['logout'] === '1') {
    adminClientLogout();
    header('Location: login.php');
    exit;
}

if (!adminClientIsAuthenticated()) {
    header('Location: login.php');
    exit;
}

include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/sidebar.php';
include $pageFile;
include __DIR__ . '/partials/footer.php';

?>

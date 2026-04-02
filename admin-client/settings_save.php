<?php

require_once __DIR__ . '/../core/admin_client.php';

$configFile = __DIR__ . '/../config/admin_client.json';
$config = loadAdminClientConfig($configFile);
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    exit('Invalid admin access path');
}

adminClientStartSession();
if (!adminClientIsAuthenticated()) {
    header('Location: login.php');
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: index.php?page=settings');
    exit;
}

$themesDir = dirname(__DIR__) . '/themes';
$availableThemes = [];
if (is_dir($themesDir)) {
    foreach (scandir($themesDir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        if (is_dir($themesDir . '/' . $entry)) {
            $availableThemes[] = $entry;
        }
    }
}

$adminPath = adminClientSanitizePath($_POST['admin_path'] ?? $config['admin_path']);
$adminEmail = adminClientNormalizeEmail($_POST['admin_email'] ?? $config['admin_email']);
$frontendFormEmail = adminClientNormalizeEmail($_POST['frontend_form_email'] ?? ($config['frontend_form_email'] ?? ''));
$themeName = adminClientNormalizeThemeName($_POST['theme_name'] ?? ($config['theme_name'] ?? 'dark-coffee'));
$siteTitle = adminClientNormalizeText($_POST['site_title'] ?? ($config['site_title'] ?? ''));
$metaDescription = adminClientNormalizeText($_POST['meta_description'] ?? ($config['meta_description'] ?? ''));
$metaKeywords = adminClientNormalizeText($_POST['meta_keywords'] ?? ($config['meta_keywords'] ?? ''));
$metaAuthor = adminClientNormalizeText($_POST['meta_author'] ?? ($config['meta_author'] ?? ''));
$ogTitle = adminClientNormalizeText($_POST['og_title'] ?? ($config['og_title'] ?? ''));
$ogDescription = adminClientNormalizeText($_POST['og_description'] ?? ($config['og_description'] ?? ''));
$ogUrl = adminClientNormalizeText($_POST['og_url'] ?? ($config['og_url'] ?? ''));

if ($adminEmail === '' || !filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
    adminClientSetFlash('Please enter a valid registered admin email.', 'error');
    header('Location: index.php?page=settings');
    exit;
}

if ($frontendFormEmail !== '' && !filter_var($frontendFormEmail, FILTER_VALIDATE_EMAIL)) {
    adminClientSetFlash('Please enter a valid frontend form submission email.', 'error');
    header('Location: index.php?page=settings');
    exit;
}

if (!empty($availableThemes) && !in_array($themeName, $availableThemes, true)) {
    adminClientSetFlash('Please choose a valid frontend theme.', 'error');
    header('Location: index.php?page=settings');
    exit;
}

if ($ogUrl !== '' && !filter_var($ogUrl, FILTER_VALIDATE_URL)) {
    adminClientSetFlash('Please enter a valid Open Graph URL.', 'error');
    header('Location: index.php?page=settings');
    exit;
}

$saved = adminClientSaveConfig($configFile, [
    'admin_path' => $adminPath,
    'admin_email' => $adminEmail,
    'frontend_form_email' => $frontendFormEmail,
    'theme_name' => $themeName,
    'site_title' => $siteTitle,
    'meta_description' => $metaDescription,
    'meta_keywords' => $metaKeywords,
    'meta_author' => $metaAuthor,
    'og_title' => $ogTitle,
    'og_description' => $ogDescription,
    'og_url' => $ogUrl,
    'two_step_email_otp_enabled' => !empty($config['two_step_email_otp_enabled']),
]);

if (!$saved) {
    adminClientSetFlash('Settings could not be saved.', 'error');
    header('Location: index.php?page=settings');
    exit;
}

adminClientSetFlash('Settings saved successfully. A backup copy of the previous JSON was kept.', 'success');
header('Location: index.php?page=settings');
exit;
?>

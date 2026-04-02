<?php
require_once __DIR__ . '/../core/admin_client.php';
$configFile = __DIR__ . '/../config/admin_client.json';
$config = loadAdminClientConfig($configFile);
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) { http_response_code(404); exit('Invalid admin access path'); }
adminClientStartSession();
if (!adminClientIsAuthenticated()) { header('Location: login.php'); exit; }
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Location: index.php?page=navigation'); exit; }
$posted = $_POST['navigation'] ?? [];
$sections = ['top_nav', 'open_menu'];
$normalized = ['top_nav' => [], 'open_menu' => []];
foreach ($sections as $section) {
    $sectionRows = is_array($posted[$section] ?? null) ? $posted[$section] : [];
    $names = $sectionRows['name'] ?? [];
    $labels = $sectionRows['label'] ?? [];
    $hrefs = $sectionRows['href'] ?? [];
    $targets = $sectionRows['target'] ?? [];
    $count = max(count($names), count($labels), count($hrefs), count($targets));
    for ($i = 0; $i < $count; $i++) {
        $label = trim((string) ($labels[$i] ?? ''));
        $href = trim((string) ($hrefs[$i] ?? ''));
        $name = adminClientFriendlyName($names[$i] ?? $label);
        $target = trim((string) ($targets[$i] ?? '_top'));
        $target = in_array($target, ['_blank', '_top'], true) ? $target : '_top';
        if ($label === '' || $href === '') { continue; }
        $normalized[$section][] = [
            'name' => $name !== '' ? $name : adminClientFriendlyName($label),
            'label' => $label,
            'href' => $href,
            'target' => $target,
        ];
    }
}
$saved = adminClientSaveConfig($configFile, ['frontend_navigation' => $normalized]);
adminClientSetFlash($saved ? 'Navigation saved successfully.' : 'Navigation could not be saved.', $saved ? 'success' : 'error');
header('Location: index.php?page=navigation');
exit;
?>

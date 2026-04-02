<?php

require_once __DIR__ . '/../core/admin_client.php';
require_once __DIR__ . '/../core/entity_form.php';

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$appTitle = 'Client Admin';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$currentSection = isset($_GET['section']) ? trim((string) $_GET['section']) : '';
$requestedId = isset($_GET['id']) && $_GET['id'] !== '' ? (int) $_GET['id'] : 0;
$entityId = $requestedId > 0 ? $requestedId : null;
$menuItem = $currentSection !== '' ? adminClientFindMenuItemByEntityType($config['menu'], $currentSection) : null;
$pageTitle = ($entityId ? 'Edit ' : 'Add ') . ($menuItem['label'] ?? 'Content');
$previewUrl = '';
$pageStyles = '<link rel="stylesheet" href="https://unpkg.com/pell/dist/pell.min.css">';
$pageScripts = '<script src="https://unpkg.com/pell"></script>';

if ($entityId) {
    $entityRows = getEntity($entityId);
    if (!empty($entityRows) && !empty($currentSection)) {
        $previewUrl = '../index.php?entitytype=' . urlencode($currentSection) . '&entityname=' . urlencode((string) ($entityRows[0]['name'] ?? ''));
    }
}

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Invalid admin access path</title><link rel="stylesheet" href="../css/materialize.min.css"></head><body class="amber lighten-5"><div class="container" style="padding-top: 80px; max-width: 680px;"><div class="card-panel white"><h4>Invalid admin access path</h4></div></div></body></html>';
    exit;
}

adminClientStartSession();
if (!adminClientIsAuthenticated()) {
    header('Location: login.php');
    exit;
}

$flash = adminClientConsumeFlash();

include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/sidebar.php';
?>
<section class="admin-content admin-entity-form">
    <?php if (!empty($flash['message'])) { ?>
        <div class="card-panel <?php echo ($flash['type'] ?? 'success') === 'error' ? 'red lighten-4 red-text text-darken-4' : 'green lighten-4 green-text text-darken-4'; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php } ?>
    <form id="admin-entity-form" method="post" action="entity_save.php?section=<?php echo urlencode($currentSection); ?>" enctype="multipart/form-data">
        <div class="admin-entity-shell">
            <div class="admin-card admin-entity-hero">
                <div class="admin-entity-hero__meta">
                    <div class="card-label"><?php echo $entityId ? 'Edit' : 'Create'; ?></div>
                    <h4><?php echo htmlspecialchars($pageTitle); ?></h4>
                    <p class="helper-note">The left panel is reserved for the main content experience, while the right panel keeps your structured fields visible as you work.</p>
                </div>
                <?php if ($previewUrl !== '') { ?>
                    <a href="<?php echo htmlspecialchars($previewUrl); ?>" target="_blank" class="btn-flat" style="margin-top: 4px; color: #6f5846;">Preview</a>
                <?php } ?>
            </div>

            <?php echo renderEntityForm($currentSection, $entityId); ?>
        </div>

        <div class="admin-cms-actions">
            <?php if ($previewUrl !== '') { ?>
                <a href="<?php echo htmlspecialchars($previewUrl); ?>" target="_blank" class="btn-flat">Preview</a>
            <?php } ?>
            <button type="submit" class="btn brown admin-save-button" form="admin-entity-form">Save</button>
        </div>
    </form>
</section>
<?php
include __DIR__ . '/partials/footer.php';
?>

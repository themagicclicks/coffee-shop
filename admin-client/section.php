<?php
if (!defined('SITE')) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/coffee-shop/admin-client/index.php';
    $basePath = rtrim(str_replace('\\', '/', dirname(dirname($scriptName))), '/');
    define('SITE', $scheme . $host . ($basePath !== '' ? $basePath . '/' : '/'));
}

function adminClientSanitizePreviewHtml($html) {
    $html = (string) $html;
    $html = preg_replace('/<(script|style|iframe|object|embed)[^>]*>.*?<\/\\1>/is', '', $html);
    $html = preg_replace('/\son[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    $html = preg_replace('/\s(href|src)\s*=\s*("|\')\s*javascript:[^\2]*\2/i', ' $1="#"', $html);
    return trim($html);
}

function adminClientTruncateText($text, $limit = 120) {
    $text = trim(preg_replace('/\s+/', ' ', (string) $text));
    if ($text === '') {
        return '';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, $limit - 1)) . '...';
    }

    if (strlen($text) <= $limit) {
        return $text;
    }

    return rtrim(substr($text, 0, $limit - 1)) . '...';
}

function adminClientRenderHtmlPreviewValue($value) {
    $safeHtml = adminClientSanitizePreviewHtml($value);
    $plainText = adminClientTruncateText(strip_tags($safeHtml), 120);

    if ($plainText === '') {
        $plainText = '[HTML content]';
    }

    return '<div class="admin-html-preview">'
        . '<div class="admin-html-preview__text">' . htmlspecialchars($plainText) . '</div>'
        . '<div class="admin-html-preview__hover"><div class="admin-html-preview__canvas">' . $safeHtml . '</div></div>'
        . '</div>';
}

function adminClientRenderSectionValue($columnName, $value) {
    $value = (string) $value;
    $trimmedValue = trim($value);

    if ($trimmedValue === '') {
        return '';
    }

    if (in_array($columnName, ['is_featured', 'is_current_home'], true) && strtolower($trimmedValue) === 'on') {
        return '<i class="material-icons green-text text-darken-2">check_circle</i>';
    }

    if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $trimmedValue)) {
        $imageUrl = SITE . ltrim($trimmedValue, '/');
        return '<img src="' . htmlspecialchars($imageUrl) . '" alt="Thumbnail" style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #ddd;display:block;">';
    }

    if ($trimmedValue !== strip_tags($trimmedValue)) {
        return adminClientRenderHtmlPreviewValue($trimmedValue);
    }

    return htmlspecialchars($trimmedValue);
}

$menuItem = adminClientFindMenuItemByEntityType($config['menu'], $currentSection);
$pageTitle = $menuItem['label'] ?? 'Section';
$entityTypeRows = getEntityTypeByName($currentSection);
$entityTypeRow = !empty($entityTypeRows) ? $entityTypeRows[0] : null;
$entities = [];
$attributeDefinitions = [];
$attributeLabels = $menuItem['attribute_labels'] ?? [];
$sectionMessage = '';

if (!$menuItem) {
    $sectionMessage = 'This section is not configured in admin_client.json.';
} elseif (!$entityTypeRow) {
    $sectionMessage = 'No matching content type was found for this section yet.';
} else {
    $entities = getEntitiesByTypeId((int) $entityTypeRow['id']);
    $attributeDefinitions = getAttributesByEntityType((int) $entityTypeRow['id']);

    if (empty($entities)) {
        $sectionMessage = 'No records found for this section.';
    }
}

$columns = [];
foreach ($attributeDefinitions as $attributeDefinition) {
    $attributeName = $attributeDefinition['attribute_name'];
    $columns[] = [
        'name' => $attributeName,
        'label' => $attributeLabels[$attributeName] ?? ucwords(str_replace(['_', '-'], ' ', $attributeName)),
    ];
}
?>
<section class="admin-content">
    <div class="admin-card row">
        <div class="col s10">
            <div class="card-label">Listing</div>
            <h4 style="margin-top: 0;"><?php echo htmlspecialchars($pageTitle); ?></h4>
            <p class="helper-note">Showing items for <strong><?php echo htmlspecialchars($currentSection); ?></strong>.</p>
        </div>
        <div class="col s2">
            <a href="entity_edit.php?section=<?php echo urlencode($currentSection); ?>&id=0" class="btn-small green right">Add</a>
        </div>
    </div>

    <div class="admin-card">
        <?php if ($sectionMessage !== '') { ?>
            <p><?php echo htmlspecialchars($sectionMessage); ?></p>
        <?php } else { ?>
            <table class="striped highlight responsive-table admin-section-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <?php foreach ($columns as $column) { ?>
                            <th><?php echo htmlspecialchars($column['label']); ?></th>
                        <?php } ?>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entities as $entity) { ?>
                        <?php $attributeValues = getEntityAttributeValues($entity['id']); ?>
                        <?php $attributeMap = []; foreach ($attributeValues as $attributeValue) { $attributeMap[$attributeValue['name']] = $attributeValue['value']; } ?>
                        <?php $editUrl = 'entity_edit.php?section=' . urlencode($currentSection) . '&id=' . urlencode((string) $entity['id']); ?>
                        <?php $deleteUrl = 'entity_delete.php?section=' . urlencode($currentSection) . '&id=' . urlencode((string) $entity['id']); ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entity['name']); ?></td>
                            <?php foreach ($columns as $column) { ?>
                                <td><?php echo adminClientRenderSectionValue($column['name'], $attributeMap[$column['name']] ?? ''); ?></td>
                            <?php } ?>
                            <td><?php echo htmlspecialchars((string) ($entity['created_at'] ?? '')); ?></td>
                            <td class="admin-actions-cell">
                                <a href="<?php echo htmlspecialchars($editUrl); ?>" class="btn-small brown">Edit</a>
                                <a href="<?php echo htmlspecialchars($deleteUrl); ?>" class="btn-small red admin-delete-link" data-entity-name="<?php echo htmlspecialchars($entity['name']); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</section>




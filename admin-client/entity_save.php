<?php

require_once __DIR__ . '/../core/admin_client.php';
require_once __DIR__ . '/../core/entities.php';

function adminClientRedirectToEdit($section, $entityId) {
    header('Location: entity_edit.php?section=' . urlencode($section) . '&id=' . urlencode((string) $entityId));
    exit;
}

function adminClientNormalizeEntityName($name) {
    $name = strtolower(trim((string) $name));
    $name = preg_replace('/[^a-z0-9\-]+/', '-', $name);
    $name = trim((string) $name, '-');
    return $name !== '' ? $name : 'untitled-' . time();
}

function adminClientUploadFieldForAttribute($files, $attributeId) {
    if (!isset($files['name'][$attributeId])) {
        return null;
    }

    return [
        'name' => $files['name'][$attributeId] ?? '',
        'type' => $files['type'][$attributeId] ?? '',
        'tmp_name' => $files['tmp_name'][$attributeId] ?? '',
        'error' => $files['error'][$attributeId] ?? UPLOAD_ERR_NO_FILE,
        'size' => $files['size'][$attributeId] ?? 0,
    ];
}

function adminClientMoveUploadedAttribute($file, $typeName) {
    return adminClientMoveUploadedFile($file, $typeName);
}

function adminClientTruthyValue($value) {
    $value = strtolower(trim((string) $value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

function adminClientStripEditorOnlyHtmlAttributes($value) {
    $value = (string) $value;
    if (stripos($value, '<') === false) {
        return $value;
    }

    $value = preg_replace('/\sdisabled(?:="[^"]*")?/i', '', $value);
    $value = preg_replace('/\stabindex="[^"]*"/i', '', $value);
    $value = preg_replace('/\saria-hidden="[^"]*"/i', '', $value);
    $value = preg_replace('/\scontenteditable="[^"]*"/i', '', $value);
    $value = preg_replace('/\sspellcheck="[^"]*"/i', '', $value);
    return $value;
}

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$section = trim((string) ($_GET['section'] ?? $_POST['entity_type_name'] ?? ''));
$postedEntityId = isset($_POST['entity_id']) ? (int) $_POST['entity_id'] : 0;
$entityId = $postedEntityId > 0 ? $postedEntityId : 0;

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
    header('Location: index.php');
    exit;
}

$entityTypeRows = getEntityTypeByName($section);
$entityType = !empty($entityTypeRows) ? $entityTypeRows[0] : null;
if (!$entityType) {
    header('Location: index.php');
    exit;
}

$entityTypeId = (int) ($entityType['id'] ?? 0);
$entityName = adminClientNormalizeEntityName($_POST['entity_name'] ?? '');

if ($entityId > 0) {
    $existingEntityRows = getEntity($entityId);
    $existingEntity = !empty($existingEntityRows) ? $existingEntityRows[0] : null;
    if (!$existingEntity || (int) ($existingEntity['entity_type_id'] ?? 0) !== $entityTypeId) {
        header('Location: index.php?section=' . urlencode($section));
        exit;
    }

    updateEntity($entityId, $entityName);
} else {
    $entityId = (int) createEntity($entityName, $entityTypeId);
}

$attributes = getAttributesByEntityType($entityTypeId);
$postedAttributes = $_POST['attr'] ?? [];
$uploadedAttributes = $_FILES['attr'] ?? [];
$currentHomeAttributeId = 0;
$currentHomeSelected = false;

foreach ($attributes as $attribute) {
    $attributeId = (int) ($attribute['attribute_id'] ?? 0);
    $attributeName = strtolower(trim((string) ($attribute['attribute_name'] ?? '')));
    $typeName = strtolower(trim((string) ($attribute['type_name'] ?? '')));

    if ($attributeId <= 0) {
        continue;
    }

    if ($section === 'home-page' && $attributeName === 'is_current_home') {
        $currentHomeAttributeId = $attributeId;
    }

    if (in_array($typeName, ['image', 'video', 'pdf', 'file', 'photo gallery photo'], true)) {
        $uploadedFile = adminClientUploadFieldForAttribute($uploadedAttributes, $attributeId);
        $uploadedPath = adminClientMoveUploadedAttribute($uploadedFile, $typeName);
        if ($uploadedPath !== null) {
            setEntityAttributeValue($entityId, $attributeId, $uploadedPath);
        }
        continue;
    }

    $hasValue = isset($postedAttributes[$attributeId]) || isset($postedAttributes[(string) $attributeId]);
    if (!$hasValue && $typeName !== 'checkbox') {
        continue;
    }

    $value = $hasValue ? $postedAttributes[$attributeId] ?? $postedAttributes[(string) $attributeId] : '';
    if (is_array($value)) {
        $value = json_encode($value);
    }

    $value = adminClientStripEditorOnlyHtmlAttributes((string) $value);
    if ($section === 'home-page' && $attributeName === 'is_current_home') {
        $currentHomeSelected = adminClientTruthyValue($value);
    }

    setEntityAttributeValue($entityId, $attributeId, $value);
}

if ($section === 'home-page' && $currentHomeAttributeId > 0 && $currentHomeSelected) {
    clearTruthyAttributeFromOtherEntities($entityTypeId, $currentHomeAttributeId, $entityId);
    setEntityAttributeValue($entityId, $currentHomeAttributeId, 'on');
}

adminClientSetFlash($postedEntityId > 0 ? 'Content saved successfully.' : 'Content created successfully.', 'success');
adminClientRedirectToEdit($section, $entityId);
?>

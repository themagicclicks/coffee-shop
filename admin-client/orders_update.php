<?php

require_once __DIR__ . '/../core/admin_client.php';
require_once __DIR__ . '/../core/entities.php';

function adminClientOrdersRedirect($date) {
    $redirectUrl = 'index.php?page=orders';
    if ($date !== '') {
        $redirectUrl .= '&date=' . urlencode($date);
    }
    header('Location: ' . $redirectUrl);
    exit;
}

function adminClientOrderUpdateTruthy($value) {
    $value = strtolower(trim((string) $value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$selectedDate = trim((string) ($_POST['date'] ?? ''));

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
    adminClientOrdersRedirect($selectedDate);
}

$orderId = isset($_POST['order_id']) ? (int) $_POST['order_id'] : 0;
$action = trim((string) ($_POST['action'] ?? ''));

if ($orderId <= 0 || $action === '') {
    adminClientSetFlash('Invalid order action.', 'error');
    adminClientOrdersRedirect($selectedDate);
}

$orderRows = getEntity($orderId);
$orderTypeRows = getEntityTypeByName('orders');
$orderTypeId = !empty($orderTypeRows) ? (int) ($orderTypeRows[0]['id'] ?? 0) : 0;

if (empty($orderRows) || $orderTypeId <= 0 || (int) ($orderRows[0]['entity_type_id'] ?? 0) !== $orderTypeId) {
    adminClientSetFlash('Order not found.', 'error');
    adminClientOrdersRedirect($selectedDate);
}

$attributes = getAttributesByEntityType($orderTypeId);
$attributeIds = [];
foreach ($attributes as $attribute) {
    $attributeName = trim((string) ($attribute['attribute_name'] ?? ''));
    $attributeId = (int) ($attribute['attribute_id'] ?? 0);
    if ($attributeName !== '' && $attributeId > 0) {
        $attributeIds[$attributeName] = $attributeId;
    }
}

$now = date('Y-m-d H:i:s');

switch ($action) {
    case 'kitchen':
        if (!empty($attributeIds['order_closed'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_closed'], 'on');
        }
        if (!empty($attributeIds['order_closed_and_paid'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_closed_and_paid'], 'off');
        }
        if (!empty($attributeIds['order_cancelled'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_cancelled'], 'off');
        }
        adminClientSetFlash('Order moved to kitchen.', 'success');
        break;

    case 'served_paid':
        if (!empty($attributeIds['order_closed'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_closed'], 'on');
        }
        if (!empty($attributeIds['order_closed_and_paid'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_closed_and_paid'], 'on');
        }
        if (!empty($attributeIds['order_cancelled'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_cancelled'], 'off');
        }
        if (!empty($attributeIds['order_close_time'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_close_time'], $now);
        }
        if (!empty($attributeIds['order_paid_closed_time'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_paid_closed_time'], $now);
        }
        adminClientSetFlash('Order marked as served and paid.', 'success');
        break;

    case 'cancel':
        if (!empty($attributeIds['order_cancelled'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_cancelled'], 'on');
        }
        if (!empty($attributeIds['order_closed_and_paid'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_closed_and_paid'], 'off');
        }
        if (!empty($attributeIds['order_closed'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_closed'], 'off');
        }
        if (!empty($attributeIds['order_close_time'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_close_time'], $now);
        }
        if (!empty($attributeIds['order_cancelled_time'])) {
            setEntityAttributeValue($orderId, $attributeIds['order_cancelled_time'], $now);
        }
        adminClientSetFlash('Order cancelled.', 'success');
        break;

    default:
        adminClientSetFlash('Unsupported order action.', 'error');
        break;
}

adminClientOrdersRedirect($selectedDate);
?>

<?php

require_once __DIR__ . '/core/entities.php';

header('Content-Type: application/json; charset=UTF-8');

function orderJsonResponse($payload, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

function orderNormalizeMoney($value) {
    $normalized = preg_replace('/[^0-9.\-]/', '', (string) $value);
    return $normalized === '' ? 0.0 : round((float) $normalized, 2);
}

function orderFindAttributeMap($entityTypeId) {
    $map = [];
    foreach (getAttributesByEntityType($entityTypeId) as $attribute) {
        $name = strtolower(trim((string) ($attribute['attribute_name'] ?? '')));
        $attributeId = (int) ($attribute['attribute_id'] ?? 0);
        if ($name !== '' && $attributeId > 0) {
            $map[$name] = $attributeId;
        }
    }
    return $map;
}

function orderBuildItemsHtml($items) {
    $html = '';
    foreach ($items as $item) {
        $title = htmlspecialchars((string) ($item['title'] ?? 'Item'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $quantity = max(1, (int) ($item['quantity'] ?? 1));
        $lineTotal = number_format((float) ($item['line_total'] ?? 0), 2, '.', '');
        $itemId = (int) ($item['item_id'] ?? 0);
        $html .= '<li data-item-id="' . $itemId . '"><span class="item-title">' . $title . '</span> <span class="item-qty">x ' . $quantity . '</span> <span class="item-total">$' . $lineTotal . '</span></li>';
    }
    return $html;
}

function orderRenderPreviewTemplate($templateHtml, $entityId, $tableNumber, $itemsHtml, $total) {
    $replacements = [
        '{order-id}' => (string) $entityId,
        '{table}' => (string) $tableNumber,
        '{order-items}' => $itemsHtml,
        '{items}' => $itemsHtml,
        '{order-total}' => '$' . number_format($total, 2, '.', ''),
        '{total}' => '$' . number_format($total, 2, '.', ''),
    ];

    return strtr((string) $templateHtml, $replacements);
}

function orderTruthy($value) {
    $value = strtolower(trim((string) $value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

function orderExistingAttributeMap($entityId) {
    $map = [];
    foreach (getEntityAttributeValues($entityId) as $attribute) {
        $map[strtolower(trim((string) ($attribute['name'] ?? '')))] = (string) ($attribute['value'] ?? '');
    }
    return $map;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    orderJsonResponse(['success' => false, 'message' => 'Invalid request method.'], 405);
}

$tableNumber = isset($_POST['table']) ? (int) $_POST['table'] : 0;
$existingOrderEntityId = isset($_POST['order_entity_id']) ? (int) $_POST['order_entity_id'] : 0;
$rawItems = isset($_POST['items']) ? (string) $_POST['items'] : '[]';
$items = json_decode($rawItems, true);
$orderedBy = trim((string) ($_POST['ordered_by'] ?? ''));
$orderedFromPhone = trim((string) ($_POST['ordered_from_phone'] ?? ''));

if ($tableNumber <= 0) {
    orderJsonResponse(['success' => false, 'message' => 'Invalid table number.'], 422);
}

if (!is_array($items)) {
    orderJsonResponse(['success' => false, 'message' => 'Invalid order items supplied.'], 422);
}

$orderTypeRows = getEntityTypeByName('orders');
if (empty($orderTypeRows)) {
    orderJsonResponse(['success' => false, 'message' => 'Order type not configured.'], 500);
}

$orderType = $orderTypeRows[0];
$orderTypeId = (int) ($orderType['id'] ?? 0);
$templateId = (int) ($orderType['template_id'] ?? 0);
$attributeMap = orderFindAttributeMap($orderTypeId);

if ($orderTypeId <= 0) {
    orderJsonResponse(['success' => false, 'message' => 'Order type not configured.'], 500);
}

$total = 0.0;
$normalizedItems = [];
foreach ($items as $item) {
    $quantity = max(1, (int) ($item['quantity'] ?? 1));
    $unitPrice = orderNormalizeMoney($item['unit_price'] ?? 0);
    $lineTotal = round($quantity * $unitPrice, 2);
    $normalizedItems[] = [
        'item_id' => (int) ($item['item_id'] ?? 0),
        'title' => (string) ($item['title'] ?? 'Item'),
        'quantity' => $quantity,
        'unit_price' => $unitPrice,
        'line_total' => $lineTotal,
    ];
    $total += $lineTotal;
}

$itemsHtml = orderBuildItemsHtml($normalizedItems);
$orderName = 'table-' . $tableNumber . '-order-' . date('Ymd-His');
$orderEntityId = 0;
$existingAttributeValues = [];

if ($existingOrderEntityId > 0) {
    $existingRows = getEntity($existingOrderEntityId);
    if (!empty($existingRows) && (int) ($existingRows[0]['entity_type_id'] ?? 0) === $orderTypeId) {
        $orderEntityId = $existingOrderEntityId;
        $existingAttributeValues = orderExistingAttributeMap($orderEntityId);
        updateEntity($orderEntityId, $orderName);
    }
}

if ($orderedBy === '') {
    $orderedBy = (string) ($existingAttributeValues['ordered_by'] ?? '');
}
if ($orderedFromPhone === '') {
    $orderedFromPhone = (string) ($existingAttributeValues['ordered_from_phone'] ?? '');
}

if ($orderedBy === '' || $orderedFromPhone === '') {
    orderJsonResponse(['success' => false, 'message' => 'Name and phone are required to place an order.'], 422);
}

if ($orderEntityId <= 0) {
    if (empty($normalizedItems)) {
        orderJsonResponse(['success' => false, 'message' => 'No order items supplied.'], 422);
    }
    $orderEntityId = (int) createEntity($orderName, $orderTypeId);
}

if ($orderEntityId <= 0) {
    orderJsonResponse(['success' => false, 'message' => 'Unable to save order.'], 500);
}

if (!empty($attributeMap['order_id'])) {
    setEntityAttributeValue($orderEntityId, $attributeMap['order_id'], (string) $orderEntityId);
}
if (!empty($attributeMap['order_items'])) {
    setEntityAttributeValue($orderEntityId, $attributeMap['order_items'], $itemsHtml);
}
if (!empty($attributeMap['order_total'])) {
    setEntityAttributeValue($orderEntityId, $attributeMap['order_total'], number_format($total, 2, '.', ''));
}
if (!empty($attributeMap['table'])) {
    setEntityAttributeValue($orderEntityId, $attributeMap['table'], (string) $tableNumber);
}
if (!empty($attributeMap['ordered_by'])) {
    setEntityAttributeValue($orderEntityId, $attributeMap['ordered_by'], $orderedBy);
}
if (!empty($attributeMap['ordered_from_phone'])) {
    setEntityAttributeValue($orderEntityId, $attributeMap['ordered_from_phone'], $orderedFromPhone);
}
if (!empty($attributeMap['order_closed'])) {
    $closedValue = orderTruthy($existingAttributeValues['order_closed'] ?? '') ? 'on' : 'off';
    setEntityAttributeValue($orderEntityId, $attributeMap['order_closed'], $closedValue);
}
if (!empty($attributeMap['order_closed_and_paid'])) {
    $paidValue = orderTruthy($existingAttributeValues['order_closed_and_paid'] ?? '') ? 'on' : 'off';
    setEntityAttributeValue($orderEntityId, $attributeMap['order_closed_and_paid'], $paidValue);
}

$templateHtml = '';
if ($templateId > 0) {
    $templateRows = getEntityTemplate($templateId);
    if (!empty($templateRows)) {
        $templateHtml = (string) ($templateRows[0]['preview_template_html'] ?? '');
    }
}

$previewHtml = orderRenderPreviewTemplate($templateHtml, $orderEntityId, $tableNumber, $itemsHtml, $total);

orderJsonResponse([
    'success' => true,
    'order_entity_id' => $orderEntityId,
    'order_id' => $orderEntityId,
    'table' => $tableNumber,
    'ordered_by' => $orderedBy,
    'ordered_from_phone' => $orderedFromPhone,
    'items_html' => $itemsHtml,
    'order_total' => number_format($total, 2, '.', ''),
    'preview_html' => $previewHtml,
    'order_closed' => orderTruthy($existingAttributeValues['order_closed'] ?? ''),
    'order_closed_and_paid' => orderTruthy($existingAttributeValues['order_closed_and_paid'] ?? ''),
]);
?>

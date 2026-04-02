<?php

require_once __DIR__ . '/core/entities.php';

header('Content-Type: application/json; charset=UTF-8');

function orderJsonResponse($payload, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

function orderStatusTruthy($value) {
    $value = strtolower(trim((string) $value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    orderJsonResponse(['success' => false, 'message' => 'Invalid request method.'], 405);
}

$orderEntityId = isset($_GET['order_entity_id']) ? (int) $_GET['order_entity_id'] : 0;
if ($orderEntityId <= 0) {
    orderJsonResponse(['success' => false, 'message' => 'Invalid order id.'], 422);
}

$orderRows = getEntity($orderEntityId);
if (empty($orderRows)) {
    orderJsonResponse(['success' => false, 'message' => 'Order not found.'], 404);
}

$orderEntity = $orderRows[0];
$orderTypeRows = getEntityTypeByName('orders');
$orderTypeId = !empty($orderTypeRows) ? (int) ($orderTypeRows[0]['id'] ?? 0) : 0;
if ($orderTypeId <= 0 || (int) ($orderEntity['entity_type_id'] ?? 0) !== $orderTypeId) {
    orderJsonResponse(['success' => false, 'message' => 'Order not found.'], 404);
}

$attributes = getEntityAttributeValues($orderEntityId);
$attributeMap = [];
foreach ($attributes as $attribute) {
    $attributeMap[strtolower(trim((string) ($attribute['name'] ?? '')))] = (string) ($attribute['value'] ?? '');
}

orderJsonResponse([
    'success' => true,
    'order_entity_id' => $orderEntityId,
    'order_closed' => orderStatusTruthy($attributeMap['order_closed'] ?? ''),
    'order_closed_and_paid' => orderStatusTruthy($attributeMap['order_closed_and_paid'] ?? ''),
    'order_cancelled' => orderStatusTruthy($attributeMap['order_cancelled'] ?? ''),
    'order_items_html' => (string) ($attributeMap['order_items'] ?? ''),
    'order_total' => (string) ($attributeMap['order_total'] ?? ''),
    'table' => (string) ($attributeMap['table'] ?? ''),
    'ordered_by' => (string) ($attributeMap['ordered_by'] ?? ''),
    'ordered_from_phone' => (string) ($attributeMap['ordered_from_phone'] ?? ''),
    'order_close_time' => (string) ($attributeMap['order_close_time'] ?? ''),
    'order_paid_closed_time' => (string) ($attributeMap['order_paid_closed_time'] ?? ''),
    'order_cancelled_time' => (string) ($attributeMap['order_cancelled_time'] ?? ''),
]);
?>

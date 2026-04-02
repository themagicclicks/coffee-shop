<?php

function adminClientOrderTruthy($value) {
    $value = strtolower(trim((string) $value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

function adminClientOrderDateValue($value) {
    $date = trim((string) $value);
    if ($date === '') {
        return date('Y-m-d');
    }

    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return date('Y-m-d');
    }

    return date('Y-m-d', $timestamp);
}

function adminClientOrderStatusMeta($order) {
    $isCancelled = adminClientOrderTruthy($order['order_cancelled'] ?? '');
    $isPaid = adminClientOrderTruthy($order['order_closed_and_paid'] ?? '');
    $isInKitchen = adminClientOrderTruthy($order['order_closed'] ?? '');

    if ($isCancelled) {
        return ['label' => 'Cancelled', 'class' => 'is-cancelled'];
    }

    if ($isPaid) {
        return ['label' => 'Paid And Served', 'class' => 'is-paid'];
    }

    if ($isInKitchen) {
        return ['label' => 'In Kitchen', 'class' => 'is-kitchen'];
    }

    return ['label' => 'Open', 'class' => 'is-open'];
}

$selectedDate = adminClientOrderDateValue($_GET['date'] ?? '');
$flash = adminClientConsumeFlash();
$ordersTypeRows = getEntityTypeByName('orders');
$orders = [];
$groupedOrders = [];
$ordersMessage = '';

if (empty($ordersTypeRows)) {
    $ordersMessage = 'The orders content type is not configured yet.';
} else {
    $ordersTypeId = (int) ($ordersTypeRows[0]['id'] ?? 0);
    $orders = getEntitiesByTypeIdForDate($ordersTypeId, $selectedDate);

    if (empty($orders)) {
        $ordersMessage = 'No orders were found for this date.';
    } else {
        $orderIds = array_map(static function ($order) {
            return (int) ($order['id'] ?? 0);
        }, $orders);

        $attributeRows = getEntityAttributeValuesForEntities($orderIds);
        $attributeMap = [];
        foreach ($attributeRows as $attributeRow) {
            $entityId = (int) ($attributeRow['entity_id'] ?? 0);
            if ($entityId <= 0) {
                continue;
            }
            if (!isset($attributeMap[$entityId])) {
                $attributeMap[$entityId] = [];
            }
            $attributeMap[$entityId][(string) ($attributeRow['name'] ?? '')] = (string) ($attributeRow['value'] ?? '');
        }

        foreach ($orders as $order) {
            $orderId = (int) ($order['id'] ?? 0);
            $attributes = $attributeMap[$orderId] ?? [];
            $tableNumber = trim((string) ($attributes['table'] ?? 'Unknown'));
            $groupKey = $tableNumber !== '' ? $tableNumber : 'Unknown';

            if (!isset($groupedOrders[$groupKey])) {
                $groupedOrders[$groupKey] = [];
            }

            $groupedOrders[$groupKey][] = [
                'entity' => $order,
                'attributes' => $attributes,
                'status' => adminClientOrderStatusMeta($attributes),
            ];
        }

        uksort($groupedOrders, static function ($left, $right) {
            if ($left === 'Unknown') {
                return 1;
            }
            if ($right === 'Unknown') {
                return -1;
            }

            return (int) $left <=> (int) $right;
        });
    }
}
?>
<section class="admin-content admin-orders-page">
    <?php if (!empty($flash['message'])) { ?>
        <div class="card-panel <?php echo ($flash['type'] ?? 'success') === 'error' ? 'red lighten-4 red-text text-darken-4' : 'green lighten-4 green-text text-darken-4'; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php } ?>

    <div class="admin-card admin-orders-header">
        <div>
            <div class="card-label">Orders</div>
            <h4 style="margin-top: 0;">Orders Board</h4>
            <p class="helper-note">Choose a date to review today’s orders or revisit previous service history.</p>
        </div>
        <form method="get" action="index.php" class="admin-orders-filter">
            <input type="hidden" name="page" value="orders">
            <div class="input-field">
                <input id="orders-date" type="text" name="date" class="datepicker admin-orders-datepicker" value="<?php echo htmlspecialchars($selectedDate); ?>">
                <label for="orders-date" class="active">Service Date</label>
            </div>
            <button type="submit" class="btn brown">Load Orders</button>
        </form>
    </div>

    <?php if ($ordersMessage !== '') { ?>
        <div class="admin-card">
            <p><?php echo htmlspecialchars($ordersMessage); ?></p>
        </div>
    <?php } else { ?>
        <?php foreach ($groupedOrders as $tableNumber => $tableOrders) { ?>
            <div class="admin-card admin-orders-group">
                <div class="admin-orders-group__header">
                    <h5>Table #<?php echo htmlspecialchars((string) $tableNumber); ?></h5>
                    <span><?php echo count($tableOrders); ?> order<?php echo count($tableOrders) === 1 ? '' : 's'; ?></span>
                </div>
                <div class="admin-orders-grid">
                    <?php foreach ($tableOrders as $orderRow) { ?>
                        <?php
                        $order = $orderRow['entity'];
                        $attributes = $orderRow['attributes'];
                        $status = $orderRow['status'];
                        $orderId = (int) ($order['id'] ?? 0);
                        $customerName = trim((string) ($attributes['ordered_by'] ?? 'Guest'));
                        $customerPhone = trim((string) ($attributes['ordered_from_phone'] ?? ''));
                        $orderTotal = trim((string) ($attributes['order_total'] ?? '0.00'));
                        $closeTime = trim((string) ($attributes['order_close_time'] ?? ''));
                        ?>
                        <article class="admin-order-card">
                            <div class="admin-order-card__top">
                                <div>
                                    <div class="admin-order-card__id">Order #<?php echo htmlspecialchars((string) ($attributes['order_id'] ?? $orderId)); ?></div>
                                    <h6><?php echo htmlspecialchars($customerName); ?></h6>
                                    <?php if ($customerPhone !== '') { ?>
                                        <div class="admin-order-card__phone"><?php echo htmlspecialchars($customerPhone); ?></div>
                                    <?php } ?>
                                </div>
                                <span class="admin-order-status <?php echo htmlspecialchars($status['class']); ?>"><?php echo htmlspecialchars($status['label']); ?></span>
                            </div>

                            <div class="admin-order-card__meta">
                                <span>Placed: <?php echo htmlspecialchars((string) ($order['created_at'] ?? '')); ?></span>
                                <?php if ($closeTime !== '') { ?>
                                    <span>Closed: <?php echo htmlspecialchars($closeTime); ?></span>
                                <?php } ?>
                            </div>

                            <div class="admin-order-card__items">
                                <?php echo (string) ($attributes['order_items'] ?? '<p>No items recorded.</p>'); ?>
                            </div>

                            <div class="admin-order-card__footer">
                                <strong>Total: <?php echo htmlspecialchars($orderTotal); ?></strong>
                            </div>

                            <div class="admin-order-card__actions">
                                <form method="post" action="orders_update.php" class="admin-order-action-form">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars((string) $orderId); ?>">
                                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>">
                                    <input type="hidden" name="action" value="kitchen">
                                    <button type="submit" class="btn-small amber darken-2 admin-order-action" <?php echo ($status['class'] === 'is-paid' || $status['class'] === 'is-cancelled') ? 'disabled' : ''; ?>>In Kitchen</button>
                                </form>
                                <form method="post" action="orders_update.php" class="admin-order-action-form">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars((string) $orderId); ?>">
                                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>">
                                    <input type="hidden" name="action" value="served_paid">
                                    <button type="submit" class="btn-small green darken-1 admin-order-action" <?php echo $status['class'] === 'is-cancelled' ? 'disabled' : ''; ?>>Served And Paid</button>
                                </form>
                                <form method="post" action="orders_update.php" class="admin-order-action-form">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars((string) $orderId); ?>">
                                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($selectedDate); ?>">
                                    <input type="hidden" name="action" value="cancel">
                                    <button type="submit" class="btn-small red darken-1 admin-order-action" data-confirm="Cancel this order?" <?php echo $status['class'] === 'is-paid' ? 'disabled' : ''; ?>>Cancelled</button>
                                </form>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</section>

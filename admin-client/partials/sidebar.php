<?php
function renderAdminClientMenuItems($menuItems, $level = 0) {
    foreach ($menuItems as $menuItem) {
        $hasChildren = !empty($menuItem['children']);
        $icon = htmlspecialchars($menuItem['icon'] ?? 'folder');
        $label = htmlspecialchars($menuItem['label'] ?? 'Section');

        if ($hasChildren) {
            echo '<li>';
            echo '<div class="collapsible-header"><i class="material-icons">' . $icon . '</i><span>' . $label . '</span></div>';
            echo '<div class="collapsible-body" style="padding: 0; border-bottom: none;">';
            echo '<ul class="collection" style="margin: 0; border: none;">';
            renderAdminClientMenuItems($menuItem['children'], $level + 1);
            echo '</ul>';
            echo '</div>';
            echo '</li>';
            continue;
        }

        $entityType = trim((string) ($menuItem['entity_type'] ?? ''));
        if ($entityType === '') {
            continue;
        }

        echo '<li class="collection-item" style="padding-left: ' . (20 + ($level * 14)) . 'px;">';
        echo '<a href="index.php?section=' . urlencode($entityType) . '">';
        echo '<i class="material-icons">' . $icon . '</i>';
        echo '<span>' . $label . '</span>';
        echo '</a>';
        echo '</li>';
    }
}
?>
<aside class="admin-sidebar">
    <div class="brand"><?php echo htmlspecialchars($appTitle); ?></div>
    <div class="sidebar-note">
        Project sections are loaded from config.
    </div>
    <ul class="collection" style="margin-top: 24px; border-radius: 14px; overflow: hidden; border: none;">
        <li class="collection-item"><a href="index.php?page=dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a></li>
    </ul>
    <?php if (!empty($config['menu'])) { ?>
        <ul class="collapsible" style="margin: 0; border-radius: 14px; overflow: hidden; border: none; box-shadow: none;">
            <?php renderAdminClientMenuItems($config['menu']); ?>
        </ul>
    <?php } ?>
    <ul class="collection" style="margin-top: 16px; border-radius: 14px; overflow: hidden; border: none;">
        <li class="collection-item"><a href="index.php?page=navigation"><i class="material-icons">menu</i><span>Navigation</span></a></li>
        <li class="collection-item"><a href="index.php?page=settings"><i class="material-icons">settings</i><span>Settings</span></a></li>
        <li class="collection-item"><a href="index.php?logout=1"><i class="material-icons">logout</i><span>Logout</span></a></li>
    </ul>
</aside>
<div class="admin-main">

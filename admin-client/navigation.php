<?php
$pageTitle = 'Navigation';
$flash = adminClientConsumeFlash();
$frontendNavigation = $config['frontend_navigation'] ?? ['top_nav' => [], 'open_menu' => []];
$topNavItems = $frontendNavigation['top_nav'] ?? [];
$openMenuItems = $frontendNavigation['open_menu'] ?? [];
$pageScripts = ($pageScripts ?? '') . '<script>document.addEventListener("DOMContentLoaded",function(){function bind(section){document.querySelectorAll("[data-add-row=\""+section+"\"]").forEach(function(btn){btn.addEventListener("click",function(){var container=document.querySelector("[data-nav-section=\""+section+"\"]"); if(!container)return; var row=document.createElement("div"); row.className="row admin-nav-row"; row.innerHTML=container.getAttribute("data-row-template"); container.appendChild(row); if(window.M&&typeof window.M.updateTextFields==="function"){M.updateTextFields();} if(window.M&&typeof window.M.FormSelect==="function"){M.FormSelect.init(row.querySelectorAll("select"));}});});} document.addEventListener("click",function(e){var btn=e.target.closest("[data-remove-row]"); if(!btn)return; var row=btn.closest(".admin-nav-row"); if(row){row.remove();}}); bind("top_nav"); bind("open_menu"); if(window.M&&typeof window.M.FormSelect==="function"){M.FormSelect.init(document.querySelectorAll("select"));}});</script>';
function renderNavigationRows($sectionName, $items) {
    foreach ($items as $item) {
        $name = htmlspecialchars((string) ($item['name'] ?? ''));
        $label = htmlspecialchars((string) ($item['label'] ?? ''));
        $href = htmlspecialchars((string) ($item['href'] ?? ''));
        $target = (string) ($item['target'] ?? '_top');
        echo '<div class="row admin-nav-row">';
        echo '<div class="input-field col s12 m3"><input type="text" name="navigation[' . $sectionName . '][name][]" value="' . $name . '"><label class="active">Menu Name</label></div>';
        echo '<div class="input-field col s12 m3"><input type="text" name="navigation[' . $sectionName . '][label][]" value="' . $label . '"><label class="active">Title</label></div>';
        echo '<div class="input-field col s12 m4"><input type="text" name="navigation[' . $sectionName . '][href][]" value="' . $href . '"><label class="active">Link</label></div>';
        echo '<div class="input-field col s10 m1"><select name="navigation[' . $sectionName . '][target][]"><option value="_top"' . ($target === '_top' ? ' selected' : '') . '>_top</option><option value="_blank"' . ($target === '_blank' ? ' selected' : '') . '>_blank</option></select><label>Target</label></div>';
        echo '<div class="col s2 m1" style="padding-top: 22px;"><button type="button" class="btn-flat red-text" data-remove-row>Delete</button></div>';
        echo '</div>';
    }
}
function navigationRowTemplate($sectionName) {
    return htmlspecialchars('<div class="input-field col s12 m3"><input type="text" name="navigation[' . $sectionName . '][name][]" value=""><label class="active">Menu Name</label></div><div class="input-field col s12 m3"><input type="text" name="navigation[' . $sectionName . '][label][]" value=""><label class="active">Title</label></div><div class="input-field col s12 m4"><input type="text" name="navigation[' . $sectionName . '][href][]" value=""><label class="active">Link</label></div><div class="input-field col s10 m1"><select name="navigation[' . $sectionName . '][target][]"><option value="_top" selected>_top</option><option value="_blank">_blank</option></select><label>Target</label></div><div class="col s2 m1" style="padding-top: 22px;"><button type="button" class="btn-flat red-text" data-remove-row>Delete</button></div>', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<section class="admin-content">
    <?php if (!empty($flash['message'])) { ?>
        <div class="card-panel <?php echo ($flash['type'] ?? 'success') === 'error' ? 'red lighten-4 red-text text-darken-4' : 'green lighten-4 green-text text-darken-4'; ?>"><?php echo htmlspecialchars($flash['message']); ?></div>
    <?php } ?>
    <form method="post" action="navigation_save.php">
        <div class="admin-card">
            <div class="card-label">Frontend Menu</div>
            <h4 style="margin-top:0;">Top Navigation</h4>
            <p class="helper-note">Menu Name is auto-normalized to a friendly key on save.</p>
            <div data-nav-section="top_nav" data-row-template="<?php echo navigationRowTemplate('top_nav'); ?>">
                <?php renderNavigationRows('top_nav', $topNavItems); ?>
            </div>
            <button type="button" class="btn-flat" data-add-row="top_nav">Add Top Nav Item</button>
        </div>
        <div class="admin-card">
            <div class="card-label">Frontend Menu</div>
            <h4 style="margin-top:0;">Open Menu</h4>
            <div data-nav-section="open_menu" data-row-template="<?php echo navigationRowTemplate('open_menu'); ?>">
                <?php renderNavigationRows('open_menu', $openMenuItems); ?>
            </div>
            <button type="button" class="btn-flat" data-add-row="open_menu">Add Open Menu Item</button>
        </div>
        <div class="admin-card">
            <button type="submit" class="btn brown">Save Navigation</button>
        </div>
    </form>
</section>

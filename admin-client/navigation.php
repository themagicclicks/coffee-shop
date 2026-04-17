<?php
$pageTitle = 'Navigation';
$flash = adminClientConsumeFlash();
$frontendNavigation = $config['frontend_navigation'] ?? ['top_nav' => [], 'open_menu' => []];
$topNavItems = $frontendNavigation['top_nav'] ?? [];
$openMenuItems = $frontendNavigation['open_menu'] ?? [];
$availableThemes = adminClientAvailableThemes(dirname(__DIR__) . '/themes');
$pageScripts = ($pageScripts ?? '') . '<script>document.addEventListener("DOMContentLoaded",function(){function nextIndex(container){var value=parseInt(container.getAttribute("data-next-index")||"0",10);container.setAttribute("data-next-index",String(value+1));return value;}function syncThemeSelection(select){if(!select||!select.multiple){return;}var values=Array.from(select.selectedOptions||[]).map(function(option){return option.value;});if(values.indexOf("ALL")===-1){return;}Array.from(select.options||[]).forEach(function(option){option.selected=option.value==="ALL";});if(window.M&&typeof window.M.FormSelect==="function"){var instance=window.M.FormSelect.getInstance(select);if(instance&&typeof instance.destroy==="function"){instance.destroy();}window.M.FormSelect.init(select);}}function bind(section){document.querySelectorAll("[data-add-row=\""+section+"\"]").forEach(function(btn){btn.addEventListener("click",function(){var container=document.querySelector("[data-nav-section=\""+section+"\"]"); if(!container)return; var row=document.createElement("div"); row.className="row admin-nav-row"; var index=nextIndex(container); row.innerHTML=container.getAttribute("data-row-template").replace(/__INDEX__/g,String(index)); container.appendChild(row); if(window.M&&typeof window.M.updateTextFields==="function"){M.updateTextFields();} if(window.M&&typeof window.M.FormSelect==="function"){M.FormSelect.init(row.querySelectorAll("select"));} row.querySelectorAll("select[multiple]").forEach(function(select){select.addEventListener("change",function(){syncThemeSelection(select);});});});});} document.addEventListener("click",function(e){var btn=e.target.closest("[data-remove-row]"); if(!btn)return; var row=btn.closest(".admin-nav-row"); if(row){row.remove();}}); bind("top_nav"); bind("open_menu"); document.querySelectorAll("select[multiple]").forEach(function(select){select.addEventListener("change",function(){syncThemeSelection(select);});}); if(window.M&&typeof window.M.FormSelect==="function"){M.FormSelect.init(document.querySelectorAll("select"));}});</script>';
function renderNavigationThemeOptions($selectedThemes, $availableThemes) {
    $selectedThemes = adminClientNormalizeFrontendNavigationThemes($selectedThemes);
    $html = '<option value="ALL"' . (in_array('ALL', $selectedThemes, true) ? ' selected' : '') . '>ALL</option>';
    foreach ($availableThemes as $themeName) {
        $normalizedThemeName = adminClientNormalizeThemeName($themeName);
        $html .= '<option value="' . htmlspecialchars($normalizedThemeName) . '"' . (in_array($normalizedThemeName, $selectedThemes, true) ? ' selected' : '') . '>' . htmlspecialchars(ucwords(str_replace(['-', '_'], ' ', $normalizedThemeName))) . '</option>';
    }
    return $html;
}
function renderNavigationRows($sectionName, $items, $availableThemes) {
    foreach (array_values($items) as $index => $item) {
        $name = htmlspecialchars((string) ($item['name'] ?? ''));
        $label = htmlspecialchars((string) ($item['label'] ?? ''));
        $href = htmlspecialchars((string) ($item['href'] ?? ''));
        $target = (string) ($item['target'] ?? '_top');
        $themes = $item['theme'] ?? ['ALL'];
        $visibility = adminClientNormalizeFrontendNavigationVisibility($item['visibility'] ?? 'ALL');
        echo '<div class="row admin-nav-row">';
        echo '<div class="input-field col s12 m2"><input type="text" name="navigation[' . $sectionName . '][name][]" value="' . $name . '"><label class="active">Menu Name</label></div>';
        echo '<div class="input-field col s12 m2"><input type="text" name="navigation[' . $sectionName . '][label][]" value="' . $label . '"><label class="active">Title</label></div>';
        echo '<div class="input-field col s12 m2"><input type="text" name="navigation[' . $sectionName . '][href][]" value="' . $href . '"><label class="active">Link</label></div>';
        echo '<div class="input-field col s6 m2"><select multiple name="navigation[' . $sectionName . '][theme][' . $index . '][]">' . renderNavigationThemeOptions($themes, $availableThemes) . '</select><label>Themes</label></div>';
        echo '<div class="input-field col s6 m2"><select name="navigation[' . $sectionName . '][visibility][]"><option value="ALL"' . ($visibility === 'ALL' ? ' selected' : '') . '>ALL</option><option value="DESKTOP_ONLY"' . ($visibility === 'DESKTOP_ONLY' ? ' selected' : '') . '>DESKTOP ONLY</option><option value="MOBILE_ONLY"' . ($visibility === 'MOBILE_ONLY' ? ' selected' : '') . '>MOBILE ONLY</option></select><label>Visibility</label></div>';
        echo '<div class="input-field col s4 m1"><select name="navigation[' . $sectionName . '][target][]"><option value="_top"' . ($target === '_top' ? ' selected' : '') . '>_top</option><option value="_blank"' . ($target === '_blank' ? ' selected' : '') . '>_blank</option></select><label>Target</label></div>';
        echo '<div class="col s2 m1" style="padding-top: 22px;"><button type="button" class="btn-flat red-text" data-remove-row>Delete</button></div>';
        echo '</div>';
    }
}
function navigationRowTemplate($sectionName, $availableThemes) {
    $themeOptions = renderNavigationThemeOptions(['ALL'], $availableThemes);
    return htmlspecialchars('<div class="input-field col s12 m2"><input type="text" name="navigation[' . $sectionName . '][name][]" value=""><label class="active">Menu Name</label></div><div class="input-field col s12 m2"><input type="text" name="navigation[' . $sectionName . '][label][]" value=""><label class="active">Title</label></div><div class="input-field col s12 m2"><input type="text" name="navigation[' . $sectionName . '][href][]" value=""><label class="active">Link</label></div><div class="input-field col s6 m2"><select multiple name="navigation[' . $sectionName . '][theme][__INDEX__][]">' . $themeOptions . '</select><label>Themes</label></div><div class="input-field col s6 m2"><select name="navigation[' . $sectionName . '][visibility][]"><option value="ALL" selected>ALL</option><option value="DESKTOP_ONLY">DESKTOP ONLY</option><option value="MOBILE_ONLY">MOBILE ONLY</option></select><label>Visibility</label></div><div class="input-field col s4 m1"><select name="navigation[' . $sectionName . '][target][]"><option value="_top" selected>_top</option><option value="_blank">_blank</option></select><label>Target</label></div><div class="col s2 m1" style="padding-top: 22px;"><button type="button" class="btn-flat red-text" data-remove-row>Delete</button></div>', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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
            <p class="helper-note">Menu Name is auto-normalized to a friendly key on save. Set Theme to ALL to show an item across every theme, or choose one theme to make it theme-specific. Use Visibility to control whether the item appears on desktop, mobile, or both.</p>
            <div data-nav-section="top_nav" data-next-index="<?php echo count($topNavItems); ?>" data-row-template="<?php echo navigationRowTemplate('top_nav', $availableThemes); ?>">
                <?php renderNavigationRows('top_nav', $topNavItems, $availableThemes); ?>
            </div>
            <button type="button" class="btn-flat" data-add-row="top_nav">Add Top Nav Item</button>
        </div>
        <div class="admin-card">
            <div class="card-label">Frontend Menu</div>
            <h4 style="margin-top:0;">Open Menu</h4>
            <div data-nav-section="open_menu" data-next-index="<?php echo count($openMenuItems); ?>" data-row-template="<?php echo navigationRowTemplate('open_menu', $availableThemes); ?>">
                <?php renderNavigationRows('open_menu', $openMenuItems, $availableThemes); ?>
            </div>
            <button type="button" class="btn-flat" data-add-row="open_menu">Add Open Menu Item</button>
        </div>
        <div class="admin-card">
            <button type="submit" class="btn brown">Save Navigation</button>
        </div>
    </form>
</section>

<?php
$pageTitle = 'PDF Layout';
require_once BASE . 'includes/functions.php';

$menuPdfSections = getPrintableMenuSections();

ob_start();
include BASE . 'includes/menu-template.php';
$menuPdfTemplateHtml = ob_get_clean();
$menuPdfTemplateHtml = str_replace(
    'class="menu-pdf-source"',
    'class="menu-pdf-source" style="position: relative; left: 0; top: 0; width: 210mm; color: #2b211a; padding: 0; opacity: 1; pointer-events: none; z-index: -1;"',
    $menuPdfTemplateHtml
);
$savedMenuPdfHtml = adminClientLoadFormattedMenuPdfHtml();
$initialMenuPdfHtml = trim($savedMenuPdfHtml) !== '' ? $savedMenuPdfHtml : $menuPdfTemplateHtml;
?>
<section class="admin-content">
    <div class="admin-card">
        <div class="card-label">PDF Settings</div>
        <h4 style="margin-top: 0;">Menu PDF Layout</h4>
        <p class="helper-note">
            This preview uses the live menu template. Each dotted line marks one A4 page break. Click into the menu below and press Enter where needed to add breathing room so sections stay inside the page boundaries.
        </p>

        <div class="admin-pdf-toolbar">
            <button type="button" class="btn brown" data-admin-pdf-action="save">Save Layout</button>
            <button type="button" class="btn-flat red-text text-darken-2" data-admin-pdf-action="delete">Delete Saved Layout</button>
            <button type="button" class="btn-flat" data-admin-pdf-action="reset">Reset To Template</button>
            <span class="helper-note admin-pdf-toolbar__note">
                <?php echo trim($savedMenuPdfHtml) !== '' ? 'A saved PDF layout is currently active.' : 'No saved PDF layout yet. Frontend PDF uses the dynamic template.'; ?>
            </span>
        </div>

        <div class="admin-pdf-stage">
            <div class="admin-pdf-guide-layer" aria-hidden="true"></div>
            <div
                id="admin-pdf-menu-editor"
                class="admin-pdf-editor"
                data-save-url="pdf_layout_save.php"
                data-delete-url="pdf_layout_delete.php"
            ><?php echo $initialMenuPdfHtml; ?></div>
        </div>
    </div>
</section>

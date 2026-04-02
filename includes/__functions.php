<?php

if (!defined('BASE')) {
    define("BASE", "C:/xampp/htdocs/coffee-shop/");
}

if (!defined('SITE')) {
    define("SITE", "http://127.0.0.1/coffee-shop/");
}

require_once __DIR__ . '/../core/entities.php';
require_once __DIR__ . '/../core/mail.php';

function renderEntityField($fieldName, $fieldTypeId) {
    $result = db_connect("SELECT type_input FROM input_field_types WHERE id = ?", ['i'], [$fieldTypeId], 'select');
    if (!empty($result) && isset($result[0]['type_input'])) {
        return str_replace("{name}", htmlspecialchars($fieldName), $result[0]['type_input']);
    }

    return '';
}

function deleteCache($cacheDir, $entityIdentifiers) {
    foreach ($entityIdentifiers as $identifier) {
        $cacheFiles = glob("$cacheDir{$identifier}*");
        if (empty($cacheFiles)) {
            continue;
        }

        foreach ($cacheFiles as $file) {
            unlink($file);
        }
    }

    foreach ($entityIdentifiers as $identifier) {
        if (strpos($identifier, 'entity_') !== false) {
            $entityId = str_replace('entity_', '', $identifier);
            deleteRelatedEntityCache($cacheDir, $entityId);
        }
    }
}

function deleteRelatedEntityCache($cacheDir, $entityId) {
    $relatedEntities = db_connect("SELECT parent_entity_id FROM entity_relations WHERE child_entity_id = ?", ['i'], [$entityId], 'select');
    foreach ($relatedEntities as $related) {
        deleteCache($cacheDir, ["entity_" . $related['parent_entity_id']]);
    }
}

function getEntityTemplatesForSelect($id = 0) {
    $templates = getEntityTemplates();
    $options = "";
    foreach ($templates as $template) {
        $selected = ($id == $template['id']) ? ' selected' : '';
        $options .= "<option value='{$template['id']}'{$selected}>" . htmlspecialchars($template['template_name']) . "</option>";
    }
    return $options;
}

function getInputFieldTypesForSelect($inputypeid = 0) {
    $inputTypes = getInputFieldTypes();
    $options = "";
    foreach ($inputTypes as $type) {
        $selected = ($inputypeid == $type['id']) ? ' selected' : '';
        $options .= "<option value='{$type['id']}'{$selected}>" . htmlspecialchars($type['type_name']) . "</option>";
    }
    return $options;
}

function getEntityAttributesForSelect($id) {
    return db_connect("SELECT * FROM entity_attributes WHERE id = ?", ['i'], [$id], 'select');
}

function getEntityStatesforSelect($stateid = 0) {
    $states = db_connect("SELECT * FROM entity_states ORDER BY id ASC", [], [], 'select');
    $options = "";
    foreach ($states as $state) {
        $selected = ($stateid == $state['id']) ? ' selected' : '';
        $options .= "<option value='{$state['id']}'{$selected}>" . htmlspecialchars($state['state_name']) . "</option>";
    }
    return $options;
}

function getEntityAttributesWithInputTypes() {
    $query = "
        SELECT ea.id AS attribute_id, ea.name AS attribute_name,
               ift.id AS input_type_id, ift.type_name, ift.type_type
        FROM entity_attributes ea
        JOIN entity_attribute_input_map eaim ON ea.id = eaim.attribute_id
        JOIN input_field_types ift ON eaim.input_type_id = ift.id
    ";
    return db_connect($query, [], [], 'select');
}

function renderAttributeMultiSelect($entityTypeId = 0, $name = 'attributes') {
    $allAttributes = getEntityAttributesWithInputTypes();
    $mappedAttributes = ($entityTypeId > 0) ? getEntityTypeAttributesByEntityTypeId($entityTypeId) : [];

    $mappedOrders = [];
    foreach ($mappedAttributes as $mappedAttr) {
        $mappedOrders[$mappedAttr['attribute_id']] = intval($mappedAttr['attribute_order'] ?? 0);
    }

    if (empty($allAttributes)) {
        echo "<p>No attributes found.</p>";
        return;
    }

    foreach ($allAttributes as &$attr) {
        $attrId = $attr['attribute_id'];
        $attr['effective_order'] = $mappedOrders[$attrId] ?? intval($attr['attribute_order'] ?? 0);
    }
    unset($attr);

    usort($allAttributes, function ($a, $b) {
        return $a['effective_order'] <=> $b['effective_order'];
    });

    foreach ($allAttributes as $attr) {
        $attrId = htmlspecialchars($attr['attribute_id']);
        $attrName = htmlspecialchars($attr['attribute_name']);
        $inputType = htmlspecialchars($attr['type_name']);
        $inputTypeType = htmlspecialchars($attr['type_type']);
        $checked = array_key_exists($attrId, $mappedOrders) ? "checked" : "";
        $attrOrder = $attr['effective_order'];

        echo "<div class='attribute-selection row valign-wrapper' style='margin-bottom:10px;'>
                <div class='col s1'>
                    <label>
                        <input type='checkbox' name='{$name}[]' value='{$attrId}' {$checked} />
                        <span></span>
                    </label>
                </div>
                <div class='col s7'>
                    {$attrName} ({$inputType} - {$inputTypeType})
                </div>
                <div class='col s4'>
                    <input type='number' name='sort_orders[{$attrId}]' value='{$attrOrder}' placeholder='Order' class='input-field'>
                </div>
            </div>";
    }
}

function renderPHPTypeSelect($name, $selectedType = '') {
    $phpTypes = ['string', 'integer', 'float', 'boolean', 'null'];
    echo "<select name='{$name}' class='browser-default'>";
    foreach ($phpTypes as $type) {
        $selected = ($type === $selectedType) ? "selected" : "";
        echo "<option value='{$type}' {$selected}>{$type}</option>";
    }
    echo "</select>";
}

function getValueByName($array, $key) {
    foreach ($array as $item) {
        if (isset($item['name']) && $item['name'] === $key) {
            return $item['value'];
        }
    }
    return null;
}

function decodeField($value) {
    if (strpos($value, '__ENCODED__') === 0) {
        return urldecode(base64_decode(substr($value, 11)));
    }
    return $value;
}

function listImagesFromMediaFolder() {
    $mediaDir = BASE . 'media/';
    $mediaUrl = SITE . 'media/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    if (!is_dir($mediaDir)) {
        return '<p>No media directory found.</p>';
    }

    $html = '';
    foreach (scandir($mediaDir) as $file) {
        $filePath = $mediaDir . $file;
        $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (is_file($filePath) && in_array($fileExt, $allowedExtensions, true)) {
            $html .= '<img data-src="' . $mediaUrl . htmlspecialchars($file) . '" onclick="selectImage(this.src)" style="max-width: 150px; margin: 5px;">' . "`n";
        }
    }

    return '<div class="images-browse-list" style="display:none;">' . $html . '</div>';
}

function listContentTemplates() {
    $html = '<ul class="templates-browse-list" style="display:none;">';
    $templates = getContentTemplates();

    foreach ($templates as $template) {
        $rawHtml = $template['template_html'];
        $name = ucfirst(strtolower(trim(preg_replace('/-+/', ' ', $template['name']))));
        $escapedName = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $html .= '<li
                style="border:1px solid #ccc; padding:5px; width: 200px; height: 150px; overflow: hidden; position: relative; cursor: pointer;">
                    <div style="transform: scale(0.2); transform-origin: top left; width: 500%; pointer-events: none;">'
                    . $rawHtml .
                '</div>
                <div style="position: absolute; bottom: 0; width: 100%; background: rgba(255,255,255,0.8); text-align: center; font-size: 10px; padding: 2px 0;">'
                . $escapedName .
                '</div>
                </li>';
    }

    $html .= '</ul>';
    return $html;
}

?>

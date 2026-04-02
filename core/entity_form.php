<?php

require_once __DIR__ . '/entities.php';

function entityFormResolveSiteUrl() {
    if (defined('SITE')) {
        return SITE;
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/coffee-shop/admin-client/entity_edit.php';
    $basePath = rtrim(str_replace('\\', '/', dirname(dirname($scriptName))), '/');

    return $scheme . $host . ($basePath !== '' ? $basePath . '/' : '/');
}

function entityFormEscape($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function entityFormFormatLabel($name) {
    return ucwords(str_replace(['_', '-'], ' ', (string) $name));
}

function entityFormIsTruthy($value) {
    $value = strtolower(trim((string) $value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

function entityFormIsMediaType($typeName) {
    return in_array(strtolower(trim((string) $typeName)), ['image', 'video', 'pdf', 'file', 'photo gallery photo'], true);
}

function entityFormIsContentAttribute($attributeName) {
    return strtolower(trim((string) $attributeName)) === 'content';
}

function entityFormValueMap($entityId, $attributeIds) {
    if (!$entityId || empty($attributeIds)) {
        return [];
    }

    $rows = getEntityAttributeDataForEntity((int) $entityId, $attributeIds);
    $valueMap = [];
    foreach ($rows as $row) {
        if (!isset($row['attribute_id'])) {
            continue;
        }
        $valueMap[(int) ($row['attribute_id'] ?? 0)] = (string) ($row['value'] ?? '');
    }

    return $valueMap;
}

function entityFormInnerHtml($node) {
    $html = '';
    foreach ($node->childNodes as $childNode) {
        $html .= $node->ownerDocument->saveHTML($childNode);
    }
    return $html;
}

function entityFormMakePreviewSafe($html) {
    if (!class_exists('DOMDocument')) {
        return $html;
    }

    $previousState = libxml_use_internal_errors(true);
    $dom = new DOMDocument('1.0', 'UTF-8');
    $wrappedHtml = '<div id="entity-form-preview-root">' . $html . '</div>';
    $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($previousState);

    if (!$loaded) {
        return $html;
    }

    $wrapper = $dom->getElementById('entity-form-preview-root');
    if (!$wrapper) {
        return $html;
    }

    $xpath = new DOMXPath($dom);
    foreach ($xpath->query('.//input | .//select | .//textarea | .//button', $wrapper) as $element) {
        $element->removeAttribute('required');
        $element->removeAttribute('name');
        $element->removeAttribute('id');
        $element->setAttribute('disabled', 'disabled');

        if ($element->tagName === 'input') {
            $inputType = strtolower((string) $element->getAttribute('type'));
            if (in_array($inputType, ['checkbox', 'radio'], true)) {
                $element->removeAttribute('checked');
            }
        }
    }

    return entityFormInnerHtml($wrapper);
}

function entityFormApplyTemplateState($templateHtml, $fieldName, $fieldId, $rawValue) {
    if (!class_exists('DOMDocument')) {
        return $templateHtml;
    }

    $previousState = libxml_use_internal_errors(true);
    $dom = new DOMDocument('1.0', 'UTF-8');
    $wrappedHtml = '<div id="entity-form-root">' . $templateHtml . '</div>';
    $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($previousState);

    if (!$loaded) {
        return $templateHtml;
    }

    $wrapper = $dom->getElementById('entity-form-root');
    if (!$wrapper) {
        return $templateHtml;
    }

    $xpath = new DOMXPath($dom);
    foreach ($xpath->query('.//*[@id or @name or contains(@class, "pell")]', $wrapper) as $element) {
        if ($element->hasAttribute('id') && $element->getAttribute('id') === $fieldName) {
            $element->setAttribute('id', $fieldId);
        }

        if ($element->hasAttribute('name') && $element->getAttribute('name') === $fieldName) {
            $element->setAttribute('name', $fieldName);
        }

        $className = ' ' . $element->getAttribute('class') . ' ';
        if (strpos($className, ' pell ') !== false) {
            $element->setAttribute('data-field-name', $fieldName);
            $element->setAttribute('data-field-id', $fieldId);
            if (!$element->hasAttribute('id') || $element->getAttribute('id') === $fieldName) {
                $element->setAttribute('id', 'editor-' . $fieldId);
            }
        }
    }

    foreach ($xpath->query('.//select', $wrapper) as $select) {
        $matched = false;
        foreach ($xpath->query('.//option', $select) as $option) {
            if ($option->getAttribute('value') === (string) $rawValue) {
                $option->setAttribute('selected', 'selected');
                $matched = true;
            } else {
                $option->removeAttribute('selected');
            }
        }

        if (!$matched && trim((string) $rawValue) === '') {
            $firstOption = $select->getElementsByTagName('option')->item(0);
            if ($firstOption instanceof DOMElement) {
                $firstOption->setAttribute('selected', 'selected');
            }
        }
    }

    foreach ($xpath->query('.//textarea', $wrapper) as $textarea) {
        if (strpos(' ' . $textarea->getAttribute('class') . ' ', ' admin-hidden-html-sync ') !== false) {
            continue;
        }

        while ($textarea->firstChild) {
            $textarea->removeChild($textarea->firstChild);
        }
        $textarea->appendChild($dom->createTextNode((string) $rawValue));
    }

    foreach ($xpath->query('.//input', $wrapper) as $input) {
        $inputType = strtolower((string) $input->getAttribute('type'));
        $className = ' ' . $input->getAttribute('class') . ' ';

        if (strpos($className, ' edit-content ') !== false) {
            $input->setAttribute('value', (string) $rawValue);
            continue;
        }

        if ($inputType === 'checkbox') {
            if (!$input->hasAttribute('value') || $input->getAttribute('value') === '') {
                $input->setAttribute('value', 'on');
            }
            if (entityFormIsTruthy($rawValue)) {
                $input->setAttribute('checked', 'checked');
            } else {
                $input->removeAttribute('checked');
            }
            continue;
        }

        if ($inputType === 'radio') {
            if ($input->getAttribute('value') === (string) $rawValue) {
                $input->setAttribute('checked', 'checked');
            } else {
                $input->removeAttribute('checked');
            }
            continue;
        }

        if ($inputType === 'file') {
            continue;
        }

        if ($inputType !== 'password') {
            $input->setAttribute('value', (string) $rawValue);
        }
    }

    foreach ($xpath->query('.//*[@contenteditable="true"]', $wrapper) as $editable) {
        while ($editable->firstChild) {
            $editable->removeChild($editable->firstChild);
        }
        if ((string) $rawValue !== '') {
            $fragment = $dom->createDocumentFragment();
            if (@$fragment->appendXML((string) $rawValue)) {
                $editable->appendChild($fragment);
            } else {
                $editable->appendChild($dom->createTextNode((string) $rawValue));
            }
        }
    }

    return entityFormInnerHtml($wrapper);
}

function entityFormRenderInput($attribute, $rawValue) {
    $attributeId = (int) ($attribute['attribute_id'] ?? 0);
    $typeName = (string) ($attribute['type_name'] ?? 'text');
    $templateHtml = trim((string) ($attribute['type_input'] ?? ''));
    $fieldName = 'attr[' . $attributeId . ']';
    $fieldId = 'attr_' . $attributeId;

    if ($templateHtml === '') {
        $templateHtml = '<input type="text" name="{name}" id="{name}" value="{value}">';
    }

    $templateValue = entityFormIsMediaType($typeName)
        ? entityFormResolveSiteUrl() . ltrim((string) $rawValue, '/')
        : (string) $rawValue;

    $renderedHtml = str_replace(
        ['{name}', '{value}', '{id}'],
        [entityFormEscape($fieldName), entityFormEscape($templateValue), entityFormEscape($fieldId)],
        $templateHtml
    );

    return entityFormApplyTemplateState($renderedHtml, $fieldName, $fieldId, (string) $rawValue);
}

function entityFormRenderFieldCard($label, $fieldHtml, $isCheckbox = false, $fieldId = '', $extraClass = '') {
    $wrapperClass = 'admin-entity-field ' . trim($extraClass);
    if ($isCheckbox) {
        return '<div class="' . entityFormEscape(trim($wrapperClass)) . '"><div class="input-field checkbox-field"><label class="admin-checkbox-field">' . $fieldHtml . '<span class="admin-checkbox-field__label">' . entityFormEscape($label) . '</span></label></div></div>';
    }

    return '<div class="' . entityFormEscape(trim($wrapperClass)) . '"><div class="input-field"><label class="active" for="' . entityFormEscape($fieldId) . '">' . entityFormEscape($label) . '</label>' . $fieldHtml . '</div></div>';
}

function entityFormRenderStructuredField($attribute, $rawValue) {
    $attributeId = (int) ($attribute['attribute_id'] ?? 0);
    $attributeName = (string) ($attribute['attribute_name'] ?? 'Field');
    $fieldId = 'attr_' . $attributeId;
    $inputHtml = entityFormRenderInput($attribute, $rawValue);
    $isCheckbox = strpos(strtolower($inputHtml), 'type="checkbox"') !== false;

    return entityFormRenderFieldCard(entityFormFormatLabel($attributeName), $inputHtml, $isCheckbox, $fieldId);
}

function entityFormRenderContentWorkspace($attribute, $rawValue) {
    $attributeId = (int) ($attribute['attribute_id'] ?? 0);
    $fieldName = 'attr[' . $attributeId . ']';
    $inputHtml = entityFormRenderInput($attribute, $rawValue);
    $htmlValue = entityFormEscape((string) $rawValue);

    $html = '<div class="admin-editor-workspace" data-field-name="' . entityFormEscape($fieldName) . '">';
    $html .= '<div class="admin-editor-tabs"><button type="button" class="admin-editor-tab is-active" data-editor-tab="visual">Visual Editor</button><button type="button" class="admin-editor-tab" data-editor-tab="html">HTML Editor</button></div>';
    $html .= '<div class="admin-editor-pane is-active" data-editor-pane="visual">';
    $html .= '<div class="admin-editor-pane__intro"><h5>Visual Editor</h5><p>Edit rich content visually and keep the HTML in sync.</p></div>';
    $html .= '<div class="admin-editor-visual-shell">' . $inputHtml . '</div>';
    $html .= '</div>';
    $html .= '<div class="admin-editor-pane" data-editor-pane="html">';
    $html .= '<div class="admin-editor-pane__intro"><h5>HTML Editor</h5><p>Raw markup stays synced with the visual editor.</p></div>';
    $html .= '<textarea class="admin-raw-html-editor" data-field-name="' . entityFormEscape($fieldName) . '" spellcheck="false">' . $htmlValue . '</textarea>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

function entityFormRenderNameField($entityName) {
    $inputHtml = '<input type="text" id="entity_name" name="entity_name" value="' . entityFormEscape((string) $entityName) . '">';
    return entityFormRenderFieldCard('Name', $inputHtml, false, 'entity_name', 'admin-entity-field--primary');
}

function entityFormRenderMediaBrowserList() {
    $mediaDir = dirname(__DIR__) . '/media/';
    $mediaUrl = entityFormResolveSiteUrl() . 'media/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    if (!is_dir($mediaDir)) {
        return '';
    }

    $items = '';
    foreach (scandir($mediaDir) as $file) {
        $filePath = $mediaDir . $file;
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!is_file($filePath) || !in_array($extension, $allowedExtensions, true)) {
            continue;
        }

        $items .= '<img data-src="' . entityFormEscape($mediaUrl . $file) . '" alt="Media" style="max-width: 150px; margin: 5px;">';
    }

    if ($items === '') {
        return '';
    }

    return '<div class="images-browse-list" style="display:none;">' . $items . '</div>';
}

function entityFormRenderTemplateBrowserList() {
    $templates = getContentTemplates();
    if (empty($templates)) {
        return '';
    }

    $html = '<ul class="templates-browse-list" style="display:none;">';
    foreach ($templates as $template) {
        $rawHtml = (string) ($template['template_html'] ?? '');
        $name = ucfirst(strtolower(trim(preg_replace('/-+/', ' ', (string) ($template['name'] ?? 'Section')))));
        $encodedHtml = base64_encode($rawHtml);
        $previewHtml = entityFormMakePreviewSafe($rawHtml);

        $html .= '<li data-template-html-base64="' . entityFormEscape($encodedHtml) . '" data-template-label="' . entityFormEscape($name) . '" style="border:1px solid #ccc; padding:5px; width:200px; height:150px; overflow:hidden; position:relative; cursor:pointer;">'
            . '<div style="transform: scale(0.2); transform-origin: top left; width: 500%; pointer-events: none;">' . $previewHtml . '</div>'
            . '<div style="position:absolute; bottom:0; width:100%; background:rgba(255,255,255,0.8); text-align:center; font-size:10px; padding:2px 0;">' . entityFormEscape($name) . '</div>'
            . '</li>';
    }
    $html .= '</ul>';

    return $html;
}

function renderEntityForm($entityTypeName, $entityId = null) {
    $entityTypeRows = getEntityTypeByName($entityTypeName);
    $entityType = !empty($entityTypeRows) ? $entityTypeRows[0] : null;

    if (!$entityType) {
        return '<p>Invalid content type.</p>';
    }

    $entityTypeId = (int) ($entityType['id'] ?? 0);
    $attributes = getAttributesByEntityType($entityTypeId);
    $entity = null;
    $valueMap = [];

    if ($entityId !== null) {
        $entityRows = getEntity((int) $entityId);
        $entity = !empty($entityRows) ? $entityRows[0] : null;

        if (!$entity) {
            return '<p>Content item not found.</p>';
        }

        if ((int) ($entity['entity_type_id'] ?? 0) !== $entityTypeId) {
            return '<p>Content item does not belong to this section.</p>';
        }

        $attributeIds = array_map(static function ($attribute) {
            return (int) ($attribute['attribute_id'] ?? 0);
        }, $attributes);
        $valueMap = entityFormValueMap((int) $entityId, $attributeIds);
    }

    $contentAttribute = null;
    $structuredFields = [];
    foreach ($attributes as $attribute) {
        if (entityFormIsContentAttribute($attribute['attribute_name'] ?? '')) {
            $contentAttribute = $attribute;
            continue;
        }
        $structuredFields[] = $attribute;
    }

    $html = '';
    $html .= '<input type="hidden" name="entity_type_name" value="' . entityFormEscape($entityTypeName) . '">';
    $html .= '<input type="hidden" name="entity_type_id" value="' . entityFormEscape((string) $entityTypeId) . '">';
    $html .= '<input type="hidden" name="entity_id" value="' . entityFormEscape((string) ($entity['id'] ?? 0)) . '">';

    $entityName = (string) ($entity['name'] ?? '');
    $html .= '<div class="admin-editor-layout">';
    $html .= '<div class="admin-editor-main">';
    $html .= '<div class="admin-editor-surface">';

    if ($contentAttribute) {
        $contentAttributeId = (int) ($contentAttribute['attribute_id'] ?? 0);
        $html .= entityFormRenderContentWorkspace($contentAttribute, $valueMap[$contentAttributeId] ?? '');
    } else {
        $html .= '<div class="admin-editor-empty"><h5>No content editor</h5><p>This content type does not have a dedicated <strong>content</strong> field yet, so everything stays in the structured panel.</p></div>';
    }

    $html .= '</div>';
    $html .= '</div>';
    $html .= '<aside class="admin-editor-sidebar">';
    $html .= '<div class="admin-editor-sidebar__inner">';
    $html .= '<div class="admin-sidebar-card"><div class="admin-sidebar-card__label">Structured Fields</div>';
    $html .= entityFormRenderNameField($entityName);

    foreach ($structuredFields as $attribute) {
        $attributeId = (int) ($attribute['attribute_id'] ?? 0);
        $html .= entityFormRenderStructuredField($attribute, $valueMap[$attributeId] ?? '');
    }

    $html .= '</div>';
    $html .= '</div>';
    $html .= '</aside>';
    $html .= '</div>';
    $html .= entityFormRenderMediaBrowserList();
    $html .= entityFormRenderTemplateBrowserList();

    return $html;
}

?>

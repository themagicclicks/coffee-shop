<?php

require_once __DIR__ . '/../core/entities.php';
require_once __DIR__ . '/../core/mail.php';
require_once __DIR__ . '/../core/admin_client.php';

function getEntityPreviewTemplateHtml($templateId) {
    if (empty($templateId)) {
        return '';
    }

    $templateResult = db_connect(
        "SELECT preview_template_html FROM entity_templates WHERE id = ?",
        ['i'],
        [$templateId],
        'select'
    );

    return !empty($templateResult) ? $templateResult[0]['preview_template_html'] : '';
}

function buildEntityAttributeNameMap($attributeIds) {
    $attributeNames = [];
    foreach (getEntityAttributesByIds($attributeIds) as $attr) {
        $attributeNames[$attr['id']] = $attr['name'];
    }
    return $attributeNames;
}

function buildRenderedEntitiesForTypes($types, $filterBy = '') {
    $finalEntities = [];

    foreach ($types as $typeRow) {
        $entityTypeId = $typeRow['id'];
        $typeName = $typeRow['name'];
        $typeTitle = $typeRow['title'];
        $templateHtml = getEntityPreviewTemplateHtml($typeRow['template_id']);

        $attributeResults = getEntityAttributeIdsForType($entityTypeId);
        if (empty($attributeResults)) {
            continue;
        }

        $attributeIds = array_column($attributeResults, 'attribute_id');
        $attributeNames = buildEntityAttributeNameMap($attributeIds);
        $entities = getEntitiesByTypeId($entityTypeId);

        foreach ($entities as $entity) {
            $attributeData = getEntityAttributeDataForEntity($entity['id'], $attributeIds);

            $attrMap = [];
            foreach ($attributeData as $attr) {
                $attrName = $attributeNames[$attr['attribute_id']] ?? 'unknown';
                $attrMap[$attrName] = $attr['value'];
            }
			$attrMap['id'] = $entity['id'];
            $attrMap['name'] = $entity['name'];
            $attrMap['entity_type'] = $typeTitle;

            if ($filterBy && (!isset($attrMap[$filterBy]) || $attrMap[$filterBy] !== 'on')) {
                continue;
            }

            $filledTemplate = $templateHtml;
            foreach ($attrMap as $key => $value) {
                $filledTemplate = str_replace(
                    '{' . $key . '}',
                    strip_tags($value, '<p><strong><em><br><ul><li><span><br><div>'),
                    $filledTemplate
                );
            }

            $entityurl = SITE . $typeName . "/" . $entity['name'];
            $filledTemplate = str_replace('{branded_product_url}', $entityurl, $filledTemplate);
            $filledTemplate = str_replace('{unbranded_product_url}', $entityurl, $filledTemplate);

            $finalEntities[] = [
                'id' => $entity['id'],
                'name' => $entity['name'],
                'type_title' => $typeTitle,
                'created_at' => $entity['created_at'],
                'type' => $typeName,
                'attributes' => $attrMap,
                'rendered_html' => $filledTemplate
            ];
        }
    }

    return $finalEntities;
}

function __getMatchingEntities($type, $search, $searchtype) {
    $result = getEntityTypeByName($type);
    if (empty($result)) {
        return [];
    }

    return buildRenderedEntitiesForTypes([$result[0]]);
}

function __matchingEntitiesBlock($entityType) {
    $entities = getMatchingEntities($entityType, '', 'text');
    $response = '';
    $notfound = '<span style="display:none;" class="entityerror">Named Entity Not Found</span>';

    if (empty($entities)) {
        echo $notfound;
    } else {
        $response .= '<ul class="bespokeproducts">';
        foreach ($entities as $entity) {
            $response .= replaceSitePlaceholder($entity['rendered_html']);
        }
        $response .= '</ul>';
    }

    return $response;
}

function getMatchingEntities($entityStart, $entityEnd = '', $filterBy = '', $search = '', $searchtype = '') {
    $pattern = ($entityEnd !== '') ? $entityStart . '%' . $entityEnd : $entityStart . '%';
    $types = getEntityTypesByPattern($pattern);
    if (empty($types)) {
        return [];
    }

    return buildRenderedEntitiesForTypes($types, $filterBy);
}

function matchingEntitiesBlock($entityStart, $entityEnd, $filterBy, $entitiesListClass = 'bespokeproducts') {
    $entities = getMatchingEntities($entityStart, $entityEnd, $filterBy, '', 'text');
    $response = '';

    if (empty($entities)) {
        return $response;
    }

    $response .= '<ul class="' . $entitiesListClass . '">';
    foreach ($entities as $entity) {
        $response .= replaceSitePlaceholder($entity['rendered_html']);
    }
    $response .= '</ul>';

    return $response;
}

function renderEntityTemplate($entityData) {
    return renderEntityTemplateWithStack($entityData, []);
}

function renderEntityTemplateWithStack($entityData, $processingStack) {
    if (empty($entityData['template']) && (empty($entityData['entity']) || !isset($entityData['entity']['name']))) {
        return "<div class='entity-not-found'>Entity not found.</div>";
    }

    $fallbackTemplate = "
        <div class='entity'>
            <h1>{name}</h1>
            <ul>
                {attributes_list}
            </ul>
        </div>";

    $html = !empty($entityData['template']) ? $entityData['template'] : $fallbackTemplate;
    $html = processEmbeddedEntities($html, $processingStack);

    foreach ($entityData['entity'] as $key => $value) {
        if (is_string($value) && strpos($value, '{{entity') !== false) {
            $entityData['entity'][$key] = processEmbeddedEntities($value, $processingStack);
        }
    }

    foreach ($entityData['attributes'] as &$attribute) {
        if (is_string($attribute['value']) && strpos($attribute['value'], '{{entity') !== false) {
            $attribute['value'] = processEmbeddedEntities($attribute['value'], $processingStack);
        }
    }
    unset($attribute);

    $html = preg_replace_callback('/<a[^>]*?class="carousel-item"[^>]*?>.*?<img[^>]*?src="\{([^}]+)\}"[^>]*?>.*?<\/a>/is', function ($match) use ($entityData) {
        $attributeKey = $match[1];
        $value = $entityData['entity'][$attributeKey] ?? null;

        if ($value === null) {
            foreach ($entityData['attributes'] as $attr) {
                if ($attr['name'] === $attributeKey) {
                    $value = $attr['value'];
                    break;
                }
            }
        }

        return empty($value) ? '' : $match[0];
    }, $html);

    foreach ($entityData['entity'] as $key => $value) {
        if (is_string($value) && preg_match('/\.(jpg|jpeg|png|gif|webp|mp4|webm|ogg|pdf)$/i', $value)) {
            $value = SITE . ltrim($value, '/');
        }
        $html = str_replace('{' . $key . '}', $value, $html);
    }

    $attributesList = '';
    foreach ($entityData['attributes'] as $attribute) {
        $val = $attribute['value'];
        if (is_string($val) && preg_match('/\.(jpg|jpeg|png|gif|webp|mp4|webm|ogg|pdf)$/i', $val)) {
            $val = SITE . ltrim($val, '/');
        }

        $attributesList .= '<li><strong>' . htmlspecialchars($attribute['name']) . ':</strong> ' . htmlspecialchars($val) . '</li>';
        $html = str_replace('{' . $attribute['name'] . '}', htmlspecialchars($val), $html);
    }

    $html = str_replace('{attributes_list}', $attributesList, $html);
    $html = replaceCurrentPageUrl($html);
    $html = processEmbeddedEntities(htmlspecialchars_decode($html), $processingStack);

    return htmlspecialchars_decode($html);
}

function replaceCurrentPageUrl($html) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return str_replace('{current_page_url}', $currentUrl, $html);
}

function processEmbeddedEntities($template, $processingStack = []) {
    $previousTemplate = null;

    do {
        $previousTemplate = $template;
        $template = preg_replace_callback('/{{entity type="([^"]+)" name="([^"]+)"(?: template-type="([^"]+)")?}}/', function ($matches) use ($processingStack) {
            $embeddedType = $matches[1];
            $embeddedName = $matches[2];
            $templateType = isset($matches[3]) ? $matches[3] : 'main';
            $uniqueKey = $embeddedType . ':' . $embeddedName;

            if (in_array($uniqueKey, $processingStack, true)) {
                return "<!-- Circular reference detected: $uniqueKey -->";
            }

            $newStack = $processingStack;
            $newStack[] = $uniqueKey;

            $embeddedEntity = getMatchingEntity($embeddedName, 0, 0, $embeddedType);
            if (!empty($embeddedEntity)) {
                return ($templateType === 'preview_html_template')
                    ? renderEntityPreviewTemplate($embeddedEntity, $newStack)
                    : renderEntityTemplateWithStack($embeddedEntity, $newStack);
            }

            return "<!-- Missing entity: $embeddedType - $embeddedName -->";
        }, $template);
    } while ($template !== $previousTemplate);

    return $template;
}

function renderEntityPreviewTemplate($entityData, $processingStack = []) {
    $fallbackTemplate = "
        <div class='entity-preview'>
            <h3>{{entity_name}}</h3>
            <p><strong>ID:</strong> {{entity_id}}</p>
            <p><strong>Created At:</strong> {{created_at}}</p>
            <ul>
                {{attributes_list}}
            </ul>
        </div>
    ";
    //print_r($entityData);
    $templateToUse = !empty($entityData['preview_template']) ? $entityData['preview_template'] : $fallbackTemplate;
    $renderedHtml = str_replace('{{entity_id}}', htmlspecialchars($entityData['id'] ?? ''), $templateToUse);
    $renderedHtml = str_replace('{{entity_name}}', htmlspecialchars($entityData['name'] ?? ''), $renderedHtml);
    $renderedHtml = str_replace('{{created_at}}', htmlspecialchars($entityData['created_at'] ?? ''), $renderedHtml);

    $attributesHtml = '';
    foreach (($entityData['attributes'] ?? []) as $attributeName => $attributeValue) {
        $placeholder = '{{' . strtolower(str_replace(' ', '_', $attributeName)) . '}}';
        $renderedHtml = str_replace($placeholder, htmlspecialchars($attributeValue), $renderedHtml);
        $attributesHtml .= '<li><strong>' . htmlspecialchars($attributeName) . ':</strong> ' . htmlspecialchars($attributeValue) . '</li>';
    }

    $renderedHtml = str_replace('{{attributes_list}}', $attributesHtml, $renderedHtml);
    return processEmbeddedEntities(htmlspecialchars_decode($renderedHtml), $processingStack);
}

function renderPageSnippet($entityType) {
    $snippetData = getSnippetContentByName(trim((string) $entityType));
    if (empty($snippetData)) {
        return '';
    }

    $finalHtml = str_replace('{content}', $snippetData['content'], $snippetData['template_html']);
    return replaceSitePlaceholder($finalHtml);
}

function cacheExists($cacheDir, $entityName, $expiry = 600) {
    $cacheFile = "{$cacheDir}{$entityName}.json";
    return file_exists($cacheFile) && (time() - filemtime($cacheFile) < $expiry);
}

function readCache($cacheDir, $entityName) {
    $cacheFile = "{$cacheDir}{$entityName}.json";
    if (!file_exists($cacheFile)) {
        return null;
    }
    return json_decode(file_get_contents($cacheFile), true);
}

function writeCache($cacheDir, $entityName, $entityData) {
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }

    file_put_contents("{$cacheDir}{$entityName}.json", json_encode($entityData));
}

function generateCacheKey($entityName, $entityId, $entityTypeName, $entityTypeId) {
    if ($entityId) {
        return "entity_{$entityId}";
    }
    if ($entityName && $entityTypeId) {
        return "entity_{$entityTypeId}_{$entityName}";
    }
    if ($entityName && $entityTypeName) {
        return "entity_{$entityTypeName}_{$entityName}";
    }
    return false;
}

function getActiveThemeName() {
    static $themeName = null;

    if ($themeName !== null) {
        return $themeName;
    }

    $config = loadAdminClientConfig(dirname(__DIR__) . '/config/admin_client.json');
    $themeName = strtolower(trim((string) ($config['theme_name'] ?? 'dark-coffee')));
    $themeName = preg_replace('/[^a-z0-9\-_]/', '', $themeName);
    return $themeName !== '' ? $themeName : 'dark-coffee';
}

function getActiveThemeBaseUrl() {
    return SITE . 'themes/' . getActiveThemeName() . '/';
}

function themeAssetUrl($assetPath) {
    return getActiveThemeBaseUrl() . ltrim((string) $assetPath, '/');
}

function replaceSitePlaceholder($html) {
    return str_replace('##SITE##', SITE, $html);
}

function getBrandedPackagingOptions() {
    $optionsHTML = '';
    $entities = getEntityByType(13);

    foreach ($entities as $entity) {
        $imgResult = db_connect(
            "SELECT value FROM entity_attribute_data WHERE entity_id = ? AND attribute_id = ? LIMIT 1",
            ['i', 'i'],
            [$entity['id'], 15],
            'select'
        );

        $imageUrl = $imgResult ? htmlspecialchars($imgResult[0]['value']) : '';
        if ($imageUrl) {
            $entityName = htmlspecialchars($entity['name']);
            $optionsHTML .= '<option value="' . $entityName . '" data-icon="' . $imageUrl . '" class="left" style="height: 36px;">' . ucwords(str_replace('-', ' ', $entityName)) . '</option>' . PHP_EOL;
        }
    }

    return $optionsHTML;
}

function replaceProductsOptionPlaceholder($html) {
    return str_replace('##BRANDEDPACKAGINGOPTIONS##', getBrandedPackagingOptions(), $html);
}

function humanizeEntitySlug($value) {
    return ucwords(str_replace(['-', '_'], ' ', trim((string) $value)));
}

function getPrintableMenuSections() {
    $sections = [];
    $types = getEntityTypesByPattern('menu-%-drink');

    foreach ($types as $typeRow) {
        $entityTypeId = (int) ($typeRow['id'] ?? 0);
        if ($entityTypeId <= 0) {
            continue;
        }

        $typeName = (string) ($typeRow['name'] ?? '');
        $sectionTitle = trim((string) ($typeRow['title'] ?? ''));
        if ($sectionTitle === '') {
            $sectionTitle = humanizeEntitySlug(str_replace(['menu-', '-drink'], '', $typeName));
        }

        $attributeDefinitions = getAttributesByEntityType($entityTypeId);
        $attributeIds = array_column($attributeDefinitions, 'attribute_id');
        $attributeNames = buildEntityAttributeNameMap($attributeIds);
        $entities = getEntitiesByTypeId($entityTypeId);
        $items = [];

        foreach ($entities as $entity) {
            $attributeData = getEntityAttributeDataForEntity($entity['id'], $attributeIds);
            $attributeMap = [];
            foreach ($attributeData as $attr) {
                $attrName = $attributeNames[$attr['attribute_id']] ?? '';
                if ($attrName !== '') {
                    $attributeMap[$attrName] = (string) ($attr['value'] ?? '');
                }
            }

            $itemTitle = trim((string) ($attributeMap['title'] ?? ''));
            //if ($itemTitle === '') {
            //    $itemTitle = humanizeEntitySlug($entity['name'] ?? 'Menu Item');
            //}

            $itemSubtitle = trim((string) ($attributeMap['sub_title'] ?? ''));
            //if ($itemSubtitle === '') {
            //    $itemSubtitle = trim((string) ($attributeMap['description'] ?? ''));
            //}
            //if ($itemSubtitle === '') {
            //    $itemSubtitle = trim((string) ($attributeMap['content'] ?? ''));
            //}
            //$itemSubtitle = trim(strip_tags($itemSubtitle));

            $itemPrice = trim((string) ($attributeMap['Price'] ?? ''));
            //if ($itemPrice === '') {
            //    $itemPrice = trim((string) ($attributeMap['sale_price'] ?? ''));
            //}

            $items[] = [
                'title' => $itemTitle,
                'sub_title' => $itemSubtitle,
                'Price' => $itemPrice,
            ];
        }

        if (!empty($items)) {
            $sections[] = [
                'title' => $sectionTitle,
                'items' => $items,
            ];
        }
    }

    return $sections;
}

function getMenuPdfTemplateMarkup() {
    $savedHtml = function_exists('adminClientLoadFormattedMenuPdfHtml')
        ? adminClientLoadFormattedMenuPdfHtml()
        : '';

    if (trim((string) $savedHtml) !== '') {
        return $savedHtml;
    }

    $menuPdfSections = getPrintableMenuSections();
    ob_start();
    include BASE . 'includes/menu-template.php';
    return (string) ob_get_clean();
}

?>




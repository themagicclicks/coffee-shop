<?php

require_once __DIR__ . '/db.php';

function sanitizeEntityTypeName($name) {
    return preg_replace('/[^a-zA-Z_-]/', '', str_replace(' ', '-', $name));
}

function sanitizeEntityAttributeName($name) {
    return str_replace(' ', '-', $name);
}

function createEntityType($name, $title, $templateid) {
    $query = "INSERT INTO entity_types (name, title, template_id) VALUES (?, ?, ?)";
    return db_connect($query, ['s', 's', 'i'], [strtolower(str_replace(' ', '-', $name)), $title, intval($templateid)], 'insert');
}

function getEntityType($id) {
    return db_connect("SELECT * FROM entity_types WHERE id = ?", ['i'], [$id], 'select');
}

function getEntityTypeByName($name) {
    $normalizedName = sanitizeEntityTypeName($name);
    return db_connect("SELECT * FROM entity_types WHERE LOWER(name) = LOWER(?)", ['s'], [$normalizedName], 'select');
}

function getEntityTypes() {
    return db_connect("SELECT * FROM entity_types ORDER BY name ASC", [], [], 'select');
}

function updateEntityType($id, $newName, $title, $templateid) {
    return db_connect(
        "UPDATE entity_types SET name = ?, title = ?, template_id = ? WHERE id = ?",
        ['s', 's', 'i', 'i'],
        [$newName, $title, $templateid, $id],
        'update'
    );
}

function deleteEntityType($id) {
    return db_connect("DELETE FROM entity_types WHERE id = ?", ['i'], [$id], 'delete');
}

function getEntityTitle($entityType) {
    if ($entityType === '') {
        return '';
    }

    $result = db_connect("SELECT title FROM entity_types WHERE name = ?", ['s'], [$entityType], 'select');
    return !empty($result) ? $result[0]['title'] : '';
}

function foundEntityTypes($word) {
    if ($word === '') {
        return false;
    }

    $result = db_connect("SELECT title FROM entity_types WHERE name LIKE ?", ['s'], ['%' . $word . '%'], 'select');
    return !empty($result);
}

function getEntityTypesByPattern($pattern) {
    return db_connect(
        "SELECT id, name, title, template_id FROM entity_types WHERE name LIKE ?",
        ['s'],
        [$pattern],
        'select'
    );
}

function createEntity($name, $typeId) {
    return db_connect("INSERT INTO entities (name, entity_type_id) VALUES (?, ?)", ['s', 'i'], [$name, $typeId], 'insert');
}

function getEntity($entityId) {
    return db_connect("SELECT * FROM entities WHERE id = ?", ['i'], [intval($entityId)], 'select');
}

function getEntityByType($entityTypeId) {
    return db_connect("SELECT * FROM entities WHERE entity_type_id = ?", ['i'], [intval($entityTypeId)], 'select');
}


function getEntityByNameAndTypeId($entityName, $entityTypeId) {
    return db_connect(
        "SELECT * FROM entities WHERE name = ? AND entity_type_id = ?",
        ['s', 'i'],
        [$entityName, $entityTypeId],
        'select'
    );
}

function getAttributeByName($attributeName) {
    return db_connect(
        "SELECT id, name FROM entity_attributes WHERE LOWER(name) = LOWER(?) LIMIT 1",
        ['s'],
        [$attributeName],
        'select'
    );
}

function clearTruthyAttributeFromOtherEntities($entityTypeId, $attributeId, $currentEntityId) {
    $otherEntities = db_connect(
        "SELECT id FROM entities WHERE entity_type_id = ? AND id != ?",
        ['i', 'i'],
        [$entityTypeId, $currentEntityId],
        'select'
    );

    foreach ($otherEntities as $entityRow) {
        $otherEntityId = (int) ($entityRow['id'] ?? 0);
        if ($otherEntityId <= 0) {
            continue;
        }
        setEntityAttributeValue($otherEntityId, $attributeId, '');
    }
}

function getEntityNameByTruthyAttribute($entityTypeName, $attributeName) {
    $rows = db_connect(
        "SELECT e.name
         FROM entities e
         INNER JOIN entity_types et ON e.entity_type_id = et.id
         INNER JOIN entity_attribute_data ead ON e.id = ead.entity_id
         INNER JOIN entity_attributes ea ON ead.attribute_id = ea.id
         WHERE et.name = ?
           AND ea.name = ?
           AND LOWER(TRIM(ead.value)) IN ('1', 'true', 'yes', 'on')
         ORDER BY e.id DESC
         LIMIT 1",
        ['s', 's'],
        [$entityTypeName, $attributeName],
        'select'
    );

    return !empty($rows) ? (string) ($rows[0]['name'] ?? '') : '';
}
function updateEntity($id, $newName) {
    return db_connect("UPDATE entities SET name = ? WHERE id = ?", ['s', 'i'], [$newName, $id], 'update');
}

function deleteEntity($entityId) {
    return db_connect("DELETE FROM entities WHERE id = ?", ['i'], [$entityId], 'delete');
}

function getEntitiesByTypeId($entityTypeId) {
    return db_connect("SELECT id, name, created_at FROM entities WHERE entity_type_id = ?", ['i'], [$entityTypeId], 'select');
}

function getEntitiesByTypeIdForDate($entityTypeId, $date) {
    $date = trim((string) $date);
    if ($date === '') {
        return getEntitiesByTypeId($entityTypeId);
    }

    return db_connect(
        "SELECT id, name, created_at FROM entities WHERE entity_type_id = ? AND DATE(created_at) = ? ORDER BY created_at DESC, id DESC",
        ['i', 's'],
        [$entityTypeId, $date],
        'select'
    );
}

function createEntityAttribute($name) {
    return db_connect("INSERT INTO entity_attributes (name) VALUES (?)", ['s'], [$name], 'insert');
}

function getEntityAttribute($id) {
    return db_connect("SELECT * FROM entity_attributes WHERE id = ?", ['i'], [$id], 'select');
}

function getEntityAttributeByName($name) {
    return db_connect(
        "SELECT * FROM entity_attributes WHERE LOWER(name) = LOWER(?)",
        ['s'],
        [sanitizeEntityAttributeName($name)],
        'select'
    );
}

function updateEntityAttribute($id, $newName) {
    return db_connect("UPDATE entity_attributes SET name = ? WHERE id = ?", ['s', 'i'], [$newName, $id], 'update');
}

function deleteEntityAttribute($id) {
    return db_connect("DELETE FROM entity_attributes WHERE id = ?", ['i'], [$id], 'delete');
}

function getAttributesByEntityType($entityTypeId) {
    $query = "
        SELECT
            ea.id AS attribute_id,
            ea.name AS attribute_name,
            ift.id AS input_type_id,
            ift.type_name,
            ift.type_type,
            ift.type_input
        FROM entity_attributes ea
        INNER JOIN entity_attribute_map eam ON ea.id = eam.attribute_id
        LEFT JOIN entity_attribute_input_map eaim ON ea.id = eaim.attribute_id
        LEFT JOIN input_field_types ift ON eaim.input_type_id = ift.id
        WHERE eam.entity_type_id = ?
        ORDER BY eam.attribute_order ASC
    ";

    return db_connect($query, ['i'], [intval($entityTypeId)], 'select');
}

function getEntityAttributeIdsForType($entityTypeId) {
    return db_connect(
        "SELECT attribute_id FROM entity_attribute_map WHERE entity_type_id = ?",
        ['i'],
        [$entityTypeId],
        'select'
    );
}

function getEntityAttributesByIds($attributeIds) {
    if (empty($attributeIds)) {
        return [];
    }

    return db_connect(
        "SELECT id, name FROM entity_attributes WHERE id IN (" . implode(',', array_map('intval', $attributeIds)) . ")",
        [],
        [],
        'select'
    );
}

function mapAttributeToEntityType($entityTypeId, $attributeId, $attributeOrder = 0) {
    return db_connect(
        "INSERT INTO entity_attribute_map (entity_type_id, attribute_id, attribute_order) VALUES (?, ?, ?)",
        ['i', 'i', 'i'],
        [$entityTypeId, $attributeId, $attributeOrder],
        'insert'
    );
}

function getEntityTypeAttributes($typeId) {
    $query = "SELECT ea.* FROM entity_attributes ea JOIN entity_attribute_map eam ON ea.id = eam.attribute_id WHERE eam.entity_type_id = ?";
    return db_connect($query, ['i'], [$typeId], 'select');
}

function getEntityTypeAttributesByEntityTypeId($entitytypeId) {
    return db_connect("SELECT * FROM entity_attribute_map WHERE entity_type_id = ?", ['i'], [$entitytypeId], 'select');
}

function getEntityTypeAttributesByAttributeId($attributeId) {
    return db_connect("SELECT * FROM entity_attribute_map WHERE attribute_id = ?", ['i'], [$attributeId], 'select');
}

function unmapAttributeFromEntityType($typeId, $attributeId) {
    return db_connect(
        "DELETE FROM entity_attribute_map WHERE entity_type_id = ? AND attribute_id = ?",
        ['i', 'i'],
        [$typeId, $attributeId],
        'delete'
    );
}

function unmapAllAttributeFromEntityType($typeId) {
    return db_connect("DELETE FROM entity_attribute_map WHERE entity_type_id = ?", ['i'], [$typeId], 'delete');
}

function setEntityAttributeValue($entityId, $attributeId, $value) {
    $existing = db_connect(
        "SELECT id FROM entity_attribute_data WHERE entity_id = ? AND attribute_id = ? LIMIT 1",
        ['i', 'i'],
        [$entityId, $attributeId],
        'select'
    );

    if (!empty($existing) && isset($existing[0]['id'])) {
        return db_connect(
            "UPDATE entity_attribute_data SET value = ? WHERE entity_id = ? AND attribute_id = ?",
            ['s', 'i', 'i'],
            [$value, $entityId, $attributeId],
            'update'
        );
    }

    return db_connect(
        "INSERT INTO entity_attribute_data (entity_id, attribute_id, value) VALUES (?, ?, ?)",
        ['i', 'i', 's'],
        [$entityId, $attributeId, $value],
        'insert'
    );
}

function getEntityAttributeValues($entityId) {
    $query = "SELECT ea.name, ead.value FROM entity_attribute_data ead JOIN entity_attributes ea ON ead.attribute_id = ea.id WHERE ead.entity_id = ?";
    return db_connect($query, ['i'], [$entityId], 'select');
}

function getEntityAttributeValuesForEntities($entityIds) {
    $entityIds = array_values(array_filter(array_map('intval', (array) $entityIds)));
    if (empty($entityIds)) {
        return [];
    }

    return db_connect(
        "SELECT ead.entity_id, ea.name, ead.value
         FROM entity_attribute_data ead
         JOIN entity_attributes ea ON ead.attribute_id = ea.id
         WHERE ead.entity_id IN (" . implode(',', $entityIds) . ")
         ORDER BY ead.entity_id ASC, ea.name ASC",
        [],
        [],
        'select'
    );
}

function getEntityAttributeDataForEntity($entityId, $attributeIds = []) {
    if (empty($attributeIds)) {
        return db_connect("SELECT attribute_id, value FROM entity_attribute_data WHERE entity_id = ?", ['i'], [$entityId], 'select');
    }

    return db_connect(
        "SELECT attribute_id, value FROM entity_attribute_data WHERE entity_id = ? AND attribute_id IN (" . implode(',', array_map('intval', $attributeIds)) . ")",
        ['i'],
        [$entityId],
        'select'
    );
}

function deleteEntityAttributeValue($entityId, $attributeId) {
    return db_connect(
        "DELETE FROM entity_attribute_data WHERE entity_id = ? AND attribute_id = ?",
        ['i', 'i'],
        [$entityId, $attributeId],
        'delete'
    );
}

function deleteEntityAttributeDataByEntityId($entityId) {
    return db_connect("DELETE FROM entity_attribute_data WHERE entity_id = ?", ['i'], [$entityId], 'delete');
}

function createEntityState($name) {
    return db_connect("INSERT INTO entity_states (state_name) VALUES (?)", ['s'], [$name], 'insert');
}

function getEntityState($id) {
    return db_connect("SELECT * FROM entity_states WHERE id = ?", ['i'], [$id], 'select');
}

function getEntityStatebyName($name) {
    return db_connect("SELECT * FROM entity_states WHERE state_name = ?", ['s'], [$name], 'select');
}

function updateEntityState($id, $newName) {
    return db_connect("UPDATE entity_states SET state_name = ? WHERE id = ?", ['s', 'i'], [$newName, $id], 'update');
}

function deleteEntityState($id) {
    return db_connect("DELETE FROM entity_states WHERE id = ?", ['i'], [$id], 'delete');
}

function setEntityMapState($entityId, $stateId) {
    return db_connect("INSERT INTO entity_state_map (entity_id, state_id) VALUES (?, ?)", ['i', 'i'], [$entityId, $stateId], 'insert');
}

function updateEntityMapState($entityId, $stateId) {
    return db_connect("UPDATE entity_state_map SET state_id = ? WHERE entity_id = ?", ['i', 'i'], [$stateId, $entityId], 'update');
}

function getEntityStateByEntity($entityId) {
    $query = "SELECT esm.state_id, es.state_name FROM entity_state_map esm JOIN entity_states es ON esm.state_id = es.id WHERE esm.entity_id = ?";
    return db_connect($query, ['i'], [$entityId], 'select');
}

function deleteEntityStateMap($entityId) {
    return db_connect("DELETE FROM entity_state_map WHERE entity_id = ?", ['i'], [$entityId], 'delete');
}

function insertInputFieldType($typeName, $typeType, $typeInput) {
    return db_connect(
        "INSERT INTO input_field_types (type_name, type_type, type_input) VALUES (?, ?, ?)",
        ['s', 's', 's'],
        [$typeName, $typeType, $typeInput],
        'insert'
    );
}

function updateInputFieldType($id, $typeName, $typeType, $typeInput) {
    return db_connect(
        "UPDATE input_field_types SET type_name = ?, type_type = ?, type_input = ? WHERE id = ?",
        ['s', 's', 's', 'i'],
        [$typeName, $typeType, $typeInput, intval($id)],
        'update'
    );
}

function getInputFieldTypes() {
    return db_connect("SELECT * FROM input_field_types", [], [], 'select');
}

function getInputFieldType($inputtypeid) {
    return db_connect("SELECT * FROM input_field_types WHERE id = ?", ['i'], [$inputtypeid], 'select');
}

function getInputFieldTypeByName($inputtypename) {
    return db_connect("SELECT * FROM input_field_types WHERE type_name = ?", ['s'], [$inputtypename], 'select');
}

function deleteInputFieldType($typeId) {
    return db_connect("DELETE FROM input_field_types WHERE id = ?", ['i'], [$typeId], 'delete');
}

function insertEntityAttributeInputMap($attributeId, $inputTypeId) {
    return db_connect(
        "INSERT INTO entity_attribute_input_map (attribute_id, input_type_id) VALUES (?, ?)",
        ['i', 'i'],
        [$attributeId, $inputTypeId],
        'insert'
    );
}

function getInputFieldTypeByAttribute($attributeId) {
    $query = "SELECT i.id, i.type_name, i.type_type, i.type_input FROM input_field_types i JOIN entity_attribute_input_map m ON i.id = m.input_type_id WHERE m.attribute_id = ?";
    return db_connect($query, ['i'], [$attributeId], 'select');
}

function getInputFieldTypeByInput($inputId) {
    return db_connect("SELECT * FROM entity_attribute_input_map WHERE input_type_id = ?", ['i'], [$inputId], 'select');
}

function deleteEntityAttributeInputMap($mapId) {
    return db_connect("DELETE FROM entity_attribute_input_map WHERE id = ?", ['i'], [$mapId], 'delete');
}

function deleteEntityAttributeInputMapByAttributeId($attributeId) {
    return db_connect("DELETE FROM entity_attribute_input_map WHERE attribute_id = ?", ['i'], [$attributeId], 'delete');
}

function getEntityTemplates() {
    return db_connect("SELECT * FROM entity_templates", [], [], 'select');
}

function getEntityTemplate($id) {
    return db_connect("SELECT * FROM entity_templates WHERE id = ?", ['i'], [$id], 'select');
}

function getEntityTemplateByName($name) {
    return db_connect("SELECT * FROM entity_templates WHERE template_name = ?", ['s'], [$name], 'select');
}

function createEntityTemplate($templateName, $templateHtml, $previewTemplateHtml) {
    return db_connect(
        "INSERT INTO entity_templates (template_name, template_html, preview_template_html) VALUES (?, ?, ?)",
        ['s', 's', 's'],
        [$templateName, $templateHtml, $previewTemplateHtml],
        'insert'
    );
}

function updateEntityTemplate($id, $templateName, $templateHtml, $previewTemplateHtml) {
    return db_connect(
        "UPDATE entity_templates SET template_name = ?, template_html = ?, preview_template_html = ? WHERE id = ?",
        ['s', 's', 's', 'i'],
        [$templateName, $templateHtml, $previewTemplateHtml, $id],
        'update'
    );
}

function deleteEntityTemplate($id) {
    $checkResult = db_connect("SELECT COUNT(*) AS count FROM entity_types WHERE template_id = ?", ['i'], [$id], 'select');
    if ($checkResult && $checkResult[0]['count'] > 0) {
        return false;
    }

    return db_connect("DELETE FROM entity_templates WHERE id = ?", ['i'], [$id], 'delete');
}

function getMatchingEntity($entityname = '', $entityid = 0, $entitytypeid = 0, $entitytypename = '') {
    if ((!$entityid && !$entityname) || (!$entitytypeid && !$entitytypename)) {
        return ['error' => 'Either entity ID or name AND either type ID or name must be provided.'];
    }

    if (!$entitytypeid && $entitytypename) {
        $result = db_connect("SELECT id, template_id FROM entity_types WHERE name = ?", ['s'], [$entitytypename], 'select');
        if (empty($result)) {
            return ['error' => 'Entity type not found.'];
        }

        $entitytypeid = $result[0]['id'];
        $templateId = $result[0]['template_id'];
    }

    if (!$entityid && $entityname) {
        $result = db_connect(
            "SELECT id FROM entities WHERE name = ? AND entity_type_id = ?",
            ['s', 'i'],
            [$entityname, $entitytypeid],
            'select'
        );
        if (empty($result)) {
            return ['error' => 'Entity not found.'];
        }

        $entityid = $result[0]['id'];
    }

    $entityData = db_connect("SELECT id, name, entity_type_id, created_at FROM entities WHERE id = ?", ['i'], [$entityid], 'select');
    if (empty($entityData)) {
        return ['error' => 'Entity not found.'];
    }

    $attributes = db_connect(
        "SELECT ea.name, ead.value FROM entity_attribute_data ead JOIN entity_attributes ea ON ead.attribute_id = ea.id WHERE ead.entity_id = ?",
        ['i'],
        [$entityid],
        'select'
    );

    $templateHtml = '';
    if (isset($templateId) && $templateId) {
        $templateResult = db_connect("SELECT template_html FROM entity_templates WHERE id = ?", ['i'], [$templateId], 'select');
        if (!empty($templateResult)) {
            $templateHtml = $templateResult[0]['template_html'];
        }
    }

    return [
        'entity' => $entityData[0],
        'attributes' => $attributes,
        'template' => $templateHtml
    ];
}

function getContentTemplates() {
    $query = '
        SELECT
            entities.*,
            entity_attribute_data.value AS template_html
        FROM entities, entity_attribute_data
        WHERE entities.entity_type_id = ?
          AND entities.id = entity_attribute_data.entity_id
          AND entity_attribute_data.attribute_id = ?
        ORDER BY entities.id ASC
    ';

    return db_connect($query, ['i', 'i'], [12, 10], 'select');
}

function getSnippetContentByName($snippetName) {
    $templateRows = db_connect(
        "SELECT entity_templates.template_html
         FROM entity_types
         JOIN entity_templates ON entity_types.template_id = entity_templates.id
         WHERE entity_types.name = ?",
        ['s'],
        ['snippets'],
        'select'
    );

    if (empty($templateRows)) {
        return [];
    }

    $typeRows = getEntityTypeByName('snippets');
    if (empty($typeRows)) {
        return [];
    }

    $snippetRows = db_connect(
        "SELECT * FROM entities WHERE entity_type_id = ? AND name = ? ORDER BY id ASC LIMIT 1",
        ['i', 's'],
        [(int) $typeRows[0]['id'], $snippetName],
        'select'
    );

    if (empty($snippetRows)) {
        return [];
    }

    $contentRows = db_connect(
        "SELECT value FROM entity_attribute_data ead
         JOIN entity_attributes a ON ead.attribute_id = a.id
         WHERE ead.entity_id = ? AND a.name = 'content'
         LIMIT 1",
        ['i'],
        [$snippetRows[0]['id']],
        'select'
    );

    if (empty($contentRows)) {
        return [];
    }

    return [
        'template_html' => $templateRows[0]['template_html'],
        'content' => $contentRows[0]['value'],
        'entity' => $snippetRows[0]
    ];
}

function updateEntityRelations($entityId, $templateHtml) {
    db_connect("DELETE FROM entity_relations WHERE parent_entity_id = ?", ['i'], [$entityId], 'delete');

    preg_match_all('/{{entity type="([^"]+)" name="([^"]+)"}}/', $templateHtml, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $result = db_connect(
            "SELECT id FROM entities WHERE name = ? AND entity_type_id = (SELECT id FROM entity_types WHERE name = ?)",
            ['s', 's'],
            [$match[2], $match[1]],
            'select'
        );

        if (empty($result)) {
            continue;
        }

        $childEntityId = $result[0]['id'];
        $relationExists = db_connect(
            "SELECT id FROM entity_relations WHERE parent_entity_id = ? AND child_entity_id = ?",
            ['i', 'i'],
            [$entityId, $childEntityId],
            'select'
        );

        if (empty($relationExists)) {
            db_connect(
                "INSERT INTO entity_relations (parent_entity_id, child_entity_id) VALUES (?, ?)",
                ['i', 'i'],
                [$entityId, $childEntityId],
                'insert'
            );
        }
    }
}

function getEntityTypeBySlug($slug) {
    $checkResult = db_connect("SELECT COUNT(*) AS count FROM entity_types WHERE name = ?", ['s'], [$slug], 'select');
    if (!$checkResult) {
        return false;
    }

    if (isset($checkResult[0]['count'])) {
        return $checkResult[0]['count'] > 0;
    }

    if (isset($checkResult['count'])) {
        return $checkResult['count'] > 0;
    }

    return false;
}

?>








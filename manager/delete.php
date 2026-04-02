<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

include_once '../includes/__functions.php.bak';

$page = isset($_GET['page']) ? strtolower(str_replace(' ', '_', $_GET['page'])) : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0 || empty($page)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request. Missing or incorrect parameters.'
    ]);
    exit;
}

switch ($page) {
    // =================== ENTITY TYPES ===================
    case 'entity_types':
        $existingEntities = getEntityByType($id);
        if (!empty($existingEntities)) {
            echo json_encode([
                'success' => false,
                'message' => "Cannot delete. There are entities linked to this entity type."
            ]);
            exit;
        }

        unmapAllAttributeFromEntityType($id);
        $deleted = deleteEntityType($id);

        echo json_encode([
            'success' => $deleted,
            'message' => $deleted ? "Entity type deleted successfully." : "Failed to delete entity type."
        ]);
        exit;

    // =================== ENTITY TEMPLATES ===================
    case 'entity_templates':
        $deleted = deleteEntityTemplate($id);
        echo json_encode([
            'success' => $deleted,
            'message' => $deleted ? "Entity template deleted successfully." : "Failed to delete entity template. It may be in use by one or more entity types."
        ]);
        exit;

    // =================== ENTITY ATTRIBUTES ===================
    case 'entity_attributes':
        if(count(getEntityTypeAttributesByAttributeId($id)) <= 0){
            $deleted = deleteEntityAttribute($id);
            $mapid = deleteEntityAttributeInputMapByAttributeId($id);
            echo json_encode([
                'success' => $deleted,
                'message' => $deleted ? "Entity Attribute deleted successfully." : "Failed to delete entity attribute. It may be in use by one or more entity types."
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => "Failed to Delete Entity Attributes. Attributre is in use."
            ]);
        }
        exit;

    // =================== INPUT FIELD TYPES ===================
    case 'input_field_types':
        //var_dump(getInputFieldTypeByInput($id));
        if(count(getInputFieldTypeByInput($id)) <= 0){
            $deleted = deleteInputFieldType($id);
            echo json_encode([
                'success' => $deleted,
                'message' => "Input Type Deleted Successfully."
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => "Failed to Delete Entity Input Type. Input Type is in use."
            ]);
        }
        exit;

    // =================== DEFAULT ===================
    default:
        // Treat page as entity type slug
        $entityType = $page;
    
        // Optional: validate entity type exists
        $entityTypeData = getEntityTypeBySlug($entityType);
    
        if (!$entityTypeData) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid delete target.'
            ]);
            exit;
        }
    
        // Step 1: Delete attribute data
        deleteEntityAttributeDataByEntityId($id);
    
        // Step 2: Delete entity
        $deleted = deleteEntity($id);
    
        echo json_encode([
            'success' => $deleted,
            'message' => $deleted 
                ? "Entity deleted successfully." 
                : "Failed to delete entity."
        ]);
        exit;
}
?>

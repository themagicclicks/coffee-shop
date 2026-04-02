<?php
header('Content-Type: text/html; charset=UTF-8');
include_once '../includes/__functions.php';


// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$response = ["status" => "error", "message" => "Invalid request"];
$action = $_POST['page'] ?? ''; // Get the requested action

switch ($action) {
    // =================== FIXED ENTITY TYPES ===================
    case 'create_entity_types':
        $entityTypeName = $_POST['entity_type_name'] ?? '';
        $entityTypeName = strtolower(str_replace(' ', '-', $entityTypeName));
        $entityTypeTitle = $_POST['entity_type_title'] ?? '';
        $templateId = intval($_POST['template_name'] ?? 0);
        $attributes = $_POST['attributes'] ?? [];
        $sortorder = $_POST['sort_order'] ?? [];
    
        // Sanitize and normalize name for ID and lowercase the display name
        $entityTypeName = preg_replace('/[^a-zA-Z_-]/', '', str_replace(' ', '-', strtolower($entityTypeName)));
    
        // Check if entity name already exists (case-insensitive match on the display name)
        $existing = getEntityTypeByName($entityTypeName);
    
        if (!empty($existing)) {
            echo json_encode([
                'success' => false,
                'message' => "Entity type with name '$entityTypeName' already exists."
            ]);
            exit;
        }
    
        // Insert new entity type
        $entityId = createEntityType($entityTypeName, $entityTypeTitle, $templateId);
    
        if (!$entityId) {
            echo json_encode([
                'status' => "error",
                'message' => "Failed to insert entity type."
            ]);
            exit;
        }
    
        // Insert attribute mappings with order
        foreach ($attributes as $attrId) {
            $attrId = intval($attrId);
            $order = isset($sortorder[$attrId]) ? intval($sortorder[$attrId]) : 0;
            mapAttributeToEntityType($entityId, $attrId, $order);
        }
    
        echo json_encode([
            'status' => "success",
            'message' => "Entity type '$entityTypeName' created successfully.",
            'entity_type_id' => $entityId
        ]);
        exit;


    case 'edit_entity_types':
        $entityTypeId = $_POST['id'] ?? '';
        $entityTypeName = $_POST['entity_type_name'] ?? '';
        $entityTypeTitle = $_POST['entity_type_title'] ?? '';
        $templateId = intval($_POST['template_name'] ?? 0);
        $attributes = $_POST['attributes'] ?? [];
        $sortorder = $_POST['sort_orders'] ?? [];
        // Sanitize new name for comparison
        $entityTypeName = strtolower(str_replace(' ', '-', $entityTypeName));
        $entityTypeName = preg_replace('/[^a-zA-Z_-]/', '', $entityTypeName);
    
        // Check if the new name already exists under another entity ID
        $existing = getEntityTypeByName($entityTypeName);
        if (!empty($existing) && $existing[0]['id'] != $entityTypeId) {
            echo json_encode([
                'status' => "error",
                'message' => "Another entity type with the name '$entityTypeName' already exists."
            ]);
            exit;
        }
    
        // Update entity type name and template
        /*$updated = db_connect(
            "UPDATE entity_types SET name = ?, template_id = ? WHERE id = ?",
            ['s', 'i', 's'],
            [$sanitizedName, $templateId, $entityId],
            'update'
        );*/
        $updated = updateEntityType($entityTypeId, $entityTypeName, $entityTypeTitle, $templateId);
        if ($updated === 0) {
            $updated = true;
        }
        if (!$updated) {
            echo json_encode([
                'status' => "error",
                'message' => "Failed to update entity type."
            ]);
            exit;
        }
    
        // Remove old attribute mappings
        /*db_connect(
            "DELETE FROM entity_attribute_map WHERE entity_type_id = ?",
            ['s'],
            [$entityId],
            'delete'
        );*/
        unmapAllAttributeFromEntityType($entityTypeId);
        //print_r($attributes);
        // Insert new attribute mappings
        foreach ($attributes as $attrId) {
            $attrId = intval($attrId);
            $order = isset($sortorder[$attrId]) ? intval($sortorder[$attrId]) : 0;
            mapAttributeToEntityType($entityTypeId, $attrId, $order);
        }
    
        echo json_encode([
            'status' => "success",
            'message' => "Entity type '$entityTypeName' updated successfully.",
            'entity_type_id' => $entityTypeId
        ]);
        exit;

    // =================== ENTITY ATTRIBUTES ===================
    case 'create_entity_attributes':
        $name = str_replace('-','_',str_replace(' ','_',trim($_POST['entity_attribute_name'] ?? '')));
        $inputtypeid = intval($_POST['entity_type_list'] ?? 0); // fixed line
        
        if (empty($name)) {
            $response['message'] = "Attribute name is required.";
            break;
        }
        if ($inputtypeid == 0) {
            $response['message'] = "Input Type is Required.";
            break;
        }
        // Check for existing attribute with same name
        $existing = getEntityAttributeByName($name);
        if (!empty($existing)) {
            $response = [
                'status' => 'error',
                'message' => "An attribute with the name '$name' already exists."
            ];
            break;
        }
        
        $id = createEntityAttribute($name);
        //var_dump($id);
        $iid = insertEntityAttributeInputMap($id, $inputtypeid);
        
        $response = $iid
            ? ["status" => "success", "message" => "Entity attribute created successfully"]
            : ["status" => "error", "message" => "Failed to create entity attribute"];
        break;



    case 'edit_entity_attributes':
        $id = intval($_POST['entity_attribute_id'] ?? 0);
        $name = str_replace('-','_',str_replace(' ','_',trim($_POST['entity_attribute_name'] ?? '')));
        $inputtypeid = intval($_POST['entity_type_list'] ?? 0);
        
        if ($id <= 0 || empty($name) || $inputtypeid <= 0) {
            $response = [
                'status' => 'error',
                'message' => "Valid attribute ID, name, and input type are required."
            ];
            break;
        }
        
        // Check if a different attribute with the same name exists
        $existing = getEntityAttributeByName($name);
        if (!empty($existing) && intval($existing[0]['id']) !== $id) {
            $response = [
                'status' => 'error',
                'message' => "Another attribute with the name '$name' already exists."
            ];
            break;
        }
        
        // Update the attribute name
        $updateSuccess = updateEntityAttribute($id, $name);
        if ($updateSuccess === 0) {
            $updateSuccess = true;
        }
        // Update input type mapping
        deleteEntityAttributeInputMapByAttributeId($id);
        $mapInsertSuccess = insertEntityAttributeInputMap($id, $inputtypeid);
        //var_dump($updateSuccess);  // Should be true or 1
        //var_dump($mapInsertSuccess); // Should also be true or 1
        $response = ($updateSuccess && $mapInsertSuccess)
            ? ['status' => 'success', 'message' => "Entity attribute updated successfully."]
            : ['status' => 'error', 'message' => "Failed to update entity attribute or input type mapping."];
        break;


    // =================== INPUT FIELD TYPES ===================
    case 'create_input_field_types':
        $type_name = trim($_POST['input_field_name'] ?? '');
        $type_type = trim($_POST['data_type'] ?? '');
        $type_input = decodeField(trim($_POST['input_field_input'] ?? ''));
        if (empty($type_name) || empty($type_type) || empty($type_input)) {
            $response['message'] = "All input field details are required.";
            break;
        }
        $existing = getInputFieldTypeByName($type_name);
        if (!empty($existing)) {
            $response['status'] = "error";
            $response['message'] = "Input field type with name '$type_name' already exists.";
            break;
        }
        $result = insertInputFieldType($type_name,$type_type,$type_input);

        $response = $result
            ? ["status" => "success", "message" => "Input field type created successfully"]
            : ["status" => "error", "message" => "Failed to create input field type"];
        break;

    case 'edit_input_field_types':
        $id = intval($_POST['input_field_type_id'] ?? 0);
        $type_name = trim($_POST['input_field_name'] ?? '');
        $type_type = trim($_POST['data_type'] ?? '');
        $type_input = decodeField(trim($_POST['input_field_input'] ?? ''));
    
        if ($id <= 0 || empty($type_name) || empty($type_type) || empty($type_input)) {
            $response['message'] = "Valid input field ID and details are required.";
            break;
        }
    
        // Check if the name already exists for a different ID
        $existing = getInputFieldTypeByName($type_name);
        if (!empty($existing) && $existing[0]['id'] != $id) {
            $response['status'] = "error";
            $response['message'] = "Input field type with name '$type_name' already exists.";
            break;
        }
    
        $update = updateInputFieldType($id, $type_name, $type_type, $type_input);
        if($update == 0){
            $update = true;
        }
        $response = $update
            ? ["status" => "success", "message" => "Input field type updated successfully"]
            : ["status" => "error", "message" => "Failed to update input field type"];
        break;


    // =================== ENTITY TEMPLATES ===================
    case 'create_entity_templates':
        $name = trim($_POST['template_name'] ?? '');
        $templatehtml = decodeField(trim($_POST['template_html'] ?? ''));
        $previewhtml = decodeField(trim($_POST['preview_template_html'] ?? ''));
        
        if (empty($name)) {
            $response['message'] = "Template name is required.";
            break;
        }
        
        if (empty($templatehtml)) {
            $response['message'] = "Template HTML is required.";
            break;
        }
        
        // Check for existing template with same name (case-insensitive)
        $existing = getEntityTemplateByName($name);
        if (!empty($existing)) {
            $response = [
                "status" => "error",
                "message" => "A template with the name '{$name}' already exists."
            ];
            break;
        }
        
        // Proceed to insert new template
        $result = createEntityTemplate($name, $templatehtml, $previewhtml);
        
        $response = $result
            ? ["status" => "success", "message" => "Entity template created successfully"]
            : ["status" => "error", "message" => "Failed to create entity template"];
        break;


    case 'edit_entity_templates':
        $id = intval($_POST['template_id'] ?? 0);
        $name = trim($_POST['template_name'] ?? '');
        $template_html = decodeField(trim($_POST['template_html'] ?? ''));
        $preview_template_html = decodeField(trim($_POST['preview_template_html'] ?? ''));
        if ($id <= 0 || empty($name)) {
            $response['message'] = "Valid template ID and name are required.";
            break;
        }
        if (empty($template_html)) {
            $response['message'] = "Template HTML is required.";
            break;
        }
        
        // Check for existing template with same name (case-insensitive)
        $existing = getEntityTemplateByName($name);
        if (!empty($existing) && intval($existing[0]['id']) !== $id) {
            $response = [
                "status" => "error",
                "message" => "A template with the name '{$name}' already exists."
            ];
            break;
        }
        
        $updateSuccess = updateEntityTemplate($id, $name, $template_html, $preview_template_html);
        if ($updateSuccess === 0) {
            $updateSuccess = true;
        }
        $response = $updateSuccess
            ? ["status" => "success", "message" => "Entity template updated successfully"]
            : ["status" => "error", "message" => "Failed to update entity template"];
        break;

    // =================== DEFAULT CASE (Dynamic Entities) ===================
    default:
            
            //find a post data that begins with "name" and filter it to be permalink safe and use it as entity name
            //a name field is mandatory for entities, if not found throw an error saying a name field is mandatory
            //use an attribute named "name"
            //rest of the posted data.. parse names like 'sub_title-text-string-3'. 'title-text-string-4' etc and know that the array[0] of splitting the name with - is the attribute name...
            //then find that attribute id from the entity attribute retuirned by getEntityAttributeByName($name) .. it'll return id and name from `entity_attributes` table
            //next job is to fill in the `entity_attribute_Data1 table one attribute at a time using setEntityAttributeValue($entityId, $attributeId, $value) .. give it entityid,attributeid and value and then uodate the 
            //`entity_updates` table (entity_id,last_updated ( it is on update CURRENT_TIMESTAMP field))
            //then last comes a static field present with all entity psots... the state field it is named 'entity_state' and is in the $fields variable like other $POST vars now... get that and save it with setEntityState($entityId, $stateId)
            //var_dump($_FILES);
            if (preg_match('/^(create|edit)_(.+)$/', $action, $matches)) {
                $operation = $matches[1]; // 'create' or 'edit'
                $entityTypeSlug = $matches[2]; // e.g., 'blog', 'white-papers'
                $entityType = ucfirst(strtolower(str_replace('-', ' ', $entityTypeSlug)));
            
                $fields = $_POST;
                unset($fields['action']);
            
                $entity_type_id = $fields['entity_type_id'] ?? null;
                $entity_state_id = $fields['entity_state'] ?? null;
            
                if (!$entity_type_id) {
                    $response = ["status" => "error", "message" => "Entity type ID is required."];
                    break;
                }
            
                // 1. Extract and sanitize name field (required)
                $name = null;
                foreach ($fields as $key => $value) {
                    if (strpos($key, 'name') === 0 && !empty(trim($value))) {
                        $name = preg_replace('/[^a-z0-9\-]/', '-', strtolower(trim($value))); // permalink-safe
                        break;
                    }
                }
            
                if (!$name) {
                    $response = ["status" => "error", "message" => "A name field is mandatory for all entities."];
                    break;
                }
            
                // 2. Create or Update Entity
                if ($operation === 'create') {
                    $entityId = createEntity($name, $entity_type_id);
                    if (!$entityId) {
                        $response = ["status" => "error", "message" => "Failed to create entity."];
                        break;
                    }
                } else {
                    $entityId = intval($fields['entity_id'] ?? 0);
                    if ($entityId <= 0) {
                        $response = ["status" => "error", "message" => "Valid entity ID required for update."];
                        break;
                    }
            
                    $updated = updateEntity($entityId, $name);
                    if ($updated === false) {
                        $response = ["status" => "error", "message" => "Failed to update entity name."];
                        break;
                    }
                }
            
                // 3. Handle dynamic attribute values (text + image)
                foreach ($_POST as $key => $value) {
                    $parts = explode('-', $key);
                
                    if (count($parts) >= 2) {
                        $attrName = $parts[0];
                        $attrType = $parts[1] ?? '';
                
                        $attribute = getEntityAttributeByName($attrName);
                        if (!$attribute || empty($attribute[0]['id'])) {
                            continue;
                        }
                
                        $attributeId = $attribute[0]['id'];
                
                        // Delete old attribute value if editing
                        if ($operation === 'edit') {
                            deleteEntityAttributeValue($entityId, $attributeId);
                        }
                
                        setEntityAttributeValue($entityId, $attributeId, decodeField($value));
                    }
                }
                
                // 3b. Handle uploaded media attributes (image, video, pdf)
                foreach ($_FILES as $key => $file) {
                    $parts = explode('-', $key);
                
                    if (count($parts) >= 2) {
                        $attrName = $parts[0];
                        $attrType = strtolower($parts[1] ?? '');
                
                        if (!in_array($attrType, ['image', 'video', 'pdf'])) {
                            continue; // Only process specified media types
                        }
                
                        $attribute = getEntityAttributeByName($attrName);
                        if (!$attribute || empty($attribute[0]['id'])) {
                            continue;
                        }
                
                        $attributeId = $attribute[0]['id'];
                
                        if ($file['error'] === UPLOAD_ERR_OK) {
                            // Determine upload folder
                            $baseMediaDir = BASE . 'media/';
                            $baseDocumentDir = BASE . 'documents/';
                            $uploadDir = ($attrType === 'image' || $attrType === 'video') 
                                ? $baseMediaDir 
                                : $baseDocumentDir;
                
                            // Create directory if it doesn't exist
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }
                
                            // Clean filename
                            $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($file['name']));
                            $targetPath = $uploadDir . uniqid() . '_' . $safeName;
                
                            // MIME type validation
                            $allowedMimeTypes = [
                                'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                                'video' => ['video/mp4', 'video/webm', 'video/ogg'],
                                'pdf'   => ['application/pdf']
                            ];
                
                            if (!empty($allowedMimeTypes[$attrType])) {
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mime = finfo_file($finfo, $file['tmp_name']);
                                finfo_close($finfo);
                
                                if (!in_array($mime, $allowedMimeTypes[$attrType])) {
                                    continue; // Skip invalid file types
                                }
                            }
                
                            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                                $relativePath = str_replace(BASE, '', $targetPath);
                
                                if ($operation === 'edit') {
                                    deleteEntityAttributeValue($entityId, $attributeId);
                                }
                
                                setEntityAttributeValue($entityId, $attributeId, $relativePath);
                            }
                        }
                    }
                }

            
                // 4. Set or update entity state
                /*if (!empty($entity_state_id)) {
                    if ($operation === 'create') {
                        setEntityMapState($entityId, $entity_state_id);
                    } else {
                        updateEntityMapState($entityId, $entity_state_id);
                    }
                }*/
            
                // 5. Return success
                $response = [
                    "status" => "success",
                    "message" => ucfirst($operation) . "d " . ucwords(str_replace('-', ' ', $entityTypeSlug)) . " successfully"
                ];
                break;
            }

}

echo json_encode($response);
?>

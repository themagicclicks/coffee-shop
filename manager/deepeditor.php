<?php 
$GLOBALS["bodyclass"] = "white";
include_once '../includes/__functions.php';
include_once 'includes/header.php';

// Get the requested page type
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$page = strtolower(str_replace(' ', '_', $page));
//var_dump($page);
if($page == 'create_entity_types'){
    //hardcoded base entity type form
    //create the form with entity type name, enitiy template boxes, and allow adding attributes ( input box ) with optio nto select input tyoe
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <label for="entity_name">Entity Type Name ( Permalink )</label>
                    <input type="text" id="entity_type_name" name="entity_type_name"  required>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <label for="entity_name">Entity Type Title</label>
                    <input type="text" id="entity_type_title" name="entity_type_title"  required>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    <select id="template_name" name="template_name">
                        <option value="" disabled selected>Select a template</option>
                        <?php echo getEntityTemplatesForSelect(); ?>
                    </select>
                </div>
            </div>
            <div class="col s6 attribute">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    
                    <?php /*<select id="attributes_list[]" name="attributes_list[]" multiple>
                        <option value="" disabled selected>Select Attributes</option> */ ?>
                        <?php echo renderAttributeMultiSelect($entitytypeid); ?>
                    <?php /*</select>*/ ?>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Save Entity Type</button></div>
        </div>
    </form>
</div>

<?php
    
}else if($page == 'edit_entity_types'){
    //echo "HERE";
    $entitytypeid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $entitytype = getEntityType($entitytypeid);
    if (count($entitytype) && isset($entitytype[0])) {
        $templateId = $entitytype[0]['template_id'];
        $entityName = $entitytype[0]['name'];
        $entityTitle = $entitytype[0]['title'];
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden"  name="id" value="<?php echo $entitytypeid; ?>">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <label for="entity_name">Entity Type Name ( Permalink )</label>
                    <input type="text" id="entity_type_name" name="entity_type_name"  value="<?php echo $entityName; ?>" required>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <label for="entity_name">Entity Type Title</label>
                    <input type="text" id="entity_type_title" name="entity_type_title"   value="<?php echo $entityTitle; ?>" required>
                </div>
            </div>
            <div class="col s6">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    <select id="template_name" name="template_name">
                        <option value="" disabled selected>Select a template</option>
                        <?php echo getEntityTemplatesForSelect($templateId); ?>
                    </select>
                </div>
            </div>
            <div class="col s6 attribute">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    
                    <?php /*<select id="attributes_list[]" name="attributes_list[]" multiple>
                        <option value="" disabled selected>Select Attributes</option> */ ?>
                        <?php echo renderAttributeMultiSelect($entitytypeid); ?>
                    <?php /*</select>*/ ?>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Save Entity Type</button></div>
        </div>
    </form>
</div>
<?php
    } else {
        echo "Entity type not found.";
    }
}else if($page == 'create_entity_attributes'){
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <label for="entity_name">Entity Attribute Name</label>
                    <input type="text" id="entity_attribute_name" name="entity_attribute_name" required>
                </div>
            </div>
            <div class="col s6 entitytype">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    
                    <select id="entity_type_list" name="entity_type_list">
                        <option value="" disabled selected>Select Attribute Type</option>
                        <?php echo getInputFieldTypesForSelect(); ?>
                    </select>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Create Attribute</button></div>
        </div>
    </form>
</div>
<?php
}else if($page == 'edit_entity_attributes'){
     $entityattributeid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
     $entityattribute = getEntityAttribute($entityattributeid);
     $entityattributename = !empty($entityattribute) && isset($entityattribute[0]["name"]) ? $entityattribute[0]["name"] : "";
     $entityattributeInputType = getInputFieldTypeByAttribute($entityattributeid);
     $entityattributeInputTypeId = !empty($entityattributeInputType) && isset($entityattributeInputType[0]["id"]) ? (int) $entityattributeInputType[0]["id"] : 0;
     
     
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="entity_attribute_id" value="<?php echo $entityattributeid; ?>">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <label for="entity_name">Entity Attribute Name</label>
                    <input type="text" id="entity_attribute_name" name="entity_attribute_name" value="<?php echo $entityattributename; ?>" required>
                </div>
            </div>
            
            <div class="col s6 entitytype">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    
                    <select id="entity_type_list" name="entity_type_list">
                        <option value="" disabled selected>Select Attribute Type</option>
                        <?php echo getInputFieldTypesForSelect($entityattributeInputTypeId); ?>
                    </select>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Edit Attribute</button></div>
        </div>
    </form>
</div>
<?php
}else if($page == 'create_input_field_types'){
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <div class="row">
            <div class="col s4">
                <div class="input-field">
                    <label for="input_field_name">Input Type Name</label>
                    <input type="text" id="input_field_name" name="input_field_name" required>
                </div>
            </div>
            <div class="col s4 entitytype">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    <?php renderPHPTypeSelect('data_type', 'string'); ?>
                </div>
            </div>
            <div class="col s4">
                <div class="input-field">
                    <label for="input_field_input">Input Type Input Field</label>
                    <textarea id="input_field_input" name="input_field_input" required></textarea>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Save Input</button></div>
        </div>
    </form>
</div>
<?php
}else if($page == 'edit_input_field_types'){
    $inputfieldtypeid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $inputtype = getInputFieldType($inputfieldtypeid);
    //print_r($inputtype);
    $inputypename = !empty($inputtype) && isset($inputtype[0]["type_name"]) ? $inputtype[0]["type_name"] : "";
    $inputypetype = !empty($inputtype) && isset($inputtype[0]["type_type"]) ? $inputtype[0]["type_type"] : "string";
    $inputypeinput = !empty($inputtype) && isset($inputtype[0]["type_input"]) ? $inputtype[0]["type_input"] : "";
    //var_dump($inputypetype);
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="input_field_type_id" value="<?php echo $inputfieldtypeid; ?>">
        <div class="row">
            <div class="col s4">
                <div class="input-field">
                    <label for="input_field_name">Input Type Name</label>
                    <input type="text" id="input_field_name" name="input_field_name" value="<?php echo $inputypename; ?>" required>
                </div>
            </div>
            <div class="col s4 entitytype">
                <div class="input-field">
                    <!--<label for="template_name">Template</label>-->
                    <?php renderPHPTypeSelect('data_type', $inputypetype); ?>
                </div>
            </div>
            <div class="col s4">
                <div class="input-field">
                    <label for="input_field_input">Input Type Input Field</label>
                    <textarea id="input_field_input" name="input_field_input" required><?php echo htmlspecialchars($inputypeinput); ?></textarea>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Save Input</button></div>
        </div>
    </form>
</div>
<?php
}else if($page == 'create_entity_templates'){
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <div class="row">
            <div class="col s12">
                <div class="input-field">
                    <label for="template_name">Template Name</label>
                    <input type="text" id="template_name" name="template_name" required>
                </div>
            </div>
            <div class="col s12 entitytype">
                <div class="input-field">
                    <label for="template_html">Template HTML</label>
                    <textarea id="template_html" name="template_html" required></textarea>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field">
                    <label for="preview_template_html">Preview Template HTML</label>
                    <textarea id="preview_template_html" name="preview_template_html" required></textarea>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Save Template</button></div>
        </div>
    </form>
</div>
<?php    
}else if($page == 'edit_entity_templates'){
    $entitytemplateid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $entitytemplate = getEntityTemplate($entitytemplateid);
    //print_r($entitytemplate);
    $templatename = !empty($entitytemplate) && isset($entitytemplate[0]["template_name"]) ? $entitytemplate[0]["template_name"] : "";
    $templatehtml = !empty($entitytemplate) && isset($entitytemplate[0]["template_html"]) ? $entitytemplate[0]["template_html"] : "";
    $previewtemplatehtml = !empty($entitytemplate) && isset($entitytemplate[0]["preview_template_html"]) ? $entitytemplate[0]["preview_template_html"] : "";
?>
<div class="container">
    <h5><?php echo ucfirst(str_replace('_', ' ', $page)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="template_id" value="<?php echo $entitytemplateid; ?>">
        <div class="row">
            <div class="col s12">
                <div class="input-field">
                    <label for="template_name">Template Name</label>
                    <input type="text" id="template_name" name="template_name" value="<?php echo $templatename; ?>" required>
                </div>
            </div>
            <div class="col s12 entitytype">
                <div class="input-field">
                    <label for="template_html">Template HTML</label>
                    <textarea id="template_html" name="template_html" required><?php echo $templatehtml; ?></textarea>
                </div>
            </div>
            <div class="col s12">
                <div class="input-field">
                    <label for="preview_template_html">Preview Template HTML</label>
                    <textarea id="preview_template_html" name="preview_template_html" required><?php echo $previewtemplatehtml; ?></textarea>
                </div>
            </div>
            <div class="col s6"></div>
            <div class="col s6"><button type="submit" class="btn">Save Template</button></div>
        </div>
    </form>
</div>
<?php
}else{
    // Extract entity type from query string (e.g., 'create_blog' -> 'blog', 'edit_news' -> 'news')
    $entityAction = explode('_', $page, 2);
    if (count($entityAction) < 2) {
        echo "Invalid entity action.";
        exit;
    }

    $action = $entityAction[0]; // 'create' or 'edit'
    $entityTypeName = $entityAction[1]; // e.g., 'blog', 'news', 'product'
    
    // Check if the entity type exists
    $entityType = getEntityTypeByName($entityTypeName);
    if (!$entityType) {
        echo "Invalid entity type.";
        exit;
    }
    $entityStateid = 0;
    $entityTypeId = !empty($entityType) && isset($entityType[0]["id"]) ? (int) $entityType[0]["id"] : 0;
    $entityAttributes = getAttributesByEntityType($entityTypeId);
    //print_r($entityAttributes);
    // If editing, fetch entity data
    $entityData = [];
    if ($action == 'edit') {
        $entityId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $entityData = getEntity($entityId);
        if (!$entityData) {
            echo "Entity not found.";
            exit;
        }
        $entiyState = getEntityStateByEntity($entityId);
        $entityStateid = (!empty($entiyState) && isset($entiyState[0]["state_id"])) ? (int) $entiyState[0]["state_id"] : 0;
        $entityAttributeValues = getEntityAttributeValues($entityId);
        //print_r($entityAttributeValues);
    }

?>
<div class="container">
    <h5><?php echo ucfirst($action) . " " . ucfirst(str_replace('_', ' ', $entityTypeName)); ?></h5>
    <form action="process_entity.php" accept-charset="UTF-8" method="post">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="entity_type_id" value="<?php echo $entityTypeId; ?>">
        <?php if ($action == 'edit') { ?>
            <input type="hidden" name="entity_id" value="<?php echo $entityId; ?>">
        <?php } ?>
        
        <div class="row">
            <div class="col s12">
                <div class="input-field">
                    <label for="name-text-string-1">Name of <?php echo ucfirst(str_replace('_', ' ', $entityTypeName)); ?></label>
                    <?php if ($action == 'edit') { ?>
                        <input name="name-text-string-1" class="fixed-attribute" value="<?php echo !empty($entityData) && isset($entityData[0]["name"]) ? $entityData[0]["name"] : ""; ?> ">
                    <?php }else{ ?>
                        <input name="name-text-string-1" class="fixed-attribute" value="">
                    <?php } ?>
                    
                </div>
            </div>
            <?php 
            $i = 1;
            //print_r($entityAttributes);
            //print_r($entityAttributeValues);
            foreach ($entityAttributes as $attribute) { 
                $attributeId = $attribute['attribute_id'];
                $attributeName = $attribute['attribute_name'];
                $attributeType = $attribute['type_input']; // the full input element string
                $attributeValue = $action == 'edit' ? getValueByName($entityAttributeValues,$attributeName) : '';
                $attributeTypeName = $attribute['type_name'];
                
                $attributeTypeType = $attribute['type_type'];
                //$attributeInput = str_replace("{name}",$attributeName."-".$attributeTypeName."-".$attributeTypeType."-".$i,$attribute['type_input']);
                $inputName = $attributeName . "-" . $attributeTypeName . "-" . $attributeTypeType . "-" . $i;
                if($attributeTypeName !== 'image' && $attributeTypeName !== 'video' && $attributeTypeName !== 'pdf'){
                    $inputValue = htmlspecialchars($attributeValue); // avoid HTML injection
                }else{
                    $inputValue = SITE. htmlspecialchars($attributeValue); // avoid HTML injection
                }
                
                $attributeInput = str_replace(
                    ['{name}', '{value}'],
                    [$inputName, $inputValue],
                    $attribute['type_input']
                );
                if(strpos($attributeInput, '<select') !== false){
                    //echo $attributeValue." is the value of".$attributeName."<br>";
                    //if input type is select then there was no {value} placeholder so
                    //simply need to find value like value="kraft_paper" etc and replace with value="kraft_paper" selected
                    $attributeInput = str_replace("value=\"".$inputValue."\"", "value=\"".$inputValue."\" selected",$attributeInput);
                }
            ?>
            <div class="col s12"> 
                <div class="input-field <?php echo (strpos($attributeInput, 'pell') !== false)?'large':'';  ?>">
                    <?php
                    if(strpos($attributeInput, 'checkbox') !== false){
                    ?>
                        <label>
                        <?php echo $attributeInput; ?>
                        <span><?php echo str_replace("_"," ",ucfirst($attributeName)); ?></span>
                        </label>
                    <?php
                    }else{
                    ?>
                        <label for="attr_<?php echo $attributeId; ?>"><?php echo str_replace("_"," ",ucfirst($attributeName)); ?></label>
                        <?php echo $attributeInput; ?>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>
            <?php 
            $i++;
            } ?>
        </div>
        <div class="row">
            <div class="col s6">&nbsp;</div>
            <div class="col s6">
                <select name="entity_state" id="entiy_state">
                    <?php echo getEntityStatesforSelect($entityStateid); ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s6"></div>
            <div class="col s6">
                <button type="submit" class="btn"><?php echo ucfirst($action); ?> Entity</button>
            </div>
        </div>
    </form>
</div>
<?php echo listImagesFromMediaFolder(); ?>
<?php echo listContentTemplates(); ?>
<?php
}
include_once 'includes/footer.php';
?>


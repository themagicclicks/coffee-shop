<?php 
$GLOBALS["bodyclass"] = "navy";
include_once '../includes/__functions.php';
include_once 'includes/header.php';
?>
<div class="row">
    <!-- Left Sidebar -->
    <div class="col s3 menubar">
        <ul class="menu">
            <li class="header"><h5>Admin Panel</h5></li>
            <li class="item"><a href="editor.php?page=input_field_types" target="editorFrame">Add / Edit Input Field Types</a></li>
            <li class="item"><a href="editor.php?page=entity_attributes" target="editorFrame">Add / Edit Attributes</a></li>
            <li class="item"><a href="editor.php?page=entity_templates" target="editorFrame">Add / Edit Entity Templates</a></li>
            <li class="item"><a href="editor.php?page=entity_types" target="editorFrame">Add / Edit Entity Types</a></li>
            <li class="header"><h6>Manage Entities</h6></li>

            <?php 
            $entityTypes = getEntityTypes();
            //print_r($entityTypes);
            if (!empty($entityTypes)) {
                foreach ($entityTypes as $type) {
                    $entityName = htmlspecialchars($type['name']);
                    echo "<li class='item'><a href='editor.php?page={$entityName}&entitytypeid={$type["id"]}&type=entities' target='editorFrame'>Add / Edit {$entityName}</a></li>";
               }
            }
            ?>
        </ul>
    </div>

    <!-- Right Frame -->
    <div class="col s9 contentbox">
        <iframe name="editorFrame" class="editorFrame" src="editor.php" width="100%" height="600px" frameborder="0"></iframe>
    </div>
</div>



<?php 
include_once 'includes/footer.php';
?>


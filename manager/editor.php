<?php 
$GLOBALS["bodyclass"] = "white";
include_once '../includes/__functions.php';
include_once 'includes/header.php';

// Get the requested page type
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$page = strtolower(str_replace(' ', '_', $page));
// Map pages to corresponding database tables
$pagesMap = [
    'entity_types' => ['table' => 'entity_types', 'title' => 'Entity Types'],
    'entity_templates' => ['table' => 'entity_templates', 'title' => 'Entity Templates'],
    'input_field_types' => ['table' => 'input_field_types', 'title' => 'Input Field Types'],
    'entity_attributes' => ['table' => 'entity_attributes', 'title' => 'Entity Attributes'],
    // Dynamic handling of entities
];
// Fetch all entity types dynamically
$entityTypes = getEntityTypes();

if (!empty($entityTypes)) {
    foreach ($entityTypes as $type) {
        $entityName = strtolower(str_replace(' ', '_', $type['name'])); // Normalize name for URLs
        $pagesMap[$entityName] = ['table' => 'entities', 'title' => "{$type['name']}"];
        
    }
}
//print_r($pagesMap);
//var_dump($page);
if (isset($pagesMap[$page])) {
    $table = $pagesMap[$page]['table'];
    $title = $pagesMap[$page]['title'];
    // Fetch data dynamically
    if($table !== 'entities'){
        $query = "SELECT * FROM {$table} ORDER BY id DESC";
        $records = db_connect($query, [], [], 'select');
    }else{
        $entitytypeid = intval($_GET["entitytypeid"]);
        $query = "SELECT * FROM {$table} WHERE `entity_type_id`={$entitytypeid} ORDER BY id DESC";
        $records = db_connect($query, [], [], 'select');
    }
    
} else {
    $table = null;
    $title = 'Dashboard';
}
?>
<div class="container">
    <h4><?php echo $title; ?></h4>

    <?php if ($table): ?>
        <table class="striped highlight grid">
            <thead>
                <tr>
                    <?php if (!empty($records)) : ?>
                        <?php foreach (array_keys($records[0]) as $col) : ?>
                            <th><?php echo ucfirst(str_replace('_', ' ', $col)); ?></th>
                        <?php endforeach; ?>
                        <th><a href="deepeditor.php?page=create_<?php echo $page; ?>" class="btn-small">Add <?php echo $title; ?></a></th>
                    <?php else: ?>
                        <th>No records found</th>
                        <th><a href="deepeditor.php?page=create_<?php echo $page; ?>" class="btn-small">Add <?php echo $title; ?></a></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record) : ?>
                    <tr>
                        <?php foreach ($record as $value) : ?>
                            <td><?php
                                $maxLength = 150;

                                // Remove tags and decode HTML entities for accurate character count
                                $plainText = strip_tags(html_entity_decode($value));
                                
                                // Truncate if longer than $maxLength
                                if (mb_strlen($plainText) > $maxLength) {
                                    $truncated = mb_substr($plainText, 0, $maxLength - 3) . '...';
                                    echo htmlspecialchars($truncated, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                                } else {
                                    echo htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                                }
                            
                            ?></td>
                        <?php endforeach; ?>
                        <td>
                            <?php if(intval($record['id']) == 12  && $page == 'entity_types'){ ?>
                            <a href="#" class="btn-small disabled">Edit</a>
                            <a href="#" class="btn-small red delete disabled">Delete</a>
                            <?php } else{ ?>
                            <a href="deepeditor.php?page=edit_<?php echo $page; ?>&id=<?php echo $record['id']; ?>" class="btn-small">Edit</a>
                            <a href="delete.php?page=<?php echo $page; ?>&id=<?php echo $record['id']; ?>" class="btn-small red delete">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h5>Welcome to the admin dashboard. Please select an option from the menu.</h5>
    <?php endif; ?>
</div>


<?php 
include_once 'includes/footer.php';
?>


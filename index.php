<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include database connection & functions
require_once __DIR__ . '/core/env.php';
loadEnv(__DIR__ . '/.env');

define('BASE', $_ENV['BASE']);
define('SITE', $_ENV['SITE']);


//define("BASE","/home/u804273671/domains/aperiq.in/public_html/fiverr/coffee-shop/");
//define("SITE","https://aperiq.in/fiverr/coffee-shop/");
//define("BASE","C:/laragon/www/fiverr/coffee-shop/");
//define("SITE","http://127.0.0.1/fiverr/coffee-shop/");
// Get entity type and entity name from URL
$entityType = isset($_GET['entitytype']) ? urldecode($_GET['entitytype']) : '';
$entityName = isset($_GET['entityname']) ? urldecode($_GET['entityname']) : '';
//$entityType = isset($_GET['entitytype']) ? urldecode($_GET['entitytype']) : '';
//$entityName = isset($_GET['entityname']) ? urldecode($_GET['entityname']) : '';
//var_dump($entityType,$entityName);
include_once BASE.'includes/header.php';




$notfound =  '<div class="error-container">
            <div class="error-image"></div>
            <div class="error-code large">404</div>
            <div class="error-message orange-text">Oops! You\'re Lost in Space.</div>
            <div class="sub-message">The page you’re looking for might have gone extinct, moved, or never existed.</div>
            <a href="'.SITE.'" class="btn-large waves-effect waves-light teal">
                <i class="material-icons left">home</i>Beam Me Home
            </a>
        </div>';    

// Show homepage if no entity type or name is given
if (empty($entityType) && empty($entityName)) {
    $entityType = 'home-page';
    $entityName = getEntityNameByTruthyAttribute('home-page', 'is_current_home');

    if ($entityName === '') {
        $entityName = 'home';
    }
}
// Validate input: Ensure entity type is provided
if (empty($entityType)) {
    http_response_code(404);
    echo json_encode($entityData);
	echo renderPageSnippet("home-page-captions");
    echo $notfound;
}

// If entityName is given, fetch a single entity
if (!empty($entityName)) {
    $entityData = getMatchingEntity($entityName, 0, 0, $entityType);
    //echo "<pre>";
    //var_dump($entityData);
    //echo "</pre>";
    //exit;
    // Check for errors
    if (isset($entityData['error'])) {
        http_response_code(404);
        //echo json_encode($entityData);
		echo renderPageSnippet("home-page-captions");
        echo $notfound;
    }
    $entitiesBlock = '';
    //if($entityName == 'home'){
        //a little change here, earlier only one entity type was picked
        //now we can think of picking up several with a similar naming pattern like "menu-" at the beginning and check for is_featured or similar boolean field
        $entitiesBlock1 = matchingEntitiesBlock('menu-','-drink','is_featured');
        $entitiesBlock2 = matchingEntitiesBlock('shop-','-sell','is_featured','shopproducts');
        $entitiesBlock3 = matchingEntitiesBlock('customer-','-grid','is_featured');
        $entitiesBlock4 = matchingEntitiesBlock('cafe-','-list','is_featured');
   
        //var_dump($entityData);
        $html = renderPageSnippet("home-page-captions");
        $html .= str_replace('##MENU-PRODUCT##',$entitiesBlock1, replaceSitePlaceholder(renderEntityTemplate($entityData)));
        $html = str_replace('##SHOP-PRODUCT##',$entitiesBlock2, $html);
        $html = str_replace('##TESTIMONIALS##',$entitiesBlock3, $html);
        $html = str_replace('##CAFE-EVENTS##',$entitiesBlock4, $html);  
    //}
    //$html = replaceProductsOptionPlaceholder($html);
    echo $html;
    if($entityType == 'pages'){
        //echo "</ul><div class=\"vertical-spacer\"></div><div class=\"vertical-spacer\"></div></div></div></div>"
        echo renderPageSnippet("home-page-captions");
        echo "<div class=\"row block black page-quote\"><div class=\"container\"><div class=\"vertical-spacer\"></div><div class=\"col s12 m7 l7\">".renderPageSnippet("product-page-features")."</div><div class=\"col s12 m5 l5 quote\">".renderPageSnippet("reservation-request-form")."</div></div></div>";
    }
} else {
    //echo "load entities grid for ".$entityType;
    // No entityName provided -> Fetch all entities of this type
    $entities = __getMatchingEntities($entityType, '', 'text');
    //var_dump($entitites);
    if (empty($entities)) {
        //echo "<p>No entities found for this category.</p>";
        //check for partial match of entity types
        //var_dump(foundEntityTypes($entityType."-"));
        if(foundEntityTypes($entityType."-")){
            $entities = getMatchingEntities($entityType."-",'','','',''); //get entities from all entity types that start with ... e.g. menu-
            //var_dump($entities);
            echo "<div class=\"row block dark-coffee list-page\"><div class=\"vertical-spacer\"></div><div class=\"col s12 full\">".renderPageSnippet($entityType)."</div>";
            //if ($entityType === 'menu') {
            //    echo '<div class="container"><div class="col s12 full menu-download-row"><a href="#!" class="btn-large waves-effect waves-light brown download-menu-btn"><i class="material-icons left" style="margin-right:38px;">picture_as_pdf</i>Download Menu</a></div></div>';
            //}
            // Render entity previews in a grid
            echo "<!--<div class=\"vertical-spacer\"></div>--><h1 class=\"center page-title col s12\">".ucfirst($entityType).(($entityType === 'menu')?'<a href="#!" class="download-menu-btn"><i class="material-icons left" style="margin-right:38px;">file_download</i></a>':'')."</h1><div class=\"vertical-spacer\"></div><div class=\"container\"><div class=\"col s12 full\"><ul class=\"bespokeproducts ".$entityType."\">";
            foreach ($entities as $entity) {
                echo replaceSitePlaceholder($entity['rendered_html']);
            }
            echo "</ul>";
            echo renderPageSnippet("home-page-captions");
            echo "</ul><div class=\"vertical-spacer\"></div><!--<div class=\"vertical-spacer\"></div>--></div></div></div>";
			echo "<div class=\"row block dark-coffee page-quote\"><div class=\"container\"><div class=\"vertical-spacer\"></div><div class=\"col s12 m7 l7\">".renderPageSnippet("product-page-features")."</div><div class=\"col s12 m5 l5 quote\">".renderPageSnippet("reservation-request-form")."</div></div></div>";
			if ($entityType === 'menu') {
                echo getMenuPdfTemplateMarkup();
            }
		}else{
			echo renderPageSnippet("home-page-captions");
            echo $notfound;
        }
        //echo $notfound;
    }else{
        echo renderPageSnippet("home-page-captions");
        echo "<div class=\"row block dark-coffee list-page\"><div class=\"vertical-spacer\"></div><div class=\"col s12 full\">".renderPageSnippet($entityType)."</div>";
        // Render entity previews in a grid
        echo "<div class=\"vertical-spacer\"></div><h1 class=\"center page-title\">".ucwords(str_replace("-"," ",getEntityTitle($entityType)))."</h1><div class=\"vertical-spacer\"></div><div class=\"container\"><div class=\"col s12 full\"><ul class=\"bespokeproducts ".$entityType."\">";
        foreach ($entities as $entity) {
            echo replaceSitePlaceholder($entity['rendered_html']);
        }
        
        echo "</ul><div class=\"vertical-spacer\"></div><div class=\"vertical-spacer\"></div></div></div></div>";
        echo "<div class=\"row block black-coffee page-quote\"><div class=\"container\"><div class=\"vertical-spacer\"></div><div class=\"col s12 m7 l7\">".renderPageSnippet("product-page-features")."</div><div class=\"col s12 m5 l5 quote\">".renderPageSnippet("reservation-request-form")."</div></div></div>";
    }
}

include_once BASE.'includes/footer.php';
?>



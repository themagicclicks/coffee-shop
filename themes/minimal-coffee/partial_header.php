<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($metaKeywords, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($metaAuthor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo SITE; ?>favicons/apple-icon-57x57.png">
    <meta property="og:url" content="<?php echo htmlspecialchars($ogUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo SITE; ?>favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo SITE; ?>favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo SITE; ?>favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo SITE; ?>favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo SITE; ?>favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo SITE; ?>favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo SITE; ?>favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo SITE; ?>favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITE; ?>favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo SITE; ?>favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE; ?>favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo SITE; ?>favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE; ?>favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo SITE; ?>favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo SITE; ?>favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?php echo themeAssetUrl('css/materialize.min.css'); ?>">
    
    <link rel="stylesheet" href="<?php echo themeAssetUrl('css/styles.css'); ?>">
    <title><?php echo htmlspecialchars($siteTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></title>
</head>
<body class="<?php echo htmlspecialchars($bodyClass, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> <?php echo (($entityType!=='')?$entityType:'home'); ?> <?php echo (($entityName!=='')?$entityName:''); ?>">
    <div class="no-background vertical-spacer"></div>
    <nav class="no-background minimal-nav-shell">
        <div class="nav-wrapper container topnav minimal-topnav">
            <a href="<?php echo SITE; ?>" class="minimal-brand">
                <img src="<?php echo SITE; ?>images/willow-cup-coffee-white.svg" alt="Willow Cup Coffee">
            </a>

            <ul class="hide-on-med-and-down minimal-lava-menu">
                <span class="lava-lamp" aria-hidden="true"></span>
                <?php foreach ($topNavItems as $index => $navItem) {
                    $href = (string) ($navItem['href'] ?? '');
                    $isAbsolute = preg_match('#^(https?:)?//#i', $href) === 1;
                    $resolvedHref = $isAbsolute ? $href : SITE . ltrim($href, '/');
                ?>
                    <li>
                        <a
                            class="<?php echo $class; ?><?php echo $index === 0 ? ' is-current' : ''; ?>"
                            href="<?php echo htmlspecialchars($resolvedHref, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
                            target="<?php echo htmlspecialchars((string) ($navItem['target'] ?? '_top'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
                        ><?php echo htmlspecialchars((string) ($navItem['label'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></a>
                    </li>
                <?php } ?>
            </ul>

            <div class="minimal-nav-actions">
                <a class="cart-btn btn-floating btn-large waves-effect waves-light teal hidden"><i class="material-icons">shopping_cart</i></a>
                <a class="order-btn btn-floating btn-large waves-effect waves-light brown hidden"><i class="material-icons">receipt_long</i></a>
                <button class="hamburger minimal-menu-toggle" type="button" aria-label="Open menu">
                    <div class="bar <?php echo $class; ?>"></div>
                    <div class="bar <?php echo $class; ?>"></div>
                    <div class="bar <?php echo $class; ?>"></div>
                </button>
            </div>
        </div>
    </nav>

    <div class="open-menu minimal-open-menu">
        <img src="<?php echo SITE; ?>images/willow-cup-coffee-black.svg" alt="Willow Cup Coffee">
        <?php foreach ($openMenuItems as $navItem) {
            $href = (string) ($navItem['href'] ?? '');
            $isAbsolute = preg_match('#^(https?:)?//#i', $href) === 1;
            $resolvedHref = $isAbsolute ? $href : SITE . ltrim($href, '/');
        ?>
            <a href="<?php echo htmlspecialchars($resolvedHref, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" target="<?php echo htmlspecialchars((string) ($navItem['target'] ?? '_top'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars((string) ($navItem['label'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></a>
        <?php } ?>
    </div>

    <div class="open-cart">
        <img src="<?php echo SITE; ?>images/willow-cup-coffee-black.svg" alt="Willow Cup Coffee">
        <h5 class="blue-text">Your Cart</h5>
        <ul class="cart-items"></ul>
        <ul class="totals">
            <li class="total"></li>
            <li class="vat"></li>
        </ul>
        <div class="row">
            <div class="col s12 m6 l6"><a class="waves-effect waves-light btn"><i class="material-icons right">shopping_cart</i> View Cart</a></div>
            <div class="col s12 m6 l6"><a class="waves-effect waves-light btn" href="<?php echo SITE; ?>pages/checkout/"><i class="material-icons right">check_circle</i> Checkout</a></div>
        </div>
    </div>

    <?php if ($entityName !== 'home') { ?>
    <div class="row all-pages">
        <div class="col s12">
            <div id="caption" class="caption-box <?php echo $class; ?>">Loading...</div>
        </div>
    </div>
    <?php } ?>

<?php
// Include database connection & functions

include_once BASE.'includes/functions.php';
$class = '';
$siteConfig = loadAdminClientConfig(BASE . 'config/admin_client.json');
$navy = preg_replace('/[^a-z0-9\-_]/', '', strtolower((string) ($siteConfig['theme_name'] ?? 'dark-coffee')));
if ($navy === '') {
    $navy = 'dark-coffee';
}
//if (!empty($entityType) && $entityType == 'pages') {
    //$class = "dark";
//}

$bodyClass = trim($navy . ' ' . (($entityType == 'home-page' || $entityType == '') ? 'hero' : ''));
$class = str_contains($bodyClass, "white") ? "dark" : "";
$siteTitle = $siteConfig['site_title'] ?? 'Willow Cup Coffee - The Community Peace Spot';
$metaDescription = $siteConfig['meta_description'] ?? 'A modern, responsive webpage using Materialize CSS and jQuery with an indigo color theme.';
$metaKeywords = $siteConfig['meta_keywords'] ?? 'Materialize CSS, jQuery, Responsive Web Design, SEO, Indigo Theme';
$metaAuthor = $siteConfig['meta_author'] ?? 'Your Name';
$ogTitle = $siteConfig['og_title'] ?? $siteTitle;
$ogDescription = $siteConfig['og_description'] ?? $metaDescription;
$ogUrl = $siteConfig['og_url'] ?? SITE;
$frontendNavigation = $siteConfig['frontend_navigation'] ?? ['top_nav' => [], 'open_menu' => []];
$activeTheme = getActiveThemeName();
$topNavItems = adminClientFilterFrontendNavigationItemsByTheme($frontendNavigation['top_nav'] ?? [], $activeTheme);
$openMenuItems = adminClientFilterFrontendNavigationItemsByTheme($frontendNavigation['open_menu'] ?? [], $activeTheme);
$themeHeader = BASE . "themes/$activeTheme/partial_header.php";

//var_dump($themeHeader);
if (file_exists($themeHeader)) {
    include $themeHeader;
} else {
    include BASE . "includes/partial_header.php";
}

include_once BASE . 'includes/theme_demo_switcher.php';
?>




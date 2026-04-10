<?php
$activeTheme = getActiveThemeName();
$themeFooter = BASE . "themes/$activeTheme/partial_footer.php";

if (file_exists($themeFooter)) {
    include $themeFooter;
} else {
    include BASE . 'includes/partial_footer.php';
}
?>

<?php
$pageTitle = isset($pageTitle) ? $pageTitle : 'Dashboard';
$appTitle = isset($appTitle) ? $appTitle : 'Client Admin';
$pageBodyClass = isset($pageBodyClass) ? trim((string) $pageBodyClass) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | <?php echo htmlspecialchars($appTitle); ?></title>
    <link rel="stylesheet" href="../css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <?php if (!empty($pageStyles)) { echo $pageStyles; } ?>
</head>
<body<?php echo $pageBodyClass !== '' ? ' class="' . htmlspecialchars($pageBodyClass, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>>
<div class="admin-shell">

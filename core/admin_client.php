<?php

require_once __DIR__ . '/mail.php';
require_once __DIR__ . '/entities.php';

function adminClientDefaultConfig() {
    return [
        'admin_path' => 'admin-client',
        'menu' => [],
        'admin_email' => '',
        'admin_password_hash' => '',
        'two_step_email_otp_enabled' => false,
        'frontend_form_email' => '',
        'currency_code' => 'USD',
        'theme_name' => 'dark-coffee',
        'site_title' => 'Willow Cup Coffee - The Community Peace Spot',
        'meta_description' => 'A modern, responsive webpage using Materialize CSS and jQuery with an indigo color theme.',
        'meta_keywords' => 'Materialize CSS, jQuery, Responsive Web Design, SEO, Indigo Theme',
        'meta_author' => 'Your Name',
        'og_title' => 'Materialize Webpage with Indigo Theme',
        'og_description' => 'A modern, SEO-optimized webpage using Materialize CSS and jQuery.',
        'og_url' => 'https://aperiq.in',
        'frontend_navigation' => [
            'top_nav' => [
                ['name' => 'home', 'label' => 'Home', 'href' => '/', 'target' => '_top'],
                ['name' => 'menu', 'label' => 'Menu', 'href' => 'menu/', 'target' => '_top'],
                ['name' => 'shop', 'label' => 'Shop', 'href' => 'shop/', 'target' => '_top'],
                ['name' => 'about', 'label' => 'About', 'href' => '/about', 'target' => '_top'],
                ['name' => 'visit-us', 'label' => 'Visit Us', 'href' => '/visit-us', 'target' => '_top'],
            ],
            'open_menu' => [
                ['name' => 'home', 'label' => 'Home', 'href' => '/', 'target' => '_top'],
                ['name' => 'about-us', 'label' => 'About Us', 'href' => 'pages/about-us/', 'target' => '_top'],
                ['name' => 'printing-process', 'label' => 'Printing Process', 'href' => 'pages/printing-process/', 'target' => '_top'],
                ['name' => 'custom-packaging-solutions', 'label' => 'Custom Packaging Solutions', 'href' => 'pages/custom-packaging-solutions/', 'target' => '_top'],
                ['name' => 'industries-we-serve', 'label' => 'Industries We Serve', 'href' => 'pages/industries-we-serve/', 'target' => '_top'],
                ['name' => 'eco-friendly-packaging', 'label' => 'Eco-Friendly Packaging', 'href' => 'pages/eco-friendly-packaging/', 'target' => '_top'],
                ['name' => 'free-design-support', 'label' => 'Free Design Support', 'href' => 'pages/free-design-support/', 'target' => '_top'],
                ['name' => 'our-process', 'label' => 'Our Process', 'href' => 'pages/our-process/', 'target' => '_top'],
                ['name' => 'bulk-order-discounts', 'label' => 'Bulk Order Discounts', 'href' => 'pages/bulk-order-discounts/', 'target' => '_top'],
                ['name' => 'client-portfolio', 'label' => 'Client Portfolio', 'href' => 'pages/client-portfolio/', 'target' => '_top'],
                ['name' => 'knowledge-center', 'label' => 'Knowledge Center', 'href' => 'pages/knowledge-center/', 'target' => '_top'],
                ['name' => 'faqs', 'label' => 'FAQs', 'href' => 'pages/faqs/', 'target' => '_top'],
            ],
        ],
    ];
}

function adminClientSanitizePath($path) {
    $path = strtolower(trim((string) $path));
    $path = trim($path, '/');
    $path = preg_replace('/[^a-z0-9\-_\/]/', '', $path);
    return $path !== '' ? $path : 'admin-client';
}

function adminClientNormalizeEmail($email) {
    return strtolower(trim((string) $email));
}

function adminClientNormalizeThemeName($themeName) {
    $themeName = strtolower(trim((string) $themeName));
    $themeName = preg_replace('/[^a-z0-9\-_]/', '', $themeName);
    return $themeName !== '' ? $themeName : 'dark-coffee';
}

function adminClientAvailableThemes($themesDir = null) {
    $themesDir = $themesDir ?: dirname(__DIR__) . '/themes';
    $themes = [];

    if (!is_dir($themesDir)) {
        return ['dark-coffee'];
    }

    foreach (scandir($themesDir) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        if (is_dir($themesDir . '/' . $entry)) {
            $themes[] = adminClientNormalizeThemeName($entry);
        }
    }

    $themes = array_values(array_unique(array_filter($themes)));
    sort($themes, SORT_NATURAL | SORT_FLAG_CASE);

    return !empty($themes) ? $themes : ['dark-coffee'];
}

function adminClientThemeHomepageMap() {
    return [
        'dark-coffee' => 'home',
        'light-coffee' => 'home',
        'white-coffee' => 'home-two',
        'minimal-coffee' => 'home-3',
    ];
}

function adminClientThemeHomepageName($themeName) {
    $themeName = adminClientNormalizeThemeName($themeName);
    $map = adminClientThemeHomepageMap();
    return $map[$themeName] ?? 'home';
}

function adminClientSetCurrentHomePageForTheme($themeName) {
    $themeName = adminClientNormalizeThemeName($themeName);
    $homePageName = adminClientThemeHomepageName($themeName);

    $entityTypeRows = getEntityTypeByName('home-page');
    if (empty($entityTypeRows) || empty($entityTypeRows[0]['id'])) {
        return [
            'success' => false,
            'message' => 'Home page entity type not found.',
        ];
    }

    $homePageTypeId = (int) $entityTypeRows[0]['id'];
    $attributeRows = getAttributeByName('is_current_home');
    if (empty($attributeRows) || empty($attributeRows[0]['id'])) {
        return [
            'success' => false,
            'message' => 'is_current_home attribute not found.',
        ];
    }

    $currentHomeAttributeId = (int) $attributeRows[0]['id'];
    $targetEntityRows = getEntityByNameAndTypeId($homePageName, $homePageTypeId);
    if (empty($targetEntityRows) || empty($targetEntityRows[0]['id'])) {
        return [
            'success' => false,
            'message' => 'Mapped home page entity not found for theme.',
        ];
    }

    $targetEntityId = (int) $targetEntityRows[0]['id'];
    clearTruthyAttributeFromOtherEntities($homePageTypeId, $currentHomeAttributeId, $targetEntityId);
    setEntityAttributeValue($targetEntityId, $currentHomeAttributeId, 'on');

    return [
        'success' => true,
        'message' => 'Homepage updated.',
        'home_page_name' => $homePageName,
        'entity_id' => $targetEntityId,
    ];
}

function adminClientApplyThemeSelection($themeName, $configFile) {
    $themeName = adminClientNormalizeThemeName($themeName);
    $availableThemes = adminClientAvailableThemes();

    if (!in_array($themeName, $availableThemes, true)) {
        return [
            'success' => false,
            'message' => 'Invalid theme selected.',
        ];
    }

    if (!adminClientSaveConfig($configFile, ['theme_name' => $themeName])) {
        return [
            'success' => false,
            'message' => 'Unable to save theme settings.',
        ];
    }

    $homePageUpdate = adminClientSetCurrentHomePageForTheme($themeName);
    if (empty($homePageUpdate['success'])) {
        return [
            'success' => false,
            'message' => (string) ($homePageUpdate['message'] ?? 'Unable to update homepage.'),
        ];
    }

    return [
        'success' => true,
        'message' => 'Theme updated successfully.',
        'theme_name' => $themeName,
        'home_page_name' => $homePageUpdate['home_page_name'] ?? adminClientThemeHomepageName($themeName),
    ];
}

function adminClientAllowedCurrencies() {
    return ['USD', 'INR', 'EUR', 'GBP', 'AED'];
}

function adminClientNormalizeCurrencyCode($currencyCode) {
    $currencyCode = strtoupper(trim((string) $currencyCode));
    return in_array($currencyCode, adminClientAllowedCurrencies(), true) ? $currencyCode : 'USD';
}

function adminClientNormalizeText($value) {
    return trim((string) $value);
}

function adminClientFriendlyName($value) {
    $value = strtolower(trim((string) $value));
    $value = preg_replace('/[^a-z0-9\-\s_]+/', '', $value);
    $value = preg_replace('/[\s_]+/', '-', $value);
    $value = trim((string) $value, '-');
    return $value;
}

function adminClientNormalizeFrontendNavigationItems($items) {
    if (!is_array($items)) {
        return [];
    }

    $normalized = [];
    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $label = trim((string) ($item['label'] ?? ''));
        $href = trim((string) ($item['href'] ?? ''));
        $name = adminClientFriendlyName($item['name'] ?? $label);
        $target = trim((string) ($item['target'] ?? '_top'));
        $target = in_array($target, ['_blank', '_top'], true) ? $target : '_top';
        if ($label === '' || $href === '') {
            continue;
        }

        $normalized[] = [
            'name' => $name !== '' ? $name : adminClientFriendlyName($label),
            'label' => $label,
            'href' => $href,
            'target' => $target,
        ];
    }

    return $normalized;
}

function adminClientNormalizeFrontendNavigation($navigation, $defaults) {
    $navigation = is_array($navigation) ? $navigation : [];

    return [
        'top_nav' => adminClientNormalizeFrontendNavigationItems($navigation['top_nav'] ?? ($defaults['top_nav'] ?? [])),
        'open_menu' => adminClientNormalizeFrontendNavigationItems($navigation['open_menu'] ?? ($defaults['open_menu'] ?? [])),
    ];
}

function adminClientAllowedUploadMimeTypes($typeName) {
    $map = [
        'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
        'photo gallery photo' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
        'video' => ['video/mp4', 'video/webm', 'video/ogg'],
        'pdf' => ['application/pdf'],
    ];

    $typeName = strtolower(trim((string) $typeName));
    return $map[$typeName] ?? [];
}

function adminClientMoveUploadedFile($file, $typeName = 'image') {
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedMimeTypes = adminClientAllowedUploadMimeTypes($typeName);
    if (!empty($allowedMimeTypes)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedMimeTypes, true)) {
            return null;
        }
    }

    $mediaDir = dirname(__DIR__) . '/media/';
    if (!is_dir($mediaDir)) {
        mkdir($mediaDir, 0755, true);
    }

    $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename((string) ($file['name'] ?? 'upload')));
    $targetName = uniqid('', true) . '_' . $safeName;
    $targetPath = $mediaDir . $targetName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return null;
    }

    return 'media/' . $targetName;
}

function adminClientNormalizeAttributeLabels($labels) {
    if (!is_array($labels)) {
        return [];
    }

    $normalized = [];
    foreach ($labels as $key => $value) {
        $labelKey = trim((string) $key);
        $labelValue = trim((string) $value);
        if ($labelKey === '' || $labelValue === '') {
            continue;
        }
        $normalized[$labelKey] = $labelValue;
    }

    return $normalized;
}

function adminClientNormalizeMenu($menu) {
    if (!is_array($menu)) {
        return [];
    }

    $normalizedMenu = [];
    foreach ($menu as $item) {
        if (!is_array($item)) {
            continue;
        }

        $entityType = trim((string) ($item['entity_type'] ?? ''));
        $children = adminClientNormalizeMenu($item['children'] ?? []);

        if ($entityType === '' && empty($children)) {
            continue;
        }

        $fallbackLabel = $entityType !== ''
            ? ucwords(str_replace(['-', '_'], ' ', $entityType))
            : 'Section';

        $normalizedMenu[] = [
            'label' => trim((string) ($item['label'] ?? $fallbackLabel)) ?: $fallbackLabel,
            'entity_type' => $entityType,
            'icon' => trim((string) ($item['icon'] ?? 'folder')) ?: 'folder',
            'type' => trim((string) ($item['type'] ?? 'list')) ?: 'list',
            'children' => $children,
            'attribute_labels' => adminClientNormalizeAttributeLabels($item['attribute_labels'] ?? []),
        ];
    }

    return $normalizedMenu;
}

function adminClientNormalizeConfig($config) {
    $defaults = adminClientDefaultConfig();
    $config = is_array($config) ? array_merge($defaults, $config) : $defaults;
    $config['admin_path'] = adminClientSanitizePath($config['admin_path'] ?? $defaults['admin_path']);
    $config['menu'] = adminClientNormalizeMenu($config['menu'] ?? []);
    $config['admin_email'] = adminClientNormalizeEmail($config['admin_email'] ?? $defaults['admin_email']);
    $config['admin_password_hash'] = trim((string) ($config['admin_password_hash'] ?? $defaults['admin_password_hash']));
    $config['two_step_email_otp_enabled'] = !empty($config['two_step_email_otp_enabled']);
    $config['frontend_form_email'] = adminClientNormalizeEmail($config['frontend_form_email'] ?? '');
    $config['currency_code'] = adminClientNormalizeCurrencyCode($config['currency_code'] ?? ($defaults['currency_code'] ?? 'USD'));
    $config['theme_name'] = adminClientNormalizeThemeName($config['theme_name'] ?? 'dark-coffee');
    $config['site_title'] = adminClientNormalizeText($config['site_title'] ?? $defaults['site_title']);
    $config['meta_description'] = adminClientNormalizeText($config['meta_description'] ?? $defaults['meta_description']);
    $config['meta_keywords'] = adminClientNormalizeText($config['meta_keywords'] ?? $defaults['meta_keywords']);
    $config['meta_author'] = adminClientNormalizeText($config['meta_author'] ?? $defaults['meta_author']);
    $config['og_title'] = adminClientNormalizeText($config['og_title'] ?? $defaults['og_title']);
    $config['og_description'] = adminClientNormalizeText($config['og_description'] ?? $defaults['og_description']);
    $config['og_url'] = adminClientNormalizeText($config['og_url'] ?? $defaults['og_url']);
    $config['frontend_navigation'] = adminClientNormalizeFrontendNavigation($config['frontend_navigation'] ?? [], $defaults['frontend_navigation'] ?? []);

    return $config;
}

function adminClientFindMenuItemByEntityType($menu, $entityType) {
    foreach ($menu as $item) {
        if (($item['entity_type'] ?? '') === $entityType) {
            return $item;
        }

        if (!empty($item['children'])) {
            $childMatch = adminClientFindMenuItemByEntityType($item['children'], $entityType);
            if ($childMatch !== null) {
                return $childMatch;
            }
        }
    }

    return null;
}

function loadAdminClientConfig($configFile) {
    if (!is_file($configFile) || !is_readable($configFile)) {
        return adminClientNormalizeConfig(adminClientDefaultConfig());
    }

    $rawConfig = file_get_contents($configFile);
    if ($rawConfig === false) {
        return adminClientNormalizeConfig(adminClientDefaultConfig());
    }

    $decoded = json_decode($rawConfig, true);
    if (!is_array($decoded)) {
        return adminClientNormalizeConfig(adminClientDefaultConfig());
    }

    return adminClientNormalizeConfig($decoded);
}

function adminClientBackupDirectory($configFile) {
    return dirname($configFile) . '/backups';
}

function adminClientEnsureBackupDirectory($backupDir) {
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
}

function adminClientBackupConfigFile($configFile, $maxVersions = 6) {
    if (!is_file($configFile)) {
        return;
    }

    $backupDir = adminClientBackupDirectory($configFile);
    adminClientEnsureBackupDirectory($backupDir);

    $timestamp = date('Ymd-His');
    $backupFile = $backupDir . '/admin_client.' . $timestamp . '.json';
    copy($configFile, $backupFile);

    $backups = glob($backupDir . '/admin_client.*.json');
    if (!is_array($backups)) {
        return;
    }

    rsort($backups, SORT_STRING);
    foreach (array_slice($backups, $maxVersions) as $oldBackup) {
        if (is_file($oldBackup)) {
            unlink($oldBackup);
        }
    }
}

function adminClientSaveConfig($configFile, $updates) {
    $existingConfig = loadAdminClientConfig($configFile);
    $mergedConfig = adminClientNormalizeConfig(array_merge($existingConfig, is_array($updates) ? $updates : []));

    if (is_file($configFile)) {
        adminClientBackupConfigFile($configFile, 6);
    } else {
        adminClientEnsureBackupDirectory(adminClientBackupDirectory($configFile));
    }

    $json = json_encode($mergedConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    return file_put_contents($configFile, $json . PHP_EOL) !== false;
}

function adminClientFormattedMenuPdfPath() {
    return dirname(__DIR__) . '/cache/formatted-menu-pdf.html';
}

function adminClientLoadFormattedMenuPdfHtml() {
    $file = adminClientFormattedMenuPdfPath();
    if (!is_file($file) || !is_readable($file)) {
        return '';
    }

    $html = file_get_contents($file);
    return $html === false ? '' : (string) $html;
}

function adminClientSaveFormattedMenuPdfHtml($html) {
    $html = trim((string) $html);
    if ($html === '' || stripos($html, 'menu-pdf-source') === false) {
        return false;
    }

    $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html);
    $html = preg_replace('/\scontenteditable="[^"]*"/i', '', $html);
    $html = preg_replace('/\sspellcheck="[^"]*"/i', '', $html);
    $html = preg_replace(
        '/(<[^>]*class="[^"]*\bmenu-pdf-source\b[^"]*"[^>]*?)\sstyle="[^"]*"/i',
        '$1',
        $html
    );
    $cacheDir = dirname(adminClientFormattedMenuPdfPath());
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }

    return file_put_contents(adminClientFormattedMenuPdfPath(), $html . PHP_EOL) !== false;
}

function adminClientDeleteFormattedMenuPdfHtml() {
    $file = adminClientFormattedMenuPdfPath();
    if (!is_file($file)) {
        return true;
    }

    return unlink($file);
}

function adminClientAllowedPaths($adminPath, $fallbackPath = 'admin-client') {
    $paths = [adminClientSanitizePath($fallbackPath), adminClientSanitizePath($adminPath)];
    return array_values(array_unique($paths));
}

function adminClientPathIsAllowed($requestUri, $adminPath, $fallbackPath = 'admin-client') {
    $requestPath = strtolower((string) parse_url((string) $requestUri, PHP_URL_PATH));
    foreach (adminClientAllowedPaths($adminPath, $fallbackPath) as $allowedPath) {
        if ($allowedPath !== '' && strpos($requestPath, '/' . $allowedPath) !== false) {
            return true;
        }
    }

    return false;
}

function adminClientStartSession() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function adminClientSessionKey() {
    return 'admin_client_authenticated';
}

function adminClientUserSessionKey() {
    return 'admin_client_user';
}

function adminClientOtpCodeSessionKey() {
    return 'admin_client_pending_otp_code';
}

function adminClientOtpEmailSessionKey() {
    return 'admin_client_pending_otp_email';
}

function adminClientOtpExpiresSessionKey() {
    return 'admin_client_pending_otp_expires';
}

function adminClientFlashSessionKey() {
    return 'admin_client_flash_message';
}

function adminClientFlashTypeSessionKey() {
    return 'admin_client_flash_type';
}

function adminClientIsAuthenticated() {
    adminClientStartSession();
    return !empty($_SESSION[adminClientSessionKey()]);
}

function adminClientAuthenticate($email) {
    adminClientStartSession();
    $_SESSION[adminClientSessionKey()] = true;
    $_SESSION[adminClientUserSessionKey()] = strtolower(trim((string) $email));
}

function adminClientLogout() {
    adminClientStartSession();
    unset(
        $_SESSION[adminClientSessionKey()],
        $_SESSION[adminClientUserSessionKey()],
        $_SESSION[adminClientOtpCodeSessionKey()],
        $_SESSION[adminClientOtpEmailSessionKey()],
        $_SESSION[adminClientOtpExpiresSessionKey()],
        $_SESSION[adminClientFlashSessionKey()],
        $_SESSION[adminClientFlashTypeSessionKey()]
    );
}

function adminClientSetFlash($message, $type = 'success') {
    adminClientStartSession();
    $_SESSION[adminClientFlashSessionKey()] = trim((string) $message);
    $_SESSION[adminClientFlashTypeSessionKey()] = trim((string) $type) ?: 'success';
}

function adminClientConsumeFlash() {
    adminClientStartSession();
    $message = (string) ($_SESSION[adminClientFlashSessionKey()] ?? '');
    $type = (string) ($_SESSION[adminClientFlashTypeSessionKey()] ?? 'success');

    unset($_SESSION[adminClientFlashSessionKey()], $_SESSION[adminClientFlashTypeSessionKey()]);

    if ($message === '') {
        return null;
    }

    return [
        'message' => $message,
        'type' => $type,
    ];
}

function adminClientVerifyCredentials($config, $email, $password) {
    $configuredEmail = strtolower(trim((string) ($config['admin_email'] ?? '')));
    $configuredHash = (string) ($config['admin_password_hash'] ?? '');
    $email = strtolower(trim((string) $email));

    if ($configuredEmail === '' || $configuredHash === '') {
        return false;
    }

    if (!hash_equals($configuredEmail, $email)) {
        return false;
    }

    return password_verify((string) $password, $configuredHash);
}

function adminClientOtpEnabled($config) {
    return !empty($config['two_step_email_otp_enabled']);
}

function adminClientGenerateOtpCode() {
    return str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
}

function adminClientStartOtpChallenge($email, $otpCode) {
    adminClientStartSession();
    $_SESSION[adminClientOtpEmailSessionKey()] = strtolower(trim((string) $email));
    $_SESSION[adminClientOtpCodeSessionKey()] = (string) $otpCode;
    $_SESSION[adminClientOtpExpiresSessionKey()] = time() + 600;
}

function adminClientHasPendingOtp() {
    adminClientStartSession();
    return !empty($_SESSION[adminClientOtpCodeSessionKey()])
        && !empty($_SESSION[adminClientOtpEmailSessionKey()])
        && !empty($_SESSION[adminClientOtpExpiresSessionKey()]);
}

function adminClientPendingOtpEmail() {
    adminClientStartSession();
    return (string) ($_SESSION[adminClientOtpEmailSessionKey()] ?? '');
}

function adminClientClearOtpChallenge() {
    adminClientStartSession();
    unset(
        $_SESSION[adminClientOtpCodeSessionKey()],
        $_SESSION[adminClientOtpEmailSessionKey()],
        $_SESSION[adminClientOtpExpiresSessionKey()]
    );
}

function adminClientVerifyOtpCode($otpCode) {
    adminClientStartSession();

    if (!adminClientHasPendingOtp()) {
        return false;
    }

    $expiresAt = (int) ($_SESSION[adminClientOtpExpiresSessionKey()] ?? 0);
    if ($expiresAt < time()) {
        adminClientClearOtpChallenge();
        return false;
    }

    $expectedCode = (string) ($_SESSION[adminClientOtpCodeSessionKey()] ?? '');
    return hash_equals($expectedCode, trim((string) $otpCode));
}

function adminClientSendOtpEmail($config, $otpCode) {
    $to = (string) ($config['admin_email'] ?? '');
    if ($to === '') {
        return false;
    }

    $subject = 'Your client admin verification code';
    $plainText = "Your 4 digit verification code is: {$otpCode}";
    $htmlContent = '<p>Your 4 digit verification code is:</p><h2>' . htmlspecialchars($otpCode) . '</h2>';
    $result = sendEmail($to, $to, $subject, $plainText, $htmlContent);

    return strpos((string) $result, 'Email sent successfully') === 0;
}

?>

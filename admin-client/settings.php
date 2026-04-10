<?php
$pageTitle = 'Settings';
$flash = adminClientConsumeFlash();
$themesDir = dirname(__DIR__) . '/themes';
$availableThemes = [];

if (is_dir($themesDir)) {
    foreach (scandir($themesDir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        if (is_dir($themesDir . '/' . $entry)) {
            $availableThemes[] = $entry;
        }
    }
}

sort($availableThemes, SORT_NATURAL | SORT_FLAG_CASE);
if (empty($availableThemes)) {
    $availableThemes = ['dark-coffee'];
}

$currentTheme = $config['theme_name'] ?? 'dark-coffee';
$currentCurrency = $config['currency_code'] ?? 'USD';
$availableCurrencies = adminClientAllowedCurrencies();
?>
<section class="admin-content">
    <?php if (!empty($flash['message'])) { ?>
        <div class="card-panel <?php echo ($flash['type'] ?? 'success') === 'error' ? 'red lighten-4 red-text text-darken-4' : 'green lighten-4 green-text text-darken-4'; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php } ?>

    <form method="post" action="settings_save.php">
        <div class="admin-card">
            <div class="card-label">Admin Settings</div>
            <h4 style="margin-top: 0;">Access Settings</h4>
            <div class="input-field" style="margin-top: 24px;">
                <input type="text" id="admin_access_path" name="admin_path" value="<?php echo htmlspecialchars($config['admin_path']); ?>">
                <label class="active" for="admin_access_path">Admin Access Path</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="email" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($config['admin_email']); ?>">
                <label class="active" for="admin_email">Registered Admin Email</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="email" id="frontend_form_email" name="frontend_form_email" value="<?php echo htmlspecialchars($config['frontend_form_email'] ?? ''); ?>">
                <label class="active" for="frontend_form_email">Frontend Form Submission Email</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <select id="theme_name" name="theme_name">
                    <?php foreach ($availableThemes as $themeName) { ?>
                        <option value="<?php echo htmlspecialchars($themeName); ?>" <?php echo $themeName === $currentTheme ? 'selected' : ''; ?>><?php echo htmlspecialchars(ucwords(str_replace(['-', '_'], ' ', $themeName))); ?></option>
                    <?php } ?>
                </select>
                <label for="theme_name">Frontend Theme</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <select id="currency_code" name="currency_code">
                    <?php foreach ($availableCurrencies as $currencyCode) { ?>
                        <option value="<?php echo htmlspecialchars($currencyCode); ?>" <?php echo $currencyCode === $currentCurrency ? 'selected' : ''; ?>><?php echo htmlspecialchars($currencyCode); ?></option>
                    <?php } ?>
                </select>
                <label for="currency_code">Dashboard Currency</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="text" id="site_title" name="site_title" value="<?php echo htmlspecialchars($config['site_title'] ?? ''); ?>">
                <label class="active" for="site_title">Site Title</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <textarea id="meta_description" name="meta_description" class="materialize-textarea"><?php echo htmlspecialchars($config['meta_description'] ?? ''); ?></textarea>
                <label class="active" for="meta_description">Meta Description</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo htmlspecialchars($config['meta_keywords'] ?? ''); ?>">
                <label class="active" for="meta_keywords">Meta Keywords</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="text" id="meta_author" name="meta_author" value="<?php echo htmlspecialchars($config['meta_author'] ?? ''); ?>">
                <label class="active" for="meta_author">Meta Author</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="text" id="og_title" name="og_title" value="<?php echo htmlspecialchars($config['og_title'] ?? ''); ?>">
                <label class="active" for="og_title">Open Graph Title</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <textarea id="og_description" name="og_description" class="materialize-textarea"><?php echo htmlspecialchars($config['og_description'] ?? ''); ?></textarea>
                <label class="active" for="og_description">Open Graph Description</label>
            </div>
            <div class="input-field" style="margin-top: 24px;">
                <input type="text" id="og_url" name="og_url" value="<?php echo htmlspecialchars($config['og_url'] ?? ''); ?>">
                <label class="active" for="og_url">Open Graph URL</label>
            </div>
            <p class="helper-note">You can also edit this in config/admin_client.json manually.</p>
            <button type="submit" class="btn brown">Save Settings</button>
        </div>

        <div class="admin-card">
            <div class="card-label">Security</div>
            <h4 style="margin-top: 0;">Two-Step Email Passcode</h4>
            <p class="helper-note">A 4 digit passcode can be sent to the registered admin email for two-step authentication. This is coded but kept disabled for now until it can be tested on the live server.</p>
            <div class="switch" style="margin-top: 18px;">
                <label>
                    Off
                    <input type="checkbox" name="two_step_email_otp_enabled" <?php echo !empty($config['two_step_email_otp_enabled']) ? 'checked' : ''; ?> disabled>
                    <span class="lever"></span>
                    On
                </label>
            </div>
        </div>

        <div class="admin-card">
            <div class="card-label">PDF Settings</div>
            <h4 style="margin-top: 0;">Menu PDF Layout</h4>
            <p class="helper-note">Open the PDF Layout page to preview the menu inside A4 break guides, then nudge content spacing manually before exporting.</p>
            <a href="index.php?page=pdf-layout" class="btn brown">Open PDF Layout</a>
        </div>
    </form>
</section>

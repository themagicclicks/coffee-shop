<?php

if (!function_exists('themeDemoSwitcherBootstrap')) {
    function themeDemoSwitcherBootstrap() {
        if (defined('BASE') && defined('SITE') && function_exists('loadAdminClientConfig')) {
            return;
        }

        require_once dirname(__DIR__) . '/core/env.php';
        loadEnv(dirname(__DIR__) . '/.env');

        if (!defined('BASE')) {
            define('BASE', $_ENV['BASE'] ?? (dirname(__DIR__) . '/'));
        }

        if (!defined('SITE')) {
            define('SITE', $_ENV['SITE'] ?? '/');
        }

        require_once dirname(__DIR__) . '/core/admin_client.php';
        require_once dirname(__DIR__) . '/core/entities.php';
    }

    function themeDemoSwitcherCurrentUrl() {
        $requestUri = (string) ($_SERVER['REQUEST_URI'] ?? SITE);
        return $requestUri !== '' ? $requestUri : SITE;
    }

    function themeDemoSwitcherHandleRequest() {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            return;
        }

        $requestedAction = (string) ($_POST['action'] ?? ($_GET['action'] ?? ''));
        if ($requestedAction !== 'switch-theme') {
            return;
        }

        themeDemoSwitcherBootstrap();

        header('Content-Type: application/json; charset=utf-8');
        $themeName = (string) ($_POST['theme_name'] ?? '');
        $result = adminClientApplyThemeSelection($themeName, BASE . 'config/admin_client.json');
        echo json_encode($result, JSON_UNESCAPED_SLASHES);
        exit;
    }

    function renderThemeDemoSwitcher() {
        themeDemoSwitcherBootstrap();

        $config = loadAdminClientConfig(BASE . 'config/admin_client.json');
        $currentTheme = adminClientNormalizeThemeName($config['theme_name'] ?? 'dark-coffee');
        $availableThemes = adminClientAvailableThemes();
        $currentUrl = themeDemoSwitcherCurrentUrl();
        ob_start();
        ?>
        <div class="demo-theme-switcher" data-current-theme="<?php echo htmlspecialchars($currentTheme, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            <div class="demo-theme-switcher__inner">
                <span class="demo-theme-switcher__label">Demo Theme</span>
                <select class="demo-theme-switcher__select browser-default" aria-label="Select demo theme">
                    <?php foreach ($availableThemes as $themeName) { ?>
                        <option value="<?php echo htmlspecialchars($themeName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" <?php echo $themeName === $currentTheme ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars(ucwords(str_replace(['-', '_'], ' ', $themeName)), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </option>
                    <?php } ?>
                </select>
                <span class="demo-theme-switcher__status" aria-live="polite"></span>
            </div>
        </div>
        <style>
            .demo-theme-switcher {
				position: fixed;
				top: 10px;
				left: 10px;
				/* transform: translateX(-50%); */
				z-index: 10000;
				width: min(92vw, 400px);
				pointer-events: none;
			}
            .demo-theme-switcher__inner {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 14px;
                border-radius: 999px;
                background: rgba(24, 17, 12, 0.88);
                color: #fffdf8;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
                backdrop-filter: blur(8px);
                pointer-events: auto;
                min-width: 0;
            }
            .demo-theme-switcher__label {
                font-size: 0.75rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                white-space: nowrap;
                opacity: 0.9;
                flex: 0 0 auto;
            }
            .demo-theme-switcher__select {
                flex: 1 1 auto;
                min-width: 0;
                height: 38px;
                margin: 0;
                padding: 0 42px 0 14px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.1);
                color: #fffdf8 !important;
                -webkit-text-fill-color: #fffdf8;
                font-size: 0.95rem;
                font-weight: 500;
                line-height: 1.2;
                outline: none;
                cursor: pointer;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image:
                    linear-gradient(45deg, transparent 50%, #fffdf8 50%),
                    linear-gradient(135deg, #fffdf8 50%, transparent 50%);
                background-position:
                    calc(100% - 22px) 15px,
                    calc(100% - 16px) 15px;
                background-size: 6px 6px, 6px 6px;
                background-repeat: no-repeat;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                box-shadow: none;
            }
            .demo-theme-switcher__select option {
                color: #22170f;
            }
            .demo-theme-switcher__status {
                min-width: 0;
                flex: 0 0 64px;
                font-size: 0.76rem;
                text-align: right;
                color: #e6d7c6;
                white-space: nowrap;
            }
            .demo-theme-switcher[data-state="saving"] .demo-theme-switcher__status {
                color: #ffd479;
            }
            .demo-theme-switcher[data-state="success"] .demo-theme-switcher__status {
                color: #b7ffbf;
            }
            .demo-theme-switcher[data-state="error"] .demo-theme-switcher__status {
                color: #ffb0b0;
            }
            @media (max-width: 767px) {
                .demo-theme-switcher {
                    top: 8px;
                    width: min(96vw, 360px);
                }
                .demo-theme-switcher__inner {
                    gap: 8px;
                    padding: 8px 10px;
                }
                .demo-theme-switcher__label,
                .demo-theme-switcher__status {
                    font-size: 0.68rem;
                }
            }
        </style>
        <script>
            (function () {
                var root = document.currentScript ? document.currentScript.previousElementSibling : document.querySelector('.demo-theme-switcher');
                if (!root || !root.classList.contains('demo-theme-switcher')) {
                    root = document.querySelector('.demo-theme-switcher');
                }
                if (!root) {
                    return;
                }

                var select = root.querySelector('.demo-theme-switcher__select');
                var status = root.querySelector('.demo-theme-switcher__status');
                var endpoint = <?php echo json_encode(SITE . 'includes/theme_demo_switcher.php?action=switch-theme'); ?>;
                var currentUrl = <?php echo json_encode($currentUrl); ?>;

                function setState(state, message) {
                    root.setAttribute('data-state', state || '');
                    if (status) {
                        status.textContent = message || '';
                    }
                }

                if (!select) {
                    return;
                }

                select.addEventListener('change', function () {
                    var selectedTheme = select.value || '';
                    if (!selectedTheme) {
                        return;
                    }

                    setState('saving', 'Saving...');
                    select.disabled = true;

                    var body = new FormData();
                    body.append('action', 'switch-theme');
                    body.append('theme_name', selectedTheme);

                    fetch(endpoint, {
                        method: 'POST',
                        body: body,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (data) {
                        if (!data || !data.success) {
                            throw new Error((data && data.message) || 'Unable to switch theme.');
                        }

                        setState('success', 'Updated');
                        window.location.href = currentUrl;
                    })
                    .catch(function (error) {
                        setState('error', error && error.message ? error.message : 'Unable to switch theme.');
                    })
                    .finally(function () {
                        select.disabled = false;
                    });
                });
            })();
        </script>
        <?php
        return ob_get_clean();
    }
}

themeDemoSwitcherHandleRequest();

if (!defined('THEME_DEMO_SWITCHER_INCLUDED')) {
    define('THEME_DEMO_SWITCHER_INCLUDED', true);
    echo renderThemeDemoSwitcher();
}

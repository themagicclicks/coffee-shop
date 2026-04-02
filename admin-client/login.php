<?php

require_once __DIR__ . '/../core/admin_client.php';

$config = loadAdminClientConfig(__DIR__ . '/../config/admin_client.json');
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$errorMessage = '';
$infoMessage = '';
$loginStep = 'credentials';

if (!adminClientPathIsAllowed($requestUri, $config['admin_path'])) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invalid admin access path</title>
        <link rel="stylesheet" href="../css/materialize.min.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="amber lighten-5">
        <div class="container" style="padding-top: 80px; max-width: 680px;">
            <div class="card-panel white">
                <h4>Invalid admin access path</h4>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

adminClientStartSession();

if (adminClientIsAuthenticated()) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    adminClientClearOtpChallenge();
}

if (adminClientHasPendingOtp()) {
    $loginStep = 'otp';
    $infoMessage = 'Enter the 4 digit passcode sent to ' . adminClientPendingOtpEmail() . '.';
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $formAction = (string) ($_POST['form_action'] ?? 'credentials');

    if ($formAction === 'otp') {
        $loginStep = 'otp';
        $otpCode = trim((string) ($_POST['otp_code'] ?? ''));

        if (adminClientVerifyOtpCode($otpCode)) {
            $email = adminClientPendingOtpEmail();
            adminClientClearOtpChallenge();
            adminClientAuthenticate($email);
            header('Location: index.php');
            exit;
        }

        $errorMessage = 'Invalid or expired passcode.';
        $infoMessage = 'Enter the 4 digit passcode sent to ' . adminClientPendingOtpEmail() . '.';
    } else {
        $email = strtolower(trim((string) ($_POST['email'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        if (adminClientVerifyCredentials($config, $email, $password)) {
            if (adminClientOtpEnabled($config)) {
                $otpCode = adminClientGenerateOtpCode();
                if (adminClientSendOtpEmail($config, $otpCode)) {
                    adminClientStartOtpChallenge($email, $otpCode);
                    $loginStep = 'otp';
                    $infoMessage = 'Enter the 4 digit passcode sent to ' . $email . '.';
                } else {
                    $errorMessage = 'Two-step verification is enabled, but the passcode email could not be sent.';
                }
            } else {
                adminClientAuthenticate($email);
                header('Location: index.php');
                exit;
            }
        } else {
            $errorMessage = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Client Admin</title>
    <link rel="stylesheet" href="../css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="admin-login-page">
    <div class="login-card">
        <h4>Client Admin Login</h4>
        <p class="helper-note">Use the registered admin email and password to access this panel.</p>
        <?php if ($infoMessage !== '') { ?>
            <div class="card-panel blue lighten-5 blue-text text-darken-4"><?php echo htmlspecialchars($infoMessage); ?></div>
        <?php } ?>
        <?php if ($errorMessage !== '') { ?>
            <div class="card-panel red lighten-5 red-text text-darken-4"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php } ?>

        <?php if ($loginStep === 'otp') { ?>
            <form method="post" action="">
                <input type="hidden" name="form_action" value="otp">
                <div class="input-field">
                    <input type="text" id="otp_code" name="otp_code" maxlength="4" pattern="[0-9]{4}" required>
                    <label for="otp_code">4 Digit Passcode</label>
                </div>
                <button type="submit" class="btn brown">Verify Passcode</button>
                <a href="login.php?reset=1" class="btn-flat">Start again</a>
            </form>
        <?php } else { ?>
            <form method="post" action="">
                <input type="hidden" name="form_action" value="credentials">
                <div class="input-field">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <button type="submit" class="btn brown">Login</button>
            </form>
        <?php } ?>
    </div>
    <script src="../js/materialize.min.js"></script>
    <script src="js/scriopts.js"></script>
</body>
</html>

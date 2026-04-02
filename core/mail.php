<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../includes/phpMailer/PHPMailer.php';
require_once __DIR__ . '/../includes/phpMailer/SMTP.php';
require_once __DIR__ . '/../includes/phpMailer/Exception.php';

function sendEmail($from, $to, $subject, $plainText, $htmlContent = '', $cc = [], $bcc = []) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yourserver.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com';
        $mail->Password = 'your-email-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($from);
        $mail->addAddress($to);

        foreach ($cc as $ccEmail) {
            $mail->addCC($ccEmail);
        }

        foreach ($bcc as $bccEmail) {
            $mail->addBCC($bccEmail);
        }

        $mail->Subject = $subject;
        $mail->Body = $htmlContent ?: nl2br($plainText);
        $mail->AltBody = $plainText;
        $mail->isHTML(true);

        if ($mail->send()) {
            return "Email sent successfully to $to";
        }
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}

?>

<?php
require __DIR__ . '/config.php';
require __DIR__ . '/../includes/recaptcha.php';
require_once __DIR__ . '/../includes/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../includes/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../includes/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    $sujet  = htmlspecialchars(trim($_POST['sujet'] ?? ''));
    $origin  = htmlspecialchars($_POST['origin'] ?? 'inconnu');
    $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
    
    // Honeypot check
    if (!empty($_POST['hp_field'])) {
        // Silent exit or redirect to home to fool bots
        exit;
    }

    $query = http_build_query([
        'origin' => $origin,
        'error' => 'missing_fields',
        'name' => $name,
        'email' => $email,
        'sujet' => $sujet,
        'message' => $message,
    ]);

    if (!$name || !$email || !$sujet || !$message) {
        $query = http_build_query([
            'origin' => $origin,
            'error' => 'missing_fields',
            'name' => $name,
            'email' => $email,
            'sujet' => $sujet,
            'message' => $message,
        ]);
        header("Location: ../index.php?$query");
        exit;
    }
    
    if (!$recaptchaToken || !verifyRecaptcha($recaptchaToken)) {
        $query = http_build_query([
            'origin' => $origin,
            'error' => 'recaptcha_failed',
            'name' => $name,
            'email' => $email,
            'sujet' => $sujet,
            'message' => $message,
        ]);
        header("Location: ../index.php?$query");
        exit;
    }
    

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = '8bit';

    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = SMTP_PORT;

        $mail->setFrom(SMTP_FROM, 'Formulaire central');
        $mail->addAddress(SMTP_TO);
        $mail->Subject = "[$origin] $sujet";
        $mail->Body = "Nom : $name\nEmail : $email\nSite : $origin\nSujet : $sujet\n\nMessage :\n$message";


        $mail->send();
        header("Location: ../index.php?origin=" . urlencode($origin) . "&success=1");
        exit;        
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du mail : {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}

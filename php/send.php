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

    if (!$name || !$email || !$sujet || !$message || !$recaptchaToken) {
        die('Tous les champs sont requis.');
    }    

    if (!verifyRecaptcha($recaptchaToken)) {
        die('Échec du reCAPTCHA. Veuillez réessayer.');
    }

    $mail = new PHPMailer(true);

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

<?php

// importamos todo lo necesario
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once('C:/xampp/htdocs/sistema-de-convenios/library/SMTP.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/POP3.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/OAuth.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/PHPMailer.php');
require_once('C:/xampp/htdocs/sistema-de-convenios/library/consulSQL.php');

// Constantes para la configuracion de correo en  mailtrap
define("EMAIL_HOST", "sandbox.smtp.mailtrap.io");
define("EMAIL_USERNAME", "6a3cd3b5e2f80b");
define("EMAIL_PASS", "7613e157944ed3");
define("EMAIL_SMTPSECURE", "tls");
define("EMAIL_PORT", 2525);
define("EMAIL_ADMIN", 'convenios@uniclaretiana.edu.co');

// Obtenmos los valores del formularios
$subject = $infoToSendEmail['subject'];
$message = $infoToSendEmail['message'];
$emails = $infoToSendEmail['emails'];

try {
    
    // Creamos el objeto PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    // Configuracion del servidor (obtenido de mailtrap)
    $mail->Host = EMAIL_HOST;
    $mail->Username = EMAIL_USERNAME;
    $mail->Password = EMAIL_PASS;
    $mail->SMTPSecure = EMAIL_SMTPSECURE;
    $mail->Port = EMAIL_PORT;

    $mail->CharSet = 'UTF-8';

    // Indicamos el origen del correo
    $mail->setFrom(EMAIL_ADMIN);

    // Añadimos el destinatario (ahora mismo solo irá a mailtrap)
    foreach ($emails as $email) {
        $mail->addAddress($email);
    }

    // Indicamos el asuento
    $mail->Subject = $subject;

    // Indicamos que puede contener codigo html
    $mail->isHTML(true);

    // Mensaje del email
    $mail->Body = $message;

    $mail->send();

} catch (Exception $e) {
    // echo "Error: {$e->ErrorInfo}";
}
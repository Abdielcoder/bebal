<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function enviarCorreoPrueba(
    string $username = "AKIAWN26JPWKZ4JKCU5L", 
    string $password = "BFRd9qXYsp2DONqo2GDZPMQdt5d5LxXF/DWaRG4IDqR0", 
    string $sender = "mchang@cycsoftware.awsapps.com", 
    string $recipient = "abdiel@astrasoft.mx", 
    string $host = "email-smtp.us-east-1.amazonaws.com", 
    int $port = 587, 
    bool $verbose = false
): bool 
{
    $mail = new PHPMailer(true);

    try {
        if ($verbose) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        }
        $mail->isSMTP();                                     
        $mail->Host       = $host;                           
        $mail->SMTPAuth   = true;                            
        $mail->Username   = $username;                       
        $mail->Password   = $password;                       
        
        if ($port == 465) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        }
        
        $mail->Port       = $port;                           

        $mail->setFrom($sender, 'Remitente de Prueba'); 
        $mail->addAddress($recipient);                   

        $mail->isHTML(true);                                 
        $mail->Subject = 'Prueba de conexión SMTP AWS SES desde PHP Abdiel';
        
        $cuerpo_html = <<<EOT
        <h1>Prueba de Conexión SMTP</h1>
        <p>Este es un mensaje de prueba enviado usando <strong>PHP (PHPMailer)</strong> para verificar
        la conexión SMTP con AWS SES.</p>
        <p>Si estás recibiendo este mensaje, la configuración es correcta.</p>
EOT;
        $cuerpo_plain = <<<EOT
        Prueba de Conexión SMTP
        -----------------------
        Este es un mensaje de prueba enviado usando PHP (PHPMailer) para verificar
        la conexión SMTP con AWS SES.
        
        Si estás recibiendo este mensaje, la configuración es correcta.
EOT;

        $mail->Body    = $cuerpo_html;
        $mail->AltBody = $cuerpo_plain; 

        echo "Intentando conectar a {$host}:{$port} y enviar correo...\n";
        $mail->send();
        echo "✅ Mensaje enviado exitosamente a {$recipient}\n";
        return true;

    } catch (Exception $e) {
        echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}\n";
        return false;
    }
}

echo "=== Test de conexión SMTP para AWS SES (PHP) ===\n\n";

$smtp_username = "AKIAWN26JPWKZ4JKCU5L";
$smtp_password = "BFRd9qXYsp2DONqo2GDZPMQdt5d5LxXF/DWaRG4IDqR0";
$email_sender = "mchang@cycsoftware.awsapps.com"; 
$email_recipient = "abdiel@astrasoft.mx";
$smtp_host = "email-smtp.us-east-1.amazonaws.com";
$smtp_port = 587; 
$enable_verbose = false; 

echo "Host SMTP:       {$smtp_host}\n";
echo "Puerto:          {$smtp_port}\n";
echo "Método:          " . ($smtp_port == 465 ? 'TLS directo' : 'STARTTLS') . "\n";
echo "Usuario:         {$smtp_username}\n";
echo "Remitente:       {$email_sender}\n";
echo "Destinatario:    {$email_recipient}\n";
echo "Modo verbose:    " . ($enable_verbose ? 'Activado' : 'Desactivado') . "\n";
echo "-------------------------------------------\n";

enviarCorreoPrueba(
    $smtp_username,
    $smtp_password,
    $email_sender,
    $email_recipient,
    $smtp_host,
    $smtp_port,
    $enable_verbose
);

echo "\n=== Fin del Test ===\n";

?> 
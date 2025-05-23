<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../MiLibreria/vendor/autoload.php';
include_once('config/conf.php');

function enviarCorreoPrueba(
    string $username,
    string $password,
    string $sender,
    string $recipient,
    string $host,
    int $port = 587, 
    bool $verbose = false
): bool 
{
    $mail = new PHPMailer(true);

    try {
        if ($verbose) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
	}
	$mail->CharSet = "UTF-8";
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
	$mail->addAttachment('img/noPDF.jpg');

        $mail->isHTML(true);                                 
        $mail->Subject = 'Prueba de conexión SMTP AWS SES desde PHP';
        
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

	$mail->Timeout =   20;

        echo "Intentando conectar a {$host}:{$port} y enviar correo...\n";
	$mail->Send();
	$mail->smtpClose();
        echo "✅ Mensaje enviado exitosamente a {$recipient}\n";
        return true;

    } catch (Exception $e) {
        echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}\n";
        return false;
    }
}

##################################
$email_recipient = $_GET["to"];
##################################

$smtp_username=$conf['smtp_username'];
$smtp_password=$conf['smtp_password'];
$email_sender=$conf['email_sender'];
$smtp_host=$conf['smtp_host'];
$smtp_port=$conf['smtp_port'];
$enable_verbose=$conf['enable_verbose'];

#################

enviarCorreoPrueba(
    $smtp_username,
    $smtp_password,
    $email_sender,
    $email_recipient,
    $smtp_host,
    $smtp_port,
    $enable_verbose
);


?> 

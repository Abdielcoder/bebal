<?php
// Importar clases de PHPMailer al espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargar el autoloader de Composer
require 'vendor/autoload.php';

/**
 * Envía un correo de prueba usando PHPMailer con configuración para AWS SES SMTP.
 *
 * @param string $username Usuario SMTP (AWS SES Key ID).
 * @param string $password Contraseña SMTP (AWS SES Secret Key).
 * @param string $sender Dirección de correo del remitente (debe estar verificada en SES).
 * @param string $recipient Dirección de correo del destinatario.
 * @param string $host Servidor SMTP de AWS SES.
 * @param int $port Puerto SMTP (587 para STARTTLS, 465 para TLS directo).
 * @param bool $verbose Activar modo detallado para diagnóstico.
 * @return bool True si el correo se envió (o la conexión fue exitosa en modo verificación), False en caso de error.
 */
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
    // Crear una instancia de PHPMailer; pasar `true` habilita excepciones
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        if ($verbose) {
            // Habilita salida de depuración detallada
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        }
        $mail->isSMTP();                                     // Enviar usando SMTP
        $mail->Host       = $host;                           // Servidor SMTP a usar
        $mail->SMTPAuth   = true;                            // Habilitar autenticación SMTP
        $mail->Username   = $username;                       // Usuario SMTP
        $mail->Password   = $password;                       // Contraseña SMTP
        
        // Determinar el tipo de cifrado basado en el puerto
        if ($port == 465) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Habilitar cifrado TLS implícito
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar cifrado STARTTLS
        }
        
        $mail->Port       = $port;                           // Puerto TCP para conectar

        // Remitente y Destinatarios
        $mail->setFrom($sender, 'Remitente de Prueba'); // Quién envía el correo
        $mail->addAddress($recipient);                   // A quién se envía el correo

        // Contenido del correo
        $mail->isHTML(true);                                 // Establecer formato de correo a HTML
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
        $mail->AltBody = $cuerpo_plain; // Cuerpo alternativo para clientes de correo que no soportan HTML

        echo "Intentando conectar a {$host}:{$port} y enviar correo...
";
        $mail->send();
        echo "✅ Mensaje enviado exitosamente a {$recipient}
";
        return true;

    } catch (Exception $e) {
        echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}
";
        // Descomentar para ver más detalles del error general si es necesario
        // echo "Detalle de la excepción: {$e->getMessage()}
"; 
        return false;
    }
}

// --- Ejecución de la prueba ---
echo "=== Test de conexión SMTP para AWS SES (PHP) ===

";

// Valores por defecto (puedes modificarlos o pasarlos como argumentos si lo necesitas)
$smtp_username = "AKIAWN26JPWKZ4JKCU5L";
$smtp_password = "BFRd9qXYsp2DONqo2GDZPMQdt5d5LxXF/DWaRG4IDqR0";
$email_sender = "mchang@cycsoftware.awsapps.com"; // Asegúrate que esta dirección esté verificada en SES
$email_recipient = "abdiel@astrasoft.mx";
$smtp_host = "email-smtp.us-east-1.amazonaws.com";
$smtp_port = 587; // Usar 587 para STARTTLS o 465 para TLS directo
$enable_verbose = false; // Cambiar a true para ver depuración SMTP

echo "Host SMTP:       {$smtp_host}
";
echo "Puerto:          {$smtp_port}
";
echo "Método:          " . ($smtp_port == 465 ? 'TLS directo' : 'STARTTLS') . "
";
echo "Usuario:         {$smtp_username}
";
echo "Remitente:       {$email_sender}
";
echo "Destinatario:    {$email_recipient}
";
echo "Modo verbose:    " . ($enable_verbose ? 'Activado' : 'Desactivado') . "
";
echo "-------------------------------------------
";

// Llamar a la función para enviar el correo de prueba
enviarCorreoPrueba(
    $smtp_username,
    $smtp_password,
    $email_sender,
    $email_recipient,
    $smtp_host,
    $smtp_port,
    $enable_verbose
);

echo "
=== Fin del Test ===
";

?> 
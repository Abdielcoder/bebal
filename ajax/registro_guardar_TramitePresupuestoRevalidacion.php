<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include_once('../config/conf.php');


function enviarCorreo(
    string $username,
    string $password,
    string $sender,
    string $recipient1,
    string $recipient2,
    string $host,
    int $port = 587,
    bool $verbose = false,
    string $mensajeEmail
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

        $mail->setFrom($sender, 'Ayuntamiento de Tijuana XXV');
        $mail->addAddress($recipient1);
        $mail->addAddress($recipient2);
        $mail->addAttachment('../img/ayuntamientoTIJXXV.png');

        $mail->isHTML(true);
        $mail->Subject = 'Programa de Identificación, Empadronamiento, Regulación y Revalidación de Establecimientos Que Expiden y Venden al Público en Envase Cerrado y Abierto, Bebidas con Contenido Alcohólico';

        $cuerpo_html = <<<EOT
        <h1>Ayuntamiento de Tijuana XXV</h1>
        <h3>Secretaria de Gobierno</h3>
	<p>Programa de Identificación, Empadronamiento, Regulación y Revalidación de Establecimientos Que Expiden y Venden al Público en Envase Cerrado y Abierto, Bebidas con Contenido Alcohólico</p>
	$mensajeEmail
EOT;
        $cuerpo_plain = <<<EOT
        Ayuntamiento de Tijuana XXV - Secretaria de Gobierno
        -----------------------
Programa de Identificación, Empadronamiento, Regulación y Revalidación de Establecimientos Que Expiden y Venden al Público en Envase Cerrado y Abierto, Bebidas con Contenido Alcohólico.
EOT;

        $mail->Body    = $cuerpo_html;
        $mail->AltBody = $cuerpo_plain;

        $mail->Timeout =   20;
        echo "Intentando conectar a {$host}:{$port} y enviar correo...\n";
        $mail->Send();
	$mail->smtpClose();

        $resultadoEnvio= "✅ Mensaje enviado exitosamente a {$recipient}\n";
        ##return true;
        return $resultadoEnvio;

    } catch (Exception $e) {
        $resultadoEnvio= "❌ Error al enviar el mensaje: {$mail->ErrorInfo}\n";
        ##return false;
        return $resultadoEnvio;
    }
}


#############################################
#############################################


	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['numero_pago']) || 
	empty($_POST['fecha_pago'])
	) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");


$ID=intval($_POST['idprincipal']);
##$pagina=intval($_POST['pagina']);
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];

$fecha_pago=$_POST['fecha_pago'];
$numero_pago=$_POST['numero_pago'];
$monto=$_POST['monto'];

$id_proceso_tramites=$_POST['id_proceso_tramites'];
$folio=$_POST['folio'];

$id_tramite=$_POST['id_tramite'];


##
## Presupuesto

##

$sql20="UPDATE pagos SET estatus_pago='PAGADO', numero_pago='$numero_pago', monto='$monto', fecha_pago='$fecha_pago' WHERE id_principal=".$ID." AND id_proceso_tramites=0 AND concepto='Revalidacion'";
$query_Update20 = mysqli_query($con,$sql20);

##
$Kuery_Update0="UPDATE revalidacion SET  ultima_fecha_pago_expiracion='$today' WHERE estatus='En Proceso' AND id_principal=".$ID;
mysqli_query($con,$Kuery_Update0);
##
################
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$nip=substr(str_shuffle($permitted_chars),0,6);
################
$Kuery_Update_principal="UPDATE principal SET  ultima_fecha_pago_expiracion='$today', estatus='Pago Revalidacion', nip='$nip'  WHERE id=".$ID;
$query_Update = mysqli_query($con,$Kuery_Update_principal);
##
$sqlPrincipal="SELECT * FROM principal WHERE id=".$ID;
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$folio=$row['folio'];
$id_giro=$row['giro'];
$nombre_comercial_establecimiento=$row['nombre_comercial_establecimiento'];
$numero_permiso=$row['numero_permiso'];
##$nip=$row['nip'];

$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
#####################

$mensajeEmail="<span style='background:yellow;color:black;font-family:ITC Avant Garde Std, Arial, Helvetica, sans-serif;font-weight: normal;font-size: 12px;'>Se esta Revalidando el Permiso Número $numero_permiso ( $nombre_comercial_establecimiento ) Folio ( $folio ) Giro ( $GIRO ).</span> <i><u>Para imprimir el Permiso debes de usar el siguiente</i></u> <b>NIP: $nip </b>";



if ($query_Update) {

##$email_recipient1="mchangmx@yahoo.com";
##$email_recipient2="lanaranjamecanica.mx@gmail.com";
##$email_recipient2="lic.georginabarraza@gmail.com";

$email_recipient1=$conf['email_recipient1'];
$email_recipient2=$conf['email_recipient2'];

##################################
$smtp_username=$conf['smtp_username'];
$smtp_password=$conf['smtp_password'];
$email_sender=$conf['email_sender'];
$smtp_host=$conf['smtp_host'];
$smtp_port=$conf['smtp_port'];
$enable_verbose=$conf['enable_verbose'];
#################
$resultadoEnvio=enviarCorreo(
    $smtp_username,
    $smtp_password,
    $email_sender,
    $email_recipient1,
    $email_recipient2,
    $smtp_host,
    $smtp_port,
    $enable_verbose,
    $mensajeEmail
);

$messages[] = "Se Registro el Pago  con Exito -  Folio ($folio) - Se envio Correo $resultadoEnvio ";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
	##} else {
	##		$errors []= "Error desconocido.";
	}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>

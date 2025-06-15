<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
$ID_USER=$_SESSION['user_id'];





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
$todayANO = date("Y");

$fecha_expiracion = strtotime ('+60 days' , strtotime($today));
$fecha_expiracion = date ('Y-m-d',$fecha_expiracion);


$ID=intval($_POST['idprincipal']);
##$pagina=intval($_POST['pagina']);
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];

$fecha_pago=$_POST['fecha_pago'];
$numero_pago=$_POST['numero_pago'];
$monto=$_POST['monto'];

$tramite_pago=$_POST['tramite_pago'];
//$tramite_pagoid=$_POST['tramite_pagoid'];
$folio=$_POST['folio'];

//$id_pago_rad=$_POST['id_pago_rad'];
//$id_pago_ins=$_POST['id_pago_ins'];


$concepto_tramite=$_POST['concepto_tramite'];
$concepto_giro=$_POST['concepto_giro'];
$concepto_modalidad=$_POST['concepto_modalidad'];
$concepto_servicios_adicionales=$_POST['concepto_servicios_adicionales'];
$total_umas_pagar=$_POST['total_umas_pagar'];
$id_tramite_procesos=$_POST['id_tramite_procesos'];

$id_tramite=$_POST['id_tramite'];
$id_proceso_tramites=$_POST['id_proceso_tramites'];


$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$NIPgenerado=substr(str_shuffle($permitted_chars),0,6);


$CONCEPTO_PAGO="Permiso Temporal [[ ".$concepto_tramite." ]]   Giro [[ ".$concepto_giro." ]] Modalidad  [[ ".$concepto_modalidad." ]]  Servicios Adicionales [[ ".$concepto_servicios_adicionales."]] Total UMAS ".$total_umas_pagar;

##
## Presupuesto

##
$todayANO = date("Y");
####################
$ORDEN_PAGO='PXT-'.$id.$id_proceso_tramites.'-'.$todayANO;
$CONCEPTO_RECAUDACION='Permiso Temporal;'.$total_umas_pagar;
##################

$sqlINSERT="INSERT INTO  pagos_temp (
id_principal,
id_proceso_tramites,
total_umas_pagar,
numero_pago, 
monto, 
concepto_pago, 
fecha_pago, 
estatus_pago,
concepto,
folio,
concepto_recaudacion,
orden_pago,
fechaRegistro ) VALUES (
$ID,
$id_proceso_tramites,
'$total_umas_pagar', 
'$numero_pago',
'$monto', 
'$CONCEPTO_PAGO', 
'$today',
'PAGADO',
'$tramite_pago',
'$folio',
'$ORDEN_PAGO',
'$CONCEPTO_RECAUDACION',
'$today')";
######################
############
############
## Numero de Permiso

$id_principal=$ID;

$sqlPrincipal="SELECT * FROM principal_temp WHERE id=".$id_principal;
$row=mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));

$id_giroNP=$row['giro'];
$id_delegacionNP=$row['id_delegacion'];
#################
$arregloSiglasGiro=mysqli_fetch_array(mysqli_query($con,"SELECT  siglas  FROM giro WHERE id=$id_giroNP"));
$SIGLAS_GIRO=$arregloSiglasGiro[0];
##echo 'SIGLAS_GIRO='.$SIGLAS_GIRO.'<br>';
##
$arregloSiglasDelegacion=mysqli_fetch_array(mysqli_query($con,"SELECT  siglas  FROM delegacion WHERE id=$id_delegacionNP"));
$SIGLAS_DELEGACION=$arregloSiglasDelegacion[0];
##echo 'SIGLAS_DELEGACION='.$SIGLAS_DELEGACION.'<br>';
################
$id_giro_siglas=$id_giroNP.'-'.$SIGLAS_GIRO;
$id_delegacion_siglas=$id_delegacionNP.'-'.$SIGLAS_DELEGACION;
################
################
##echo "SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folio' AND id_delegacion_siglas='$id_delegacion_siglas' AND id_giro_siglas='$id_giro_siglas' <br>";
##$arregloCuenta=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folio' AND id_delegacion_siglas='$id_delegacion_siglas' AND id_giro_siglas='$id_giro_siglas'"));
$arregloCuenta=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `numero_permiso_temporal` WHERE folio='$folio' AND id_giro_siglas='$id_giro_siglas'"));
$CUENTA=$arregloCuenta[0];
###############
##########
if ( $CUENTA>0 ) {
##echo 'El Folio ya cuenta con un Numero de permiso<br>';
} else {

################
$NP='';
##$siglas='E-'.$SIGLAS_GIRO.$SIGLAS_DELEGACION;
$siglas='T-'.$SIGLAS_GIRO;
###############
$sql_INSERT99="INSERT INTO numero_permiso_temporal (
folio,
id_principal,
user_id,
id_giro_siglas,
fecha ) VALUES (
'$folio',
$id_principal,
$ID_USER,
'$id_giro_siglas',
'$today')";

$query_new_insert99 = mysqli_query($con,$sql_INSERT99);
if ($query_new_insert99) {
$arregloMaxid99 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `numero_permiso_temporal`"));
$IDNP=intval($arregloMaxid99[0]);

$tamano=strlen($IDNP);

##echo 'Tamano='.$tamano.'<br>';

switch ($tamano) {
    case 1:
        $NP=$siglas.'00000'.$IDNP;
        break;
    case 2:
        $NP=$siglas.'0000'.$IDNP;
            break;
    case 3:
        $NP=$siglas.'000'.$IDNP;
            break;
    case 4:
        $NP=$siglas.'00'.$IDNP;
            break;
    case 5:
        $NP=$siglas.'0'.$IDNP;
            break;
    case 6:
        $NP=$siglas.''.$IDNP;
            break;
}

$Kuery_Update99="UPDATE numero_permiso_temporal SET numero_permiso='$NP'  WHERE id=".$IDNP;
mysqli_query($con,$Kuery_Update99);

}
}

############
######################
$Kuery_Update_principal="UPDATE principal_temp SET operacion='Activo', estatus='Permiso Temporal Autorizado', fecha_expiracion='$fecha_expiracion',  fecha_autorizacion='$today', nip='$NIPgenerado', numero_permiso='$NP'  WHERE id=".$ID;

$Kuery_Update2="UPDATE proceso_tramites_temp SET fecha_fin='$today', numero_permiso='$NP', nota='$GIRO',  en_proceso='Fin' WHERE id_principal=".$ID;

mysqli_query($con,$sqlINSERT);
$query_Update = mysqli_query($con,$Kuery_Update_principal);
mysqli_query($con,$Kuery_Update2);

##
###########################################
####  SE REVISAN SI YA PAGARON LAS 2 TAREAS Recepcion y Analisis Documentos e Inspeccion
##$PAGO_RAD=0;
##$PAGO_INS=0;
###
##$sql_pagoRAD="SELECT * FROM `pagos` WHERE `id_principal`=$ID AND `concepto`='Recepcion y Analisis Documentos' AND estatus_pago='PAGADO' AND id_proceso_tramites=1";
##$result_pagoRAD = mysqli_query($con,$sql_pagoRAD);
##if (mysqli_num_rows($result_pagoRAD) > 0) {
##$PAGO_RAD='PAGADO';
##} else {
##$PAGO_RAD=0;
##}
##
##$sql_pagoI="SELECT * FROM `pagos` WHERE `id_principal`=$ID AND `concepto`='Inspeccion' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=1";
##$result_pagoI = mysqli_query($con,$sql_pagoI);
##if (mysqli_num_rows($result_pagoI) > 0) {
##$PAGO_INS='PAGADO';
##} else {
##$PAGO_INS=0;
##}
###

##if ( $PAGO_RAD=='PAGADO' && $PAGO_INS=='PAGADO' ) {
##$Kuery_Update2_principal="UPDATE principal SET estatus='Pagos IRAD' WHERE id=".$ID;
##mysqli_query($con,$Kuery_Update2_principal);
####
##$Kuery_Update3_RAD="UPDATE recepcion_analisis_documentos SET fecha_inicio='$today', en_proceso='En Proceso' WHERE id_principal=".$ID;
##mysqli_query($con,$Kuery_Update3_RAD);
##$Kuery_Update3_INS="UPDATE inspeccion SET fecha_inicio='$today', en_proceso='En Proceso' WHERE id_principal=".$ID;
##mysqli_query($con,$Kuery_Update3_INS);
##} else {
##}
###

mysqli_close($con);

$mensajeEmail="<span style='background:pink;color:black;font-family:Lucida Console, Courier New;font-weight: normal;font-size: 12px;'>PERMISO TEMPORAL el Número $NP ( $nombre_comercial_establecimiento ) Folio ( $folio ) Giro ( $GIRO ).</span> <i><u>Para imprimir el Permiso debes de usar el siguiente</i></u> <b>NIP: $NIPgenerado </b>";

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





	$messages[] = "Se Registro el Pago con Exito y Autorizo  Folio ($folio)  - Se envio Correo $resultadoEnvio";
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

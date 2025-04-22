<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre_representante_legal_solicitante']) || 
	empty($_POST['nombre_comercial_establecimiento']) || 
	empty($_POST['MODALIDAD_GA']) || 
	empty($_POST['clave_catastral'])
	) {

	if ( empty($_POST['MODALIDAD_GA']) ) $errors[] = "Campo vacío -- Modalidad Graduación Alcohólica";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

#####################
$MODALIDAD_GA=$_POST['MODALIDAD_GA'];
#####################
$monto_umas_total_modalidad_graduacion_alcoholica=0;
$MODALIDAD_GA_LISTA='';
$cuentaMGA=count($MODALIDAD_GA);

if ( $cuentaMGA==1 ) {
#########
$MODALIDAD_GA_RAW=$MODALIDAD_GA[0];
#
$porciones0 = explode("**", $MODALIDAD_GA[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
$monto_umas_total_modalidad_graduacion_alcoholica=$e02;
$MODALIDAD_GA_LISTA='('.$e01.')';
#
#########
} else {

if ( $cuentaMGA==2 ) {
#################
$MODALIDAD_GA_RAW=$MODALIDAD_GA[0].'--'.$MODALIDAD_GA[1];
#
$porciones0 = explode("**", $MODALIDAD_GA[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
#
$porciones1 = explode("**", $MODALIDAD_GA[1]);
$e10=$porciones1[0];
$e11=$porciones1[1];
$e12=$porciones1[2];
$monto_umas_total_modalidad_graduacion_alcoholica=$e02+$e12;
$MODALIDAD_GA_LISTA='('.$e01.') y ('.$e11.')';
#
#################
} else {

$MODALIDAD_GA_RAW=$MODALIDAD_GA[0];
#
$porciones0 = explode("**", $MODALIDAD_GA[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
$monto_umas_total_modalidad_graduacion_alcoholica=$e02;
$MODALIDAD_GA_LISTA='('.$e01.')';
#



for($i = 1; $i<$cuentaMGA-1; $i++) {

$MODALIDAD_GA_RAW .= '--'.$MODALIDAD_GA[$i];

$porcionesi = explode("**", $MODALIDAD_GA[$i]);
$ei0=$porcionesi[0];
$ei1=$porcionesi[1];
$ei2=$porcionesi[2];
$monto_umas_total_modalidad_graduacion_alcoholica=$ei2+$monto_umas_total_modalidad_graduacion_alcoholica;
#

$MODALIDAD_GA_LISTA.=', ('.$ei1.')';
}


$MODALIDAD_GA_RAW .= ' --'.$MODALIDAD_GA[$cuentaMGA-1];
$porcionesu = explode("**", $MODALIDAD_GA[$cuentaMGA-1]);
$eu0=$porcionesu[0];
$eu1=$porcionesu[1];
$eu2=$porcionesu[2];
$monto_umas_total_modalidad_graduacion_alcoholica=$eu2+$monto_umas_total_modalidad_graduacion_alcoholica;

$MODALIDAD_GA_LISTA .= ' Y ('.$eu1.')';
}
}

#####################
#####################
#####################

$monto_umas_total_servicios_adicionales=0;
if (isset($_POST['SERVICIOS_ADICIONALES']) && !empty($_POST['SERVICIOS_ADICIONALES'])) {
$SERVICIOS_ADICIONALES=$_POST['SERVICIOS_ADICIONALES'];

$SERVICIOS_ADICIONALES_LISTA='0';
$SERVICIOS_ADICIONALES_RAW='';
$cuentaSA=count($SERVICIOS_ADICIONALES);


if ( $cuentaSA==1 ) {
$SERVICIOS_ADICIONALES_RAW=$SERVICIOS_ADICIONALES[0];
#
$porciones0 = explode("**", $SERVICIOS_ADICIONALES[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
$monto_umas_total_servicios_adicionales=$e02;
$SERVICIOS_ADICIONALES_LISTA='('.$e01.')';
#
} else {

if ( $cuentaSA==2 ) {
$SERVICIOS_ADICIONALES_RAW=$SERVICIOS_ADICIONALES[0].'--'.$SERVICIOS_ADICIONALES[1];
#
$porciones0 = explode("**", $SERVICIOS_ADICIONALES[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
#
$porciones1 = explode("**", $SERVICIOS_ADICIONALES[1]);
$e10=$porciones1[0];
$e11=$porciones1[1];
$e12=$porciones1[2];
$monto_umas_total_servicios_adicionales=$e02+$e12;
$SERVICIOS_ADICIONALES_LISTA='('.$e01.') y ('.$e11.')';
#
} else {

$SERVICIOS_ADICIONALES_RAW=$SERVICIOS_ADICIONALES[0];
#
$porciones0 = explode("**", $SERVICIOS_ADICIONALES[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
$monto_umas_total_servicios_adicionales=$e02;
$SERVICIOS_ADICIONALES_LISTA='('.$e01.')';
#

for($i = 1; $i<$cuentaSA-1; $i++) {
$SERVICIOS_ADICIONALES_RAW .= '--'.$SERVICIOS_ADICIONALES[$i];

$porcionesi = explode("**", $SERVICIOS_ADICIONALES[$i]);
$ei0=$porcionesi[0];
$ei1=$porcionesi[1];
$ei2=$porcionesi[2];
$monto_umas_total_servicios_adicionales=$ei2+$monto_umas_total_servicios_adicionales;
#

$SERVICIOS_ADICIONALES_LISTA.=', ('.$ei1.')';

}

$SERVICIOS_ADICIONALES_RAW .= ' --'.$SERVICIOS_ADICIONALES[$cuentaSA-1];
$porcionesu = explode("**", $SERVICIOS_ADICIONALES[$cuentaSA-1]);
$eu0=$porcionesu[0];
$eu1=$porcionesu[1];
$eu2=$porcionesu[2];
$monto_umas_total_servicios_adicionales=$eu2+$monto_umas_total_servicios_adicionales;

$SERVICIOS_ADICIONALES_LISTA .= ' Y ('.$eu1.')';
}
}



} else {
$SERVICIOS_ADICIONALES_LISTA='0';
$cuentaSA=0;
$monto_umas_total_servicios_adicionales=0;
}
#####################
		$id_giro=$_POST['id_giro'];
		$id_delegacion=$_POST['id_delegacion'];
		$id_colonia=$_POST['id_colonia'];

$rfc_solicitante=$_POST['rfc_solicitante'];
$fisica_o_moral=$_POST['fisica_o_moral'];

$capacidad_comensales_personas=$_POST['capacidad_comensales_personas'];
$superficie_establecimiento=$_POST['superficie_establecimiento'];

		// escaping, additionally removing everything that could be (html/javascript-) code
		$observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)));
		$fecha_alta=$_POST['fecha_alta'];
		$fecha_datetime_hoy=date("Y-m-d H:i:s");
		$clave_catastral=strtoupper($_POST['clave_catastral']);


$nombre_comercial_establecimiento=strtoupper($_POST['nombre_comercial_establecimiento']);
$calle_establecimiento=strtoupper($_POST['calle_establecimiento']);
$entre_calles_establecimiento=strtoupper($_POST['entre_calles_establecimiento']);
$numero_establecimiento=$_POST['numero_establecimiento'];
$numerointerno_local_establecimiento=$_POST['numerointerno_local_establecimiento'];
$cp_establecimiento=$_POST['cp_establecimiento'];

$nombre_persona_fisicamoral_solicitante=strtoupper($_POST['nombre_persona_fisicamoral_solicitante']);
$nombre_representante_legal_solicitante=strtoupper($_POST['nombre_representante_legal_solicitante']);
$domicilio_solicitante=strtoupper($_POST['domicilio_solicitante']);
$email_solicitante=$_POST['email_solicitante'];
$telefono_solicitante=$_POST['telefono_solicitante'];
#################################
##
$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$ID_MUNICIPIO;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$id_delegacion;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$row_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACION=$row_delegacion['delegacion'];
##
$sql_colonia="SELECT colonia FROM colonias WHERE id=".$id_colonia;
$result_colonia = mysqli_query($con,$sql_colonia);
$row_colonia = mysqli_fetch_assoc($result_colonia);
$COLONIA=$row_colonia['colonia'];
##
#################################

$el_cambio="Permiso Nuevo Fecha Alta (".$fecha_alta.") Giro (".$GIRO.") -  Establecimiento [[ ".$nombre_comercial_establecimiento.", Clave Catastral (".$clave_catastral."), ".$calle_establecimiento.", ".$entre_calles_establecimiento.", ".$numero_establecimiento.", ".$numerointerno_local_establecimiento.", ".$cp_establecimiento.", ".$DELEGACION." ".$COLONIA.", ".$MUNICIPIO.",  capacidad_comensales_personas (".$capacidad_comensales_personas.") superficie_establecimiento(".$superficie_establecimiento.")  ]], Solicitante [[".$fisica_o_moral.", ".$nombre_persona_fisicamoral_solicitante.", ".$nombre_representante_legal_solicitante.", ".$domicilio_solicitante.", ".$rfc_solicitante.", ".$email_solicitante.", ".$telefono_solicitante."]]  Modalidad [[".$MODALIDAD_GA_LISTA."]] Servicios Adicionales [[".$SERVICIOS_ADICIONALES_LISTA."]]   ";

	
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
################
################
###  TRAMITE NUEVO
$arregloTramite=mysqli_fetch_array(mysqli_query($con,"SELECT *  FROM `tramite` WHERE descripcion_tramite='Permiso Nuevo'"));
$ID_TRAMITE=$arregloTramite[0];
###############
###############
###
##########
$sql_principal="INSERT INTO principal (
giro,
modalidad_graduacion_alcoholica,
modalidad_graduacion_alcoholica_raw,
numero_modalidad_graduacion_alcoholica,
monto_umas_total_modalidad_graduacion_alcoholica,
servicios_adicionales,
servicios_adicionales_raw,
numero_servicios_adicionales,
monto_umas_total_servicios_adicionales,
id_municipio,
id_delegacion,
id_colonia,
estatus,
operacion,
clave_catastral,
nombre_comercial_establecimiento,
calle_establecimiento,
entre_calles_establecimiento,
numero_establecimiento,
numerointerno_local_establecimiento,
cp_establecimiento,
nombre_persona_fisicamoral_solicitante,
nombre_representante_legal_solicitante,
domicilio_solicitante,
email_solicitante,
telefono_solicitante,
fecha_alta,
capacidad_comensales_personas,
superficie_establecimiento,
rfc,
fisica_o_moral,
observaciones,
fecha_hora_registro
) VALUES (
$id_giro, 
'$MODALIDAD_GA_LISTA',
'$MODALIDAD_GA_RAW',
$cuentaMGA,
$monto_umas_total_modalidad_graduacion_alcoholica,
'$SERVICIOS_ADICIONALES_LISTA',
'$SERVICIOS_ADICIONALES_RAW',
$cuentaSA,
$monto_umas_total_servicios_adicionales,
$ID_MUNICIPIO,
$id_delegacion,
$id_colonia,
'Generar Recibos IRAD',
'NUEVO',
'$clave_catastral',
'$nombre_comercial_establecimiento',
'$calle_establecimiento',
'$entre_calles_establecimiento',
'$numero_establecimiento',
'$numerointerno_local_establecimiento',
'$cp_establecimiento',
'$nombre_persona_fisicamoral_solicitante',
'$nombre_representante_legal_solicitante',
'$domicilio_solicitante',
'$email_solicitante',
'$telefono_solicitante',
'$fecha_alta',
$capacidad_comensales_personas,
$superficie_establecimiento,
'$rfc_solicitante',
'$fisica_o_moral',
'$observaciones',
'$fecha_datetime_hoy'
)";

$query_new_insert = mysqli_query($con,$sql_principal);


if ($query_new_insert) {



$arregloMaxid = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `principal`"));
$ID=intval($arregloMaxid[0]);
$folio=$ID_MUNICIPIO."-".$ID;
############
############
$sqlInsert="INSERT INTO proceso_tramites (
id_principal,
id_tramite,
fecha_inicio,
fechaRegistro,
el_cambio,
en_proceso) VALUES (
$ID,
$ID_TRAMITE,
'$fecha_alta',
'$today',
'$el_cambio',
'EN PROCESO')";
mysqli_query($con,$sqlInsert);

##
$arregloMaxid2 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `proceso_tramites`"));
$ID_PROCESO_TRAMITE=$arregloMaxid2[0];
#######################
#### con el id_tramite y el id_proceso_tramites ES EL ULTIMO TRAMITE REALIZADO y CONSULTAR LOS PDFs
$Kuery_Update="UPDATE principal SET folio='$folio', id_tramite=$ID_TRAMITE , id_proceso_tramites=$ID_PROCESO_TRAMITE  WHERE id=".$ID;
mysqli_query($con,$Kuery_Update);
########################
##
$sql_tramite0="SELECT * FROM tramite WHERE descripcion_tramite='Inspeccion'";
$result_tramite0 = mysqli_query($con,$sql_tramite0);
$row_tramite0 = mysqli_fetch_assoc($result_tramite0);
$MONTO_UMAS_tramiteINS=$row_tramite0['monto_umas'];
##
$sql_tramite00="SELECT * FROM tramite WHERE descripcion_tramite='Recepcion y Analisis Documentos'";
$result_tramite00 = mysqli_query($con,$sql_tramite00);
$row_tramite00 = mysqli_fetch_assoc($result_tramite00);
$MONTO_UMAS_tramiteRAD=$row_tramite00['monto_umas'];
##
########################
$sql10="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
estatus_pago,
total_umas_pagar,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Inspeccion',
'Pendiente',
'$MONTO_UMAS_tramiteINS',
'$today')";
$query_new_insert1 = mysqli_query($con,$sql10);
##
$sql20="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
estatus_pago,
total_umas_pagar,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Recepcion y Analisis Documentos',
'Pendiente',
'$MONTO_UMAS_tramiteRAD',
'$today')";
$query_new_insert2 = mysqli_query($con,$sql20);
##

$sql30="INSERT INTO inspeccion (
id_principal,
folio,
id_proceso_tramites,
fechaRegistro,
en_proceso) VALUES (
$ID, 
'$folio', 
$ID_PROCESO_TRAMITE, 
'$today',
'Espera Pago')";
$query_new_insert3 = mysqli_query($con,$sql30);
##
$sql40="INSERT INTO recepcion_analisis_documentos (
id_principal,
folio,
id_proceso_tramites,
fechaRegistro,
en_proceso) VALUES (
$ID, 
'$folio', 
$ID_PROCESO_TRAMITE, 
'$today',
'Espera Pago')";
$query_new_insert4 = mysqli_query($con,$sql40);
##





				$messages[] = "El Registro ha sido dado  de Alta Exito Folio ($ID_MUNICIPIO - $ID ).";
			} else {
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
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

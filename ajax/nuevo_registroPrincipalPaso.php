<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
$ID_USER=$_SESSION['user_id'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre_representante_legal_solicitante']) || 
	empty($_POST['nombre_comercial_establecimiento']) || 
	empty($_POST['MODALIDAD_GA']) || 
        empty($_POST['numero_mesas_de_billar']) || 
        empty($_POST['pista_de_baile']) || 
        empty($_POST['musica_grabada_y_aparatos']) || 
        empty($_POST['conjunto_musicales']) || 
        empty($_POST['espectaculos_artisticos']) || 
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
###########################
## SERVICIOS ADICIONALES
###########################
$SERVICIOS_ADICIONALES_LISTA='';
$cuentaSA=0;
$monto_umas_total_servicios_adicionales=0;
#
###############
$numero_mesas_de_billar=$_POST['numero_mesas_de_billar'];
$pista_de_baile=$_POST['pista_de_baile'];
$musica_grabada_y_aparatos=$_POST['musica_grabada_y_aparatos'];
$conjunto_musicales=$_POST['conjunto_musicales'];
$espectaculos_artisticos=$_POST['espectaculos_artisticos'];
###############
if ( $numero_mesas_de_billar=='Zero' && $pista_de_baile=='Zero' && $musica_grabada_y_aparatos=='Zero' && $conjunto_musicales=='Zero' && $espectaculos_artisticos=='Zero' ) {
$SERVICIOS_ADICIONALES_LISTA='0';
$cuentaSA=0;
$monto_umas_total_servicios_adicionales=0;
} else {
	if ( $numero_mesas_de_billar!='Zero' ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( '.$numero_mesas_de_billar.' Mesa(s) de Billar ) ';
	$cuentaSA++;
	} else $numero_mesas_de_billar=0;
	#
	if ( $pista_de_baile==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Pista de Baile ) ';
	$cuentaSA++;
	} else $pista_de_baile=0;
	#
	if ( $musica_grabada_y_aparatos==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Musica Grabada y Aparatos Musicales ) ';
	$cuentaSA++;
	} else $musica_grabada_y_aparatos=0;
	#
	if ( $conjunto_musicales==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Conjunto Musicales ) ';
	$cuentaSA++;
	} else $conjunto_musicales=0;
	#
	if ( $espectaculos_artisticos==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Espectaculos Artisticos ) ';
	$cuentaSA++;
	} else $espectaculos_artisticos=0;
#
$arregloSA_musica_grabada_y_aparatos=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Musica Grabada y Aparatos Musicales'"));
$umas_musica_grabada_y_aparatos=$arregloSA_musica_grabada_y_aparatos[0];
$monto_musica_grabada_y_aparatos=$umas_musica_grabada_y_aparatos*$musica_grabada_y_aparatos;
#
$arregloSA_numero_mesas_de_billar=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Mesas de Billar, por cada Mesa'"));
$umas_numero_mesas_de_billar=$arregloSA_numero_mesas_de_billar[0];
$monto_numero_mesas_de_billar=$umas_numero_mesas_de_billar*$numero_mesas_de_billar;
#
$arregloSA_pista_de_baile=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Pista de Baile'"));
$umas_pista_de_baile=$arregloSA_pista_de_baile[0];
$monto_pista_de_baile=$umas_pista_de_baile*$pista_de_baile;
#
$arregloSA_conjunto_musicales=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Conjunto Musicales'"));
$umas_conjunto_musicales=$arregloSA_conjunto_musicales[0];
$monto_conjunto_musicales=$umas_conjunto_musicales*$conjunto_musicales;
#
$arregloSA_espectaculos_artisticos=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Espectaculos Artisticos'"));
$umas_espectaculos_artisticos=$arregloSA_espectaculos_artisticos[0];
$monto_espectaculos_artisticos=$umas_espectaculos_artisticos*$espectaculos_artisticos;
##
$monto_umas_total_servicios_adicionales=$monto_musica_grabada_y_aparatos+$monto_numero_mesas_de_billar+$monto_pista_de_baile+$monto_conjunto_musicales+$monto_espectaculos_artisticos;
}
#
###########################
###########################
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

		$numero_permiso=strtoupper($_POST['numero_permiso']);
		$numero_cuenta=$_POST['numero_cuenta'];

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

$nota="Registro PASO - Numero de Permiso (".$numero_permiso.")  (".$fecha_alta.") Giro (".$GIRO.") -  Establecimiento [[ ".$nombre_comercial_establecimiento.", Clave Catastral (".$clave_catastral."), Numero Cuenta (".$numero_cuenta."), ".$calle_establecimiento.", ".$entre_calles_establecimiento.", ".$numero_establecimiento.", ".$numerointerno_local_establecimiento.", ".$cp_establecimiento.", Delegación: ".$DELEGACION.", Colonia: ".$COLONIA.", Municipio: ".$MUNICIPIO.",  capacidad_comensales_personas (".$capacidad_comensales_personas.") superficie_establecimiento(".$superficie_establecimiento.")  ]], Solicitante [[".$fisica_o_moral.", ".$nombre_persona_fisicamoral_solicitante.", ".$nombre_representante_legal_solicitante.", ".$domicilio_solicitante.", ".$rfc_solicitante.", ".$email_solicitante.", ".$telefono_solicitante."]]  Modalidad [[".$MODALIDAD_GA_LISTA."]] Servicios Adicionales [[".$SERVICIOS_ADICIONALES_LISTA."]]   ";

	
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
$todayANO = date("Y");
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
numero_servicios_adicionales,
monto_umas_total_servicios_adicionales,
id_municipio,
id_delegacion,
id_colonia,
estatus,
operacion,
clave_catastral,
numero_cuenta,
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
$cuentaSA,
'$monto_umas_total_servicios_adicionales',
$ID_MUNICIPIO,
$id_delegacion,
$id_colonia,
'Paso',
'Activo',
'$clave_catastral',
'$numero_cuenta',
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

###
$arregloMaxid = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `principal`"));
$ID=intval($arregloMaxid[0]);
$folio=$ID_MUNICIPIO."-".$ID;
###
##############################################
###  OBTENER NUMERO DE PERMISO  bebal
##############################################
$id_principal=$ID;
$id_giroNP=$id_giro;
$id_delegacionNP=$id_delegacion;
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
$arregloCuenta=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folio' AND id_giro_siglas='$id_giro_siglas'"));
$CUENTA=$arregloCuenta[0];
###############
##########
if ( $CUENTA>0 ) {
##echo 'El Folio ya cuenta con un Numero de permiso<br>';
$arregloNP=mysqli_fetch_array(mysqli_query($con,"SELECT  numero_permiso  FROM `numero_permiso` WHERE folio='$folio' AND id_giro_siglas='$id_giro_siglas'"));
$NP=$arregloNP[0];
} else {

################
$NP='';
##$siglas='E-'.$SIGLAS_GIRO.$SIGLAS_DELEGACION;
$siglas='E-'.$SIGLAS_GIRO;
###############
$sql_INSERT99="INSERT INTO numero_permiso (
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
$arregloMaxid99 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `numero_permiso`"));
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

$Kuery_Update99="UPDATE numero_permiso SET numero_permiso='$NP'  WHERE id=".$IDNP;
mysqli_query($con,$Kuery_Update99);

}

############
######################
$arregloGIRO=mysqli_fetch_array(mysqli_query($con,"SELECT  *  FROM giro WHERE id=$id_giroNP"));
$MES_VENCIMIENTO=$arregloGIRO[7];
$GIRO=$arregloGIRO[1];
##
$MASunANO = strtotime ('+1 year' , strtotime($todayANO));
$MASunANO = date ('Y',$MASunANO);
$FECHA_EXPIRACION=$MASunANO.'-'.$MES_VENCIMIENTO.'-01';
##

##############################################
##############################################
$sql_de_paso="INSERT INTO de_paso (
folio,
id_principal,
nombre_persona_fisicamoral_solicitante,
nombre_representante_legal_solicitante,
rfc,
fisica_o_moral,
domicilio_solicitante,
numero_permiso,
numero_permiso_nuevo,
nombre_comercial_establecimiento,
calle_establecimiento,
entre_calles_establecimiento,
numero_establecimiento,
numerointerno_local_establecimiento,
cp_establecimiento,
telefono_solicitante,
email_solicitante,
clave_catastral,
superficie_establecimiento,
giro,
modalidad_graduacion_alcoholica,
modalidad_graduacion_alcoholica_raw,
numero_modalidad_graduacion_alcoholica,
monto_umas_total_modalidad_graduacion_alcoholica,
fecha_alta,
id_municipio,
id_delegacion,
id_colonia,
fecha,
nota ) VALUES (
'$folio',
$ID,
'$nombre_persona_fisicamoral_solicitante',
'$nombre_representante_legal_solicitante',
'$rfc_solicitante',
'$fisica_o_moral',
'$domicilio_solicitante',
'$numero_permiso',
'$NP',
'$nombre_comercial_establecimiento',
'$calle_establecimiento',
'$entre_calles_establecimiento',
'$numero_establecimiento',
'$numerointerno_local_establecimiento',
'$cp_establecimiento',
'$telefono_solicitante',
'$email_solicitante',
'$clave_catastral',
$superficie_establecimiento,
$id_giro,
'$MODALIDAD_GA_LISTA',
'$MODALIDAD_GA_RAW',
$cuentaMGA,
$monto_umas_total_modalidad_graduacion_alcoholica,
'$fecha_alta',
$ID_MUNICIPIO,
$id_delegacion,
$id_colonia,
'$today',
'$nota')";

mysqli_query($con,$sql_de_paso);

if ($query_new_insert) {

##########################
### SERVICIOS ADICIONALES

if ( $SERVICIOS_ADICIONALES_LISTA=='0' ) {
$Kuery_SAP="INSERT INTO servicios_adicionales_permisionario (
id_principal,
id_proceso_tramites,
folio,
musica_grabada_y_aparatos,
monto_musica_grabada_y_aparatos,
conjunto_musicales,
monto_conjunto_musicales,
mesas_de_billar,
monto_mesas_de_billar,
espectaculos_artisticos,
monto_espectaculos_artisticos,
pista_de_baile,
monto_pista_de_baile,
fecha
) VALUES (
$ID,
0,
'$folio',
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
'$today')";

} else {

$Kuery_SAP="INSERT INTO servicios_adicionales_permisionario (
id_principal,
id_proceso_tramites,
folio,
musica_grabada_y_aparatos,
monto_musica_grabada_y_aparatos,
conjunto_musicales,
monto_conjunto_musicales,
mesas_de_billar,
monto_mesas_de_billar,
espectaculos_artisticos,
monto_espectaculos_artisticos,
pista_de_baile,
monto_pista_de_baile,
fecha
) VALUES (
$ID,
0,
'$folio',
$musica_grabada_y_aparatos,
$monto_musica_grabada_y_aparatos,
$conjunto_musicales,
$monto_conjunto_musicales,
$numero_mesas_de_billar,
$monto_numero_mesas_de_billar,
$espectaculos_artisticos,
$monto_espectaculos_artisticos,
$pista_de_baile,
$monto_pista_de_baile,
'$today')";
}

mysqli_query($con,$Kuery_SAP);
####
$arregloMaxid3 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `servicios_adicionales_permisionario`"));
$ID_SERVICIOS_ADICIONALES_PERMISIONARIO=$arregloMaxid3[0];
########################
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$NIPgenerado=substr(str_shuffle($permitted_chars),0,6);
#######################
#### con el id_tramite y el id_proceso_tramites ES EL ULTIMO TRAMITE REALIZADO y CONSULTAR LOS PDFs
$Kuery_Update="UPDATE principal SET folio='$folio', numero_permiso='$NP', id_servicios_adicionales_permisionario=".$ID_SERVICIOS_ADICIONALES_PERMISIONARIO.", id_tramite=0 , id_proceso_tramites=0 , fecha_expiracion='$FECHA_EXPIRACION',  fecha_autorizacion='$today', nip='$NIPgenerado' WHERE id=".$ID;
mysqli_query($con,$Kuery_Update);
##########################
########################
########################
##


				$messages[] = "El  Registro -- DE PASO -- ha sido dado  de Alta Exito Folio ($ID_MUNICIPIO - $ID ).";
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

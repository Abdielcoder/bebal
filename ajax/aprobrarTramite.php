<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
	$ID_USER=$_SESSION['user_id'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['IDPRINCIPAL']) || 
	empty($_POST['IDPRINCIPAL'])
	) {

	if ( empty($_POST['monto_umas_tramite_solicitado']) ) $errors[] = "Campo vacío -- monto_umas_tramite_solicitado";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

################
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
$todayANO = date("Y");
$fecha_datetime_hoy=date("Y-m-d H:i:s");
################

$monto_umas_tramite_solicitado=$_POST['monto_umas_tramite_solicitado'];
$page=$_POST['page'];
$ID=$_POST['IDPRINCIPAL'];
$folio=$_POST['folio'];
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];
$ID_TRAMITE=$_POST['id_tramite_solicitado'];
$cambio_de_giro=$_POST['cambio_de_giro'];
$cambio_id_giro_solicitado=$_POST['cambio_id_giro_solicitado'];
$cambio_giro_solicitado=$_POST['cambio_giro_solicitado'];
$descripcion_tramite_solicitado=$_POST['descripcion_tramite_solicitado'];
$tramite_solicitado=$_POST['tramite_solicitado'];


$cambio_de_sa=$_POST['cambio_de_sa'];  //## 1 Servicios Adicionales   0   No Servicios Adicionales
$servicios_adicionales_agregados=$_POST['servicios_adicionales_agregados'];
$servicios_adicionales_agregados_raw=$_POST['servicios_adicionales_agregados_raw'];
$servicios_adicionales_total=$_POST['servicios_adicionales_total'];
$servicios_adicionales_total_raw=$_POST['servicios_adicionales_total_raw'];
###########
$nombre_persona_fisicamoral_solicitante=$_POST['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitante=$_POST['nombre_representante_legal_solicitante'];
$rfc=$_POST['rfc'];
$fisica_o_moral=$_POST['fisica_o_moral'];
$domicilio_solicitante=$_POST['domicilio_solicitante'];
$telefono_solicitante=$_POST['telefono_solicitante'];
$email_solicitante=$_POST['email_solicitante'];
###############
$concepto_recaudacion=$_POST['concepto_recaudacion'];
$numero_permiso_anterior=$_POST['numero_permiso_anterior'];
$numero_permiso_nuevo=$_POST['numero_permiso_nuevo'];
$presupuestoConstancia=$_POST['presupuestoConstancia'];
###############
$memo=mysqli_real_escape_string($con,(strip_tags($_POST["memo"],ENT_QUOTES)));

##
$sql_generales="SELECT descripcion FROM generales WHERE dato_general='UMAS'";
$result_generales = mysqli_query($con,$sql_generales);
$row_generales = mysqli_fetch_assoc($result_generales);
$TIPO_CAMBIO_UMAS=$row_generales['descripcion'];
##

if ($presupuestoConstancia==0) {
$concepto_recaudacion=','.$concepto_recaudacion;
}

$todo= 'monto_umas_tramite_solicitado=('.$monto_umas_tramite_solicitado.' )
 page=('.$page.' )
 ID=('.$ID.' )
 folio=('.$folio.' )
 nombre_comercial_establecimiento=('.$nombre_comercial_establecimiento.' )
 ID_TRAMITE=('.$ID_TRAMITE.' )
cambio_de_giro=('.$cambio_de_giro.' )
cambio_id_giro_solicitado=('.$cambio_id_giro_solicitado.' )
cambio_giro_solicitado=('.$cambio_giro_solicitado.' )
descripcion_tramite_solicitado=('.$descripcion_tramite_solicitado.' )
tramite_solicitado=('.$tramite_solicitado.' )';

################
#########
$descuento=intval($_POST['descuento']);
if ( $descuento>0 ) {

$PORCENTAJE= ((100 - $descuento ) / 100);
$monto_umas_tramite_solicitado_sin_coma = str_replace ( ",", '', $monto_umas_tramite_solicitado);
$monto_umas_con_porcentaje=  $PORCENTAJE  * $monto_umas_tramite_solicitado_sin_coma;

$kuery_Insert_Descuento="INSERT INTO descuentos (
id_principal,
tramite,
monto_umas_tramite,
porcentaje_descuento,
monto_umas_con_porcentaje,
user_id,
fecha_hora,
nota) VALUES (
$ID,
'$tramite_solicitado',
'$monto_umas_tramite_solicitado',
'$descuento',
'$monto_umas_con_porcentaje',
$ID_USER,
'$fecha_datetime_hoy',
'$todo')";
mysqli_query($con,$kuery_Insert_Descuento);
$monto_umas_tramite_solicitado=$monto_umas_con_porcentaje;
}
#########
#########



### en el caso del CAMBIO DE GIRO los 2 ** para tomar el GIRO que se cambiara ( usando un xplode y split )
if ( $cambio_de_giro=="SI" ) {
$nota="Tramite ($descripcion_tramite_solicitado), Giro Solicitado ($cambio_giro_solicitado ** $cambio_id_giro_solicitado ** ),  por un monto de $monto_umas_tramite_solicitado umas, para el establecimiento $nombre_comercial_establecimiento Folio ($folio) $today";
} else {

	if ( $cambio_de_sa==1 ) {
	$nota="Tramite ($descripcion_tramite_solicitado), Servicios Adicionales ($servicios_adicionales_total) Solicitado ($servicios_adicionales_agregados) Quedando (CHANG_SA $servicios_adicionales_agregados_raw CHANG_SA) total SA ($servicios_adicionales_total) ";
	} else {

	$nota="Tramite ($descripcion_tramite_solicitado) por un monto de ($monto_umas_tramite_solicitado) umas, para el establecimiento ($nombre_comercial_establecimiento Folio) ($folio) $today";
	}
}

$conceptoPagoPresupuesto="Tramite Cambio ($descripcion_tramite_solicitado), monto ($monto_umas_tramite_solicitado) umas - $today";

#####################
$sqlInsert="INSERT INTO proceso_tramites (
id_principal,
id_tramite,
fecha_inicio,
fechaRegistro,
en_proceso,
nombre_persona_fisicamoral_solicitante,
nombre_representante_legal_solicitante,
rfc,
fisica_o_moral,
domicilio_solicitante,
telefono_solicitante,
email_solicitante,
memo,
 nota) VALUES (
$ID,
$ID_TRAMITE,
'$today',
'$today',
'EN PROCESO',
'$nombre_persona_fisicamoral_solicitante',
'$nombre_representante_legal_solicitante',
'$rfc',
'$fisica_o_moral',
'$domicilio_solicitante',
'$telefono_solicitante',
'$email_solicitante',
'$memo',
'$nota')";
mysqli_query($con,$sqlInsert);
##
$arregloMaxid2 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `proceso_tramites`"));
$ID_PROCESO_TRAMITE=$arregloMaxid2[0];
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

#####################################################
###  PAGO Pendiete POR Inspeccion
##$MONTO_UMAS_tramiteINS_PESOS=$MONTO_UMAS_tramiteINS*$TIPO_CAMBIO_UMAS;
$concepto_recaudacion_inspeccion='Inspeccion'.$concepto_recaudacion.';'.$MONTO_UMAS_tramiteINS.';'.$numero_permiso_anterior.' '.$numero_permiso_nuevo;
$sql10="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
concepto_pago,
estatus_pago,
total_umas_pagar,
concepto_recaudacion,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Inspeccion',
'$nota',
'Pendiente',
'$MONTO_UMAS_tramiteINS',
'$concepto_recaudacion_inspeccion',
'$today')";
$query_new_insert10 = mysqli_query($con,$sql10);
#
$arregloMaxid4 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM pagos"));
$ID_PAGO_INS=$arregloMaxid4[0];
#
$orden_pago='PI-'.$ID.$ID_PAGO_INS.'-'.$todayANO;
$Update_Pago1="UPDATE pagos SET orden_pago='$orden_pago' WHERE id=$ID_PAGO_INS";
mysqli_query($con,$Update_Pago1);
######################################################
##  PAGO Pendiente POR Recepcion y Analisis Documentos
##$MONTO_UMAS_tramiteRAD_PESOS=$MONTO_UMAS_tramiteRAD*$TIPO_CAMBIO_UMAS;
$concepto_recaudacion_rad='Recepcion y Analisis Documentos'.$concepto_recaudacion.';'.$MONTO_UMAS_tramiteRAD.';'.$numero_permiso_anterior.' '.$numero_permiso_nuevo;
$sql20="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
concepto_pago,
estatus_pago,
total_umas_pagar,
concepto_recaudacion,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Recepcion y Analisis Documentos',
'$nota',
'Pendiente',
'$MONTO_UMAS_tramiteRAD',
'$concepto_recaudacion_rad',
'$today')";
$query_new_insert20 = mysqli_query($con,$sql20);
#
$arregloMaxid5 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM pagos"));
$ID_PAGO_RAD=$arregloMaxid5[0];
#
$orden_pago='PA-'.$ID.$ID_PAGO_RAD.'-'.$todayANO;
$Update_Pago2="UPDATE pagos SET orden_pago='$orden_pago' WHERE id=$ID_PAGO_RAD";
mysqli_query($con,$Update_Pago2);
############
#############
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
$query_new_insert30 = mysqli_query($con,$sql30);
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
$query_new_insert40 = mysqli_query($con,$sql40);
#################################
#
##$monto_umas_tramite_solicitado_PESOS=$monto_umas_tramite_solicitado*$TIPO_CAMBIO_UMAS;
$concepto_recaudacion_tramites=$descripcion_tramite_solicitado.';'.$monto_umas_tramite_solicitado.';'.$numero_permiso_anterior.' '.$numero_permiso_nuevo;
$sqlINSERT60="INSERT INTO  pagos (
id_principal,
id_proceso_tramites,
total_umas_pagar,
concepto_pago,
estatus_pago,
folio,
concepto_recaudacion,
concepto,
fechaRegistro ) VALUES (
$ID,
$ID_PROCESO_TRAMITE,
'$monto_umas_tramite_solicitado',
'$conceptoPagoPresupuesto',
'Pendiente',
'$folio',
'$concepto_recaudacion_tramites',
'Tramite Cambio',
'$today')";
$query_new_insert60 = mysqli_query($con,$sqlINSERT60);
#
$arregloMaxid6 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM pagos"));
$ID_PAGO_TRA=$arregloMaxid6[0];
#
$orden_pago='PX-'.$ID.$ID_PAGO_TRA.'-'.$todayANO;
$Update_Pago6="UPDATE pagos SET orden_pago='$orden_pago' WHERE id=$ID_PAGO_TRA";
mysqli_query($con,$Update_Pago6);
###############################
#######################
#### con el id_tramite y el id_proceso_tramites ES EL ULTIMO TRAMITE REALIZADO y CONSULTAR LOS PDFs
$Kuery_Update="UPDATE principal SET operacion='Tramite', estatus='Tramite Recibos IRAD', id_tramite=$ID_TRAMITE , id_proceso_tramites=$ID_PROCESO_TRAMITE  WHERE id=".$ID;
$query_Update100 = mysqli_query($con,$Kuery_Update);

mysqli_close($con);


			if ($query_Update100) {

				$messages[] = "El  Tramite ( $descripcion_tramite_solicitado  )  ha sido Registrado Correctamente.";
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

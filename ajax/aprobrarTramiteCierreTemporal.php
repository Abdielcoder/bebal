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

$monto_umas_tramite_solicitado=$_POST['monto_umas_tramite_solicitado'];
$page=$_POST['page'];
$ID=$_POST['IDPRINCIPAL'];
$folio=$_POST['folio'];
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];
$ID_TRAMITE=$_POST['id_tramite_solicitado'];

$inspeccion=$_POST['inspeccion'];
$revision_analisis_docs=$_POST['revision_analisis_docs'];

##$cambio_de_giro=$_POST['cambio_de_giro'];
##$cambio_id_giro_solicitado=$_POST['cambio_id_giro_solicitado'];
##$cambio_giro_solicitado=$_POST['cambio_giro_solicitado'];

$descripcion_tramite_solicitado=$_POST['descripcion_tramite_solicitado'];
$tramite_solicitado=$_POST['tramite_solicitado'];

##$cambio_de_sa=$_POST['cambio_de_sa'];  //## 1 Servicios Adicionales   0   No Servicios Adicionales
##$servicios_adicionales_agregados=$_POST['servicios_adicionales_agregados'];
##$servicios_adicionales_agregados_raw=$_POST['servicios_adicionales_agregados_raw'];
##$servicios_adicionales_total=$_POST['servicios_adicionales_total'];
##$servicios_adicionales_total_raw=$_POST['servicios_adicionales_total_raw'];

################
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
$fecha_datetime_hoy=date("Y-m-d H:i:s");
################

$nota="Cierre Temporal ($descripcion_tramite_solicitado) por un monto de ($monto_umas_tramite_solicitado) umas, para el establecimiento ($nombre_comercial_establecimiento Folio) ($folio) $today";

$conceptoPagoPresupuesto="Cierre Temporal ($descripcion_tramite_solicitado), monto ($monto_umas_tramite_solicitado) umas $today";

#####################
##$sqlInsert="INSERT INTO proceso_tramites (
##id_principal,
##id_tramite,
##fecha_inicio,
##fechaRegistro,
##en_proceso,
## nota) VALUES (
##$ID,
##$ID_TRAMITE,
##'$today',
##'$today',
##'EN PROCESO',
##'$nota')";
##mysqli_query($con,$sqlInsert);
##
##$arregloMaxid2 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `proceso_tramites`"));
##$ID_PROCESO_TRAMITE=$arregloMaxid2[0];
##$ID_PROCESO_TRAMITE=0;
########################
$Kuery_CierreTemporal="INSERT INTO cierre_temporal (
folio,
id_principal,
inspeccion,
rad,
user_id,
fecha_hora,
estatus,
nota ) VALUES (
'$folio',
$ID,
'$inspeccion',
'$revision_analisis_docs',
$ID_USER,
'$fecha_datetime_hoy',
'Aprobado',
'$nota');";
mysqli_query($con,$Kuery_CierreTemporal);
$arregloMaxid3 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `cierre_temporal`"));
$ID_PROCESO_TRAMITE=$arregloMaxid3[0];
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
if ( $inspeccion=="Si" ) {
$sql10="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
concepto_pago,
estatus_pago,
total_umas_pagar,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Inspeccion',
'$nota',
'Pendiente',
'$MONTO_UMAS_tramiteINS',
'$today')";
} else {
$sql10="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
concepto_pago,
estatus_pago,
total_umas_pagar,
monto,
numero_pago,
fecha_pago,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Inspeccion',
'$nota',
'PAGADO',
'0',
'0',
'Sin Inspeccion',
'$today',
'$today')";
}
$query_new_insert10 = mysqli_query($con,$sql10);
######################################################
##  PAGO Pendiente POR Recepcion y Analisis Documentos
if ( $revision_analisis_docs=="Si" ) {
$sql20="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
concepto_pago,
estatus_pago,
total_umas_pagar,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Recepcion y Analisis Documentos',
'$nota',
'Pendiente',
'$MONTO_UMAS_tramiteRAD',
'$today')";
} else {
$sql20="INSERT INTO pagos (
id_principal,
folio,
id_proceso_tramites,
concepto,
concepto_pago,
estatus_pago,
total_umas_pagar,
monto,
numero_pago,
fecha_pago,
fechaRegistro ) VALUES (
$ID,
'$folio',
$ID_PROCESO_TRAMITE,
'Recepcion y Analisis Documentos',
'$nota',
'PAGADO',
'0',
'0',
'Sin RAD',
'$today',
'$today')";
}
$query_new_insert20 = mysqli_query($con,$sql20);
############
#############
if ( $inspeccion=="Si" ) {
$sql30="INSERT INTO inspeccion (
id_principal,
folio,
id_proceso_tramites,
fechaRegistro,
observaciones,
en_proceso) VALUES (
$ID, 
'$folio', 
$ID_PROCESO_TRAMITE, 
'$today',
'Cierre Temporal',
'Espera Pago')";
$query_new_insert30 = mysqli_query($con,$sql30);
$Kuery_Update="UPDATE principal SET operacion='Cierre Temporal-".$ID_PROCESO_TRAMITE."', estatus='CTemp Recibo Insp' WHERE id=".$ID;
} else {
$Kuery_Update="UPDATE principal SET operacion='Cierre Temporal-".$ID_PROCESO_TRAMITE."', estatus='Cierre Temporal' WHERE id=".$ID;
}
##
if ( $revision_analisis_docs=="Si" ) {
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
} else {
}
##$query_new_insert40 = mysqli_query($con,$sql40);
#################################
#
$sqlINSERT60="INSERT INTO  pagos (
id_principal,
id_proceso_tramites,
total_umas_pagar,
concepto_pago,
estatus_pago,
folio,
concepto,
fechaRegistro ) VALUES (
$ID,
$ID_PROCESO_TRAMITE,
'$monto_umas_tramite_solicitado',
'$conceptoPagoPresupuesto',
'Pendiente',
'$folio',
'Cierre Temporal',
'$today')";
$query_new_insert60 = mysqli_query($con,$sqlINSERT60);
###############################
#######################

$query_Update100 = mysqli_query($con,$Kuery_Update);

mysqli_close($con);


			if ($query_Update100) {

				$messages[] = "El Cierre Temporal ( $descripcion_tramite_solicitado  )  ha sido Registrado Correctamente.";
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

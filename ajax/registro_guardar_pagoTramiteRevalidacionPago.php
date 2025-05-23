<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

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

$tramite_pago=$_POST['tramite_pago'];
$tramite_pagoid=$_POST['tramite_pagoid'];
$folio=$_POST['folio'];

$id_pago_rad=$_POST['id_pago_rad'];
$id_pago_ins=$_POST['id_pago_ins'];

$total_umas_pagar=$_POST['total_umas_pagar'];
$id_tramite_solicitado=$_POST['id_tramite_solicitado'];

$ID_PROCESO_TRAMITE=$_POST['id_proceso_tramites'];

#######################################################
#######################################################
##
## Inspeccion
## Recepcion y Analisis Documentos

switch ($tramite_pago) {
    case "Recepcion y Analisis Documentos":
##
$sql20="UPDATE pagos SET estatus_pago='PAGADO', numero_pago='$numero_pago', monto='$monto', fecha_pago='$today' WHERE id=".$id_pago_rad;
$query_Update20 = mysqli_query($con,$sql20);
###########
$Kuery_Update_principal="UPDATE principal SET estatus='Pago RAD-Cambio' WHERE id=".$ID;
break;
    case "Inspeccion":
##
##
$sql200="UPDATE pagos SET estatus_pago='PAGADO', numero_pago='$numero_pago', monto='$monto', fecha_pago='$today' WHERE id=".$id_pago_ins;
$query_Update20 = mysqli_query($con,$sql200);
##
$Kuery_Update_principal="UPDATE principal SET estatus='Pago INSP-Revalidacion' WHERE id=".$ID;
break;
    default:
$Kuery_Update_principal="UPDATE principal SET estatus='PAGO X-Cambio' WHERE id=".$ID;
}

mysqli_query($con,$Kuery_Update_principal);
##
###########################################
####  SE REVISAN SI YA PAGARON LAS 2 TAREAS
##$PAGO_RAD=0;
##$PAGO_INS=0;
###
###$sql_pagoRAD="SELECT * FROM `pagos` WHERE `id_principal`=$ID AND `concepto`='Recepcion y Analisis Documentos' AND estatus_pago='PAGADO' AND id_proceso_tramites=".$ID_PROCESO_TRAMITE;
###$result_pagoRAD = mysqli_query($con,$sql_pagoRAD);
###if (mysqli_num_rows($result_pagoRAD) > 0) {
###$PAGO_RAD='PAGADO';
###} else {
###$PAGO_RAD=0;
###}
##
##$sql_pagoI="SELECT * FROM `pagos` WHERE `id_principal`=$ID AND `concepto`='Inspeccion' AND `estatus_pago`='PAGADO' AND id_proceso_tramites=".$ID_PROCESO_TRAMITE;
##$result_pagoI = mysqli_query($con,$sql_pagoI);
##if (mysqli_num_rows($result_pagoI) > 0) {
##$PAGO_INS='PAGADO';
##} else {
##$PAGO_INS=0;
##}
###

###if ( $PAGO_RAD=='PAGADO' && $PAGO_INS=='PAGADO' ) {
###$Kuery_Update2_principal="UPDATE principal SET estatus='Pagos-IRAD-Cambio' WHERE id=".$ID;
###mysqli_query($con,$Kuery_Update2_principal);
##
###$Kuery_Update3_RAD="UPDATE recepcion_analisis_documentos SET fecha_inicio='$today', en_proceso='En Proceso' WHERE id_principal=".$ID." AND id_proceso_tramites=".$ID_PROCESO_TRAMITE;
###mysqli_query($con,$Kuery_Update3_RAD);

#########################
#### CONSULTAR el id_proceso_tramites y id_tramite para meter las fotos en el ultimo TRAMITE 
### Ya que no se esta haciendo el RAD

$sqlPrincipal="SELECT * FROM principal WHERE id=".$ID;
$row = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));
$id_tramite=$row['id_tramite'];
$id_proceso_tramites=$row['id_proceso_tramites'];
##
$Kuery_Update3_INS="UPDATE inspeccion SET fecha_inicio='$today', en_proceso='En Proceso Revalidacion', observaciones='En Proceso Revalidacion' WHERE id_principal=".$ID." AND id_proceso_tramites=0 AND en_proceso='Espera Pago Revalidacion'";
mysqli_query($con,$Kuery_Update3_INS);

###}
###
mysqli_close($con);

			if ($Kuery_Update_principal) {
				$messages[] = "Se Registro el Pago con Exito Folio ($folio)";
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

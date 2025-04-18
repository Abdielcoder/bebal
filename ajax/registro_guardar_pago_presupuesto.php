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

$fecha_expiracion = strtotime ('+1 year' , strtotime($today));
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


$CONCEPTO_PAGO="Tramite [[ ".$concepto_tramite." ]]   Giro [[ ".$concepto_giro." ]] Modalidad  [[ ".$concepto_modalidad." ]]  Servicios Adicionales [[ ".$concepto_servicios_adicionales."]] Total UMAS ".$total_umas_pagar;

##
## Presupuesto

##

$sqlINSERT="INSERT INTO  pagos (
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
'$today')";
##
$Kuery_Update_principal="UPDATE principal SET operacion='Activo', estatus='Permiso Autorizado', fecha_expiracion='$fecha_expiracion',  fecha_autorizacion='$today', nip='$NIPgenerado'  WHERE id=".$ID;

$Kuery_Update2="UPDATE proceso_tramites SET fecha_fin='$today', en_proceso='Fin' WHERE id_principal=".$ID;

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



			if ($query_Update) {
				$messages[] = "Se Registro el Pago con Exito y Autorizo  Folio ($folio)";
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

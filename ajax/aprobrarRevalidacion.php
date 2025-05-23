<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
	$ID_USER=$_SESSION['user_id'];


	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['IDPRINCIPAL']) || 
	empty($_POST['monto_umas_tramite_solicitado'])
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
$tramite_solicitado=$_POST['tramite_solicitado'];
$descripcion_tramite_solicitado=$_POST['descripcion_tramite_solicitado'];


################
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
################

##$sql_Revalidacion="SELECT * FROM revalidacion WHERE id_principal=".$ID." AND estatus='Revalidado'";
##$result_Revalidacion = mysqli_query($con,$sql_Revalidacion);
##$row_Revalidacion = mysqli_fetch_assoc($result_Revalidacion);
##$ULTIMA_FECHA_REVALIDACION=$row_Revalidacion['fecha'];
##

$nota="Revalidacion ($nombre_comercial_establecimiento) por un monto de ($monto_umas_tramite_solicitado) umas,  Folio ($folio) $today";


#####################
$sqlInsert="INSERT INTO revalidacion (
id_principal,
user_id,
estatus,
nota,
fecha) VALUES (
$ID,
$ID_USER,
'En Proceso',
'$nota',
'$today')";
mysqli_query($con,$sqlInsert);
##
$arregloMaxid2 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM revalidacion"));
$ID_REVALIDACION=$arregloMaxid2[0];

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
0,
'Inspeccion Revalidacion',
'$nota',
'Pendiente Revalidacion',
'$MONTO_UMAS_tramiteINS',
'$today')";
$query_new_insert10 = mysqli_query($con,$sql10);
######################################################
##  PAGO Pendiente POR Recepcion y Analisis Documentos
##$sql20="INSERT INTO pagos (
##id_principal,
##folio,
##id_proceso_tramites,
##concepto,
##concepto_pago,
##estatus_pago,
##total_umas_pagar,
##fechaRegistro ) VALUES (
##$ID,
##'$folio',
##0,
##'Recepcion y Analisis Documentos Revalidacion',
##'$nota',
##'Pendiente Revalidacion',
##'$MONTO_UMAS_tramiteRAD',
##'$today')";
##$query_new_insert20 = mysqli_query($con,$sql20);
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
0, 
'$today',
'Espera Pago Revalidacion')";
$query_new_insert30 = mysqli_query($con,$sql30);

##
##$sql40="INSERT INTO recepcion_analisis_documentos (
##id_principal,
##folio,
##id_proceso_tramites,
##fechaRegistro,
##en_proceso) VALUES (
##$ID, 
##'$folio', 
##0, 
##'$today',
##'Espera Pago')";
##$query_new_insert40 = mysqli_query($con,$sql40);

#################################
# PAGO REVALIDACION
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
0,
'$monto_umas_tramite_solicitado',
'$conceptoPagoPresupuesto',
'Pendiente',
'$folio',
'Revalidacion',
'$today')";
$query_new_insert60 = mysqli_query($con,$sqlINSERT60);
###############################
#######################
$Kuery_Update="UPDATE principal SET operacion='Revalidando', estatus='Revalidando Recibo Inpeccion'  WHERE id=".$ID;
$query_Update100 = mysqli_query($con,$Kuery_Update);



			if ($query_new_insert60) {

				$messages[] = "El Proceso ( $descripcion_tramite_solicitado  )  ha sido Registrado Correctamente.";
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

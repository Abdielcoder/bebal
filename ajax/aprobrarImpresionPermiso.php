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
$todayANO = date("Y");
################


$nota="Imprimir Permiso ($nombre_comercial_establecimiento) por un monto de ($monto_umas_tramite_solicitado) umas,  Folio ($folio) $today";


######################
######################
$sql_Cuenta_Paso="SELECT COUNT(*) CUENTA_PASO FROM de_paso WHERE id_principal=$ID";
$result_CuentaPaso=mysqli_query($con,$sql_Cuenta_Paso);
$row_cuentaPaso = mysqli_fetch_assoc($result_CuentaPaso);
$CUENTA_PASO=$row_cuentaPaso['CUENTA_PASO'];
if ( $CUENTA_PASO>0 ) {
$sql_Paso="SELECT * FROM de_paso WHERE id_principal=$ID";
$result_Paso=mysqli_query($con,$sql_Paso);
$row_Paso = mysqli_fetch_assoc($result_Paso);
$NUMERO_PERMISO_ANTERIOR=$row_Paso['numero_permiso'];
} else {
$NUMERO_PERMISO_ANTERIOR='No Disponible';
}
######################
######################

$arregloNP = mysqli_fetch_array(mysqli_query($con,"SELECT numero_permiso FROM principal WHERE id=$ID"));
$numero_permiso_nuevo=$arregloNP[0];

#####################
$sqlInsert="INSERT INTO impresion_permiso (
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
$arregloMaxid2 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM impresion_permiso"));
$ID_IP=$arregloMaxid2[0];

##
$sql_generales="SELECT descripcion FROM generales WHERE dato_general='UMAS'";
$result_generales = mysqli_query($con,$sql_generales);
$row_generales = mysqli_fetch_assoc($result_generales);
$TIPO_CAMBIO_UMAS=$row_generales['descripcion'];
$monto_umas_tramite_solicitado_PESOS=$monto_umas_tramite_solicitado*$TIPO_CAMBIO_UMAS;
##
########################
##
# PAGO IMPRESION PERMISO

$concepto_recaudacion_tramites=$descripcion_tramite_solicitado.';'.$monto_umas_tramite_solicitado.';'.$monto_umas_tramite_solicitado_PESOS.';'.$NUMERO_PERMISO_ANTERIOR.' '.$numero_permiso_nuevo;

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
0,
'$monto_umas_tramite_solicitado',
'$conceptoPagoPresupuesto',
'Pendiente',
'$folio',
'$concepto_recaudacion_tramites',
'Impresion Permiso',
'$today')";
$query_new_insert60 = mysqli_query($con,$sqlINSERT60);
###############################
#
$arregloMaxid6 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM pagos"));
$ID_PAGO_TRA=$arregloMaxid6[0];
#
$orden_pago='PX-'.$ID.$ID_PAGO_TRA.'-'.$todayANO;
$Update_Pago6="UPDATE pagos SET orden_pago='$orden_pago' WHERE id=$ID_PAGO_TRA";
mysqli_query($con,$Update_Pago6);

#######################
$Kuery_Update="UPDATE principal SET estatus='IP Proceso'  WHERE id=".$ID;
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

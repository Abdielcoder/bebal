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

$id_proceso_tramites=$_POST['id_proceso_tramites'];
$folio=$_POST['folio'];

$id_tramite=$_POST['id_tramite'];


##
## Presupuesto

##

$sql20="UPDATE pagos SET estatus_pago='PAGADO', numero_pago='$numero_pago', monto='$monto', fecha_pago='$fecha_pago' WHERE id_principal=".$ID." AND id_proceso_tramites=".$id_proceso_tramites;
$query_Update20 = mysqli_query($con,$sql20);

##
$Kuery_Update_principal="UPDATE principal SET  estatus='Pago Tramite' WHERE id=".$ID;
$query_Update = mysqli_query($con,$Kuery_Update_principal);


			if ($query_Update) {
				$messages[] = "Se Registro el Pago  con Exito -  Folio ($folio)";
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

<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['idprincipal']) || 
	empty($_POST['folio']) || 
	empty($_POST['nombre_comercial_establecimiento_NUEVO'])
	) {

	if ( empty($_POST['nombre_comercial_establecimiento_NUEVO']) ) $errors[] = "Campo vacío -- nombre_comercial_establecimiento_NUEVO";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

$idprincipal=$_POST['idprincipal'];
$nombre_comercial_establecimiento_NUEVO=strtoupper($_POST['nombre_comercial_establecimiento_NUEVO']);

#####################
$sqlSelectPrincipal="SELECT * FROM principal WHERE id=".$idprincipal;
$rowP = mysqli_fetch_array(mysqli_query($con,$sqlSelectPrincipal));


$folioDB=$rowP['folio'];
$fecha_altaDB=$rowP['fecha_alta'];
$nombre_comercial_establecimientoDB=$rowP['nombre_comercial_establecimiento'];

$id_proceso_tramitesDB=$rowP['id_proceso_tramites'];
$id_tramiteDB=$rowP['id_tramite'];
################

$tramite_cambio="(".$nombre_comercial_establecimientoDB.",  fecha Alta ".$fecha_altaDB." ) Folio ".$folioDB;


###
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$NIPgenerado=substr(str_shuffle($permitted_chars),0,6);
###
#
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
#####################
$sql_UpdatePrincipal="UPDATE principal SET 
estatus='Permiso Autorizado',
operacion='Activo',
nombre_comercial_establecimiento='$nombre_comercial_establecimiento_NUEVO',
nip='$NIPgenerado' 
WHERE id=".$idprincipal;

$query_UpdatePrincipal = mysqli_query($con,$sql_UpdatePrincipal);

##

$Kuery_Update2="UPDATE proceso_tramites SET fecha_fin='$today', en_proceso='Fin', el_cambio='$tramite_cambio'  WHERE id=".$id_proceso_tramitesDB;

mysqli_query($con,$Kuery_Update2);



if ($query_UpdatePrincipal) {



				$messages[] = "El Registro  ha sido  Actualizado Exito Folio ($folioDB)";
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

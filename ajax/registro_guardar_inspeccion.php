<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['latitud']) || 
	empty($_POST['superficie_establecimiento'])
	) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

$today = date("Y-m-d");

$ID=intval($_POST['idprincipal']);
$pagina=intval($_POST['pagina']);
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];

$observaciones=$_POST['observaciones'];
$latitud=$_POST['latitud'];
$longitud=$_POST['longitud'];
$superficie_establecimiento=$_POST['superficie_establecimiento'];
$capacidad_comensales_personas=$_POST['capacidad_comensales_personas'];


$sql="INSERT INTO inspeccion (
id_principal,
nombre_comercial_establecimiento,
id_proceso_tramites,
observaciones,
fechaRegistro ) VALUES (
$ID,
'$nombre_comercial_establecimiento',
1,
'$observaciones',
'$today')";
$query_new_insert = mysqli_query($con,$sql);

##  de Efectuar Inspeccion  -->  Inspeccion Realizada
$Kuery_Update="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."', superficie_establecimiento='".$superficie_establecimiento."', capacidad_comensales_personas='".$capacidad_comensales_personas."', estatus='Inspeccion Realizada' WHERE id=".$ID;
mysqli_query($con,$Kuery_Update);
##


			if ($query_new_insert) {
				$messages[] = "Se Registro Inspeccion se Alamaceno con Exito.";
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

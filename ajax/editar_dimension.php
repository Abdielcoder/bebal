<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_dimension']) || 
	empty($_POST['mod_descripcion'])
	) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");
		$ID=intval($_POST['mod_id']);
		// escaping, additionally removing everything that could be (html/javascript-) code
		$dimension=strtoupper($_POST['mod_dimension']);
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_descripcion"],ENT_QUOTES)));
		###
		$descripcion=ucwords($descripcion);
		###
		
##########
$sql="UPDATE dimensiones SET 
`dimension`='$dimension',
`descripcion`='$descripcion'
 WHERE id=$ID";
##echo $sql;
		$query_update = mysqli_query($con,$sql);
			if ($query_update) {
				$messages[] = "La Dimension Valla ha sido Actualizada satisfactoriamente.";
			} else {
				$errors []= "$sql Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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

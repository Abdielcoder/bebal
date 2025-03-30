<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['folio_data']) || 
	empty($_POST['numero_permiso_data']) || 
	empty($_POST['direccion_data'])
	) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");
		$ID=intval($_POST['id_valla']);
		// escaping, additionally removing everything that could be (html/javascript-) code
		$folio=strtoupper($_POST['folio_data']);
		$numero_permiso=strtoupper($_POST['numero_permiso_data']);
		$mapa=$_POST['mapa_data'];
		$dimension=$_POST['dimension_data'];
		$video_url=$_POST['video_url_data'];
		$direccion=$_POST['direccion_data'];
		$delegacion=$_POST['delegacion_data'];
		$pagina=$_POST['pagina'];
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["descripcion_data"],ENT_QUOTES)));
		##$unidades=intval($_POST['unidades']];
		###
		$direccion=ucwords($direccion);
		$descripcion=ucwords($descripcion);
		###
		
##########
$sql="UPDATE vallas SET 
`folio`='$folio',
`numero_permiso`='$numero_permiso',
`direccion`='$direccion',
`descripcion`='$descripcion',
`dimension_id`=$dimension,
`id_delegacion`=$delegacion,
`video_url`='$video_url',
`mapa`='$mapa' WHERE id=$ID";
		$query_update = mysqli_query($con,$sql);
			if ($query_update) {
				$messages[] = "La Valla ha sido Actualizada satisfactoriamente.";
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

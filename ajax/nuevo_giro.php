<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['descripcion_giro'])) {
           $errors[] = "Giro vacío";
        } else if (!empty($_POST['cuenta'])){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$descripcion_giro=mysqli_real_escape_string($con,(strip_tags($_POST["descripcion_giro"],ENT_QUOTES)));
		###
		//$id_delegacion=$_POST['id_delegacion'];
		$concepto=ucwords($_POST['concepto']);
		$cuenta=strtoupper($_POST['cuenta']);
		$monto_umas=$_POST['monto_umas'];
		$monto_umas_revalidacion_anual=$_POST['monto_umas_revalidacion_anual'];
		$horario_funcionamiento=strtoupper($_POST['horario_funcionamiento']);
		###
		$today=date("Y-m-d");
		$sql="INSERT INTO giro (descripcion_giro, cuenta,monto_umas, concepto,horario_funcionamiento, fecha, monto_umas_revalidacion_anual ) VALUES ('$descripcion_giro','$cuenta','$monto_umas','$concepto','$horario_funcionamiento','$today','.$monto_umas_revalidacion_anual.')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Giro ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
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

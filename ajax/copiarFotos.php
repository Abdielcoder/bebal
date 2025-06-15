<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['IDPRINCIPAL'])) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

$IDPRINCIPAL=intval($_POST['IDPRINCIPAL']);
$id_proceso_tramites_anterior=intval($_POST['id_proceso_tramites_anterior']);
$id_proceso_tramites_actual=intval($_POST['id_proceso_tramites_actual']);

$Original="/var/www/html/bebal_images/originales/";
$Medias="/var/www/html/bebal_images/medias/";
$Thumbs="/var/www/html/bebal_images/thumbs/";


$sql10="SELECT * FROM fotos WHERE descripcion='OK' AND id_proceso_tramites=$id_proceso_tramites_anterior";
$result10 = mysqli_query($con,$sql10);
$rows10 = mysqli_num_rows($result10);

for ($i0 = 0; $i0 < $rows10; $i0++) {
$ROW_resultado10= mysqli_fetch_array($result10,MYSQLI_NUM);
$idfotoAnterior = $ROW_resultado10[0];
$idprincipalAnterior = $ROW_resultado10[2];
$id_proceso_tramitesAnterior = $ROW_resultado10[3];

$Nombre_Archivo_Anterior=$IDPRINCIPAL.'-'.$id_proceso_tramitesAnterior.'-'.$idfotoAnterior.'.jpg';

$kueryInsert="INSERT INTO fotos (descripcion,idprincipal,id_proceso_tramites) VALUES ('OK','$IDPRINCIPAL','$id_proceso_tramites_actual')";
##$kueryInsert="INSERT INTO fotos (descripcion,idprincipal,id_proceso_tramites) VALUES ('$Nombre_Archivo_Anterior','$IDPRINCIPAL','$id_proceso_tramites_actual')";
mysqli_query($con,$kueryInsert);

$arregloMaxid = mysqli_fetch_array(mysqli_query($con,"SELECT max(`idfoto`) FROM `fotos`"));
$idfotoActual=intval($arregloMaxid[0]);
###############
if ( $i0==0 ) {
$sqlUpdate1="UPDATE principal SET foto='$idfotoActual' WHERE id=".$IDPRINCIPAL;
mysqli_query($con, $sqlUpdate1);
}
###############
$Nombre_Archivo_Actual=$IDPRINCIPAL.'-'.$id_proceso_tramites_actual.'-'.$idfotoActual.'.jpg';

##
copy($Original.$Nombre_Archivo_Anterior, $Original.$Nombre_Archivo_Actual);
copy($Medias.$Nombre_Archivo_Anterior, $Medias.$Nombre_Archivo_Actual);
copy($Thumbs.$Nombre_Archivo_Anterior, $Thumbs.$Nombre_Archivo_Actual);
}

###
mysqli_close($con);



			if ($result10) {
				$messages[] = "Se Copiaron  las Fotografias Correctamente";
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

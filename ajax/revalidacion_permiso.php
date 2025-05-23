<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['idprincipal']) || 
	empty($_POST['id_giro'])
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
$page=intval($_POST['pagina']);
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];

$id_giro=$_POST['id_giro'];
$folio=$_POST['folio'];

##
##
$KueryPRIN="SELECT * FROM principal WHERE id=$ID";
$arreglo_PRIN = mysqli_fetch_array(mysqli_query($con,$KueryPRIN));
$FOLIO=$arreglo_PRIN['folio'];
$fecha_expiracionDB=$arreglo_PRIN['fecha_expiracion'];
###
$pieces = explode("-",$fecha_expiracionDB);
$ANOpieces=$pieces[0];
$MESpieces=$pieces[1];
##$MASunANO = strtotime ('+1 year' , strtotime($ANOpieces));

###
$arregloGIRO=mysqli_fetch_array(mysqli_query($con,"SELECT  *  FROM giro WHERE id=$id_giro"));
$MES_VENCIMIENTO=$arregloGIRO[6];
$GIRO=$arregloGIRO[1];
##
$todayANO = date("Y");
$MASunANO = strtotime ('+1 year' , strtotime($todayANO));
$MASunANO = date ('Y',$MASunANO);
$FECHA_EXPIRACION=$MASunANO.'-'.$MES_VENCIMIENTO.'-01';
##


##########
$Kuery_Update0="UPDATE revalidacion SET fecha_expiracion='$FECHA_EXPIRACION', estatus='Permiso Autorizado' WHERE estatus='En Proceso' AND id_principal=$ID";
mysqli_query($con,$Kuery_Update0);
##########
$Kuery_Update="UPDATE principal SET fecha_expiracion='$FECHA_EXPIRACION',estatus='Permiso Autorizado', operacion='Activo' WHERE id=$ID";
$query_Update = mysqli_query($con,$Kuery_Update);
##

mysqli_close($con);
			if ($query_Update) {
				$messages[] = "Se Revalido el   Permiso con Exito Folio ($FOLIO )";
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

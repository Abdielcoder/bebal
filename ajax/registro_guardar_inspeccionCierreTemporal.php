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

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

$ID=intval($_POST['idprincipal']);
$pagina=intval($_POST['pagina']);
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];

$observaciones=$_POST['observaciones'];
$latitud=$_POST['latitud'];
$longitud=$_POST['longitud'];
$superficie_establecimiento=$_POST['superficie_establecimiento'];
$capacidad_comensales_personas=$_POST['capacidad_comensales_personas'];
$folio=$_POST['folio'];
$mod_folio=$_POST['mod_folio'];
$id_tramite=$_POST['id_tramite'];
$id_proceso_tramites=$_POST['id_proceso_tramites'];
$id_cierre_temporal=$_POST['id_cierre_temporal'];

// Le quite Observaciones
//observaciones='$observaciones',

$sql="UPDATE inspeccion SET 
superficie_establecimiento=$superficie_establecimiento,
capacidad_comensales_personas=$capacidad_comensales_personas,
en_proceso='FIN',
fecha_fin='$today'  WHERE 
id_principal=$ID AND id_proceso_tramites=$id_cierre_temporal AND observaciones='Cierre Temporal'";

$query_Update = mysqli_query($con,$sql);

##  de Efectuar Inspeccion  -->  Inspeccion Realizada

#### Hay que revisar si ya se realizo la Inspeccion, siendo asi el estaus = Presupuesto
##$Kuery_ChecarEstatus="SELECT COUNT(*) AS CuentaChecarEstatus FROM principal WHERE estatus='RAD Realizado' AND id=".$ID;
##$arreglo_ChecarEstatus = mysqli_fetch_array(mysqli_query($con,$Kuery_ChecarEstatus));
##$cuentaSTATUS=$arreglo_ChecarEstatus['CuentaChecarEstatus'];
##if ( $cuentaSTATUS> 0 ) {
$Kuery_Update="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."', estatus='Cierre Temporal' WHERE id=".$ID;
##} else {
##$Kuery_Update="UPDATE principal SET latitud='".$latitud."', longitud='".$longitud."', estatus='Inspeccion Realizada' WHERE id=".$ID;
##}

if (!mysqli_query($con,$Kuery_Update)) echo mysqli_error();
##
$KueryPRIN="SELECT * FROM principal WHERE id=".$ID;
$arreglo_PRIN = mysqli_fetch_array(mysqli_query($con,$KueryPRIN));
$FOLIO=$arreglo_PRIN['folio'];

mysqli_close($con);

			if ($query_Update) {
				$messages[] = "Se Finalizo la Inspección-Cierre Temporal con Exito Folio ($FOLIO )";
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

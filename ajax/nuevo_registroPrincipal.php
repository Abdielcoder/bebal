<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre_representante_legal_solicitante']) || 
	empty($_POST['nombre_comercial_establecimiento']) || 
	empty($_POST['clave_catastral'])
	) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

		$id_giro=$_POST['id_giro'];
		$id_modalidad_GA=$_POST['id_modalidad_GA'];
		$id_delegacion=$_POST['id_delegacion'];
		$id_colonia=$_POST['id_colonia'];

		// escaping, additionally removing everything that could be (html/javascript-) code
		$observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)));
		$fecha_alta=$_POST['fecha_alta'];
		$fecha_datetime_hoy=date("Y-m-d H:i:s");
		$clave_catastral=strtoupper($_POST['clave_catastral']);


$nombre_comercial_establecimiento=strtoupper($_POST['nombre_comercial_establecimiento']);
$calle_establecimiento=strtoupper($_POST['calle_establecimiento']);
$entre_calles_establecimiento=strtoupper($_POST['entre_calles_establecimiento']);
$numero_establecimiento=$_POST['numero_establecimiento'];
$numerointerno_local_establecimiento=$_POST['numerointerno_local_establecimiento'];
$cp_establecimiento=$_POST['cp_establecimiento'];

$nombre_persona_fisicamoral_solicitante=strtoupper($_POST['nombre_persona_fisicamoral_solicitante']);
$nombre_representante_legal_solicitante=strtoupper($_POST['nombre_representante_legal_solicitante']);
$domicilio_solicitante=strtoupper($_POST['domicilio_solicitante']);
$email_solicitante=$_POST['email_solicitante'];
$telefono_solicitante=$_POST['telefono_solicitante'];


###
##########
$sql="INSERT INTO principal (
giro,
modalidad_graduacion_alcoholica,
`id_municipio`,
`id_delegacion`,
`id_colonia`,
`estatus`,
`operacion`,
`clave_catastral`,
nombre_comercial_establecimiento,
calle_establecimiento,
entre_calles_establecimiento,
numero_establecimiento,
numerointerno_local_establecimiento,
cp_establecimiento,
nombre_persona_fisicamoral_solicitante,
nombre_representante_legal_solicitante,
domicilio_solicitante,
email_solicitante,
telefono_solicitante,
`fecha_alta`,
`observaciones`,
`fecha_hora_registro`
) VALUES (
$id_giro, 
$id_modalidad_GA,
$ID_MUNICIPIO,
$id_delegacion,
$id_colonia,
'Generar Recibo Inspeccion',
'NUEVO',
'$clave_catastral',
'$nombre_comercial_establecimiento',
'$calle_establecimiento',
'$entre_calles_establecimiento',
'$numero_establecimiento',
'$numerointerno_local_establecimiento',
'$cp_establecimiento',
'$nombre_persona_fisicamoral_solicitante',
'$nombre_representante_legal_solicitante',
'$domicilio_solicitante',
'$email_solicitante',
'$telefono_solicitante',
'$fecha_alta',
'$observaciones',
'$fecha_datetime_hoy'
)";
##
$query_new_insert = mysqli_query($con,$sql);

			if ($query_new_insert) {
$arregloMaxid = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `principal`"));
$ID=$arregloMaxid[0];
$Kuery_Update="UPDATE principal SET folio='".$ID_MUNICIPIO."-".$ID."' WHERE id=".$ID;
mysqli_query($con,$Kuery_Update);
##

$sqlInsert="INSERT INTO proceso_tramites (
id_principal,
id_tramite,
fecha_inicio,
fechaRegistro,
en_proceso) VALUES (
$ID,
1,
'$fecha_alta',
'$fecha_alta',
'EN PROCESO')";



mysqli_query($con,$sqlInsert);



				$messages[] = "El Registro ha sido dado de Alta Exito.";
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

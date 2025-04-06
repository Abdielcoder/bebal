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

$today = date("Y-m-d");

$ID=intval($_POST['idprincipal']);
##$pagina=intval($_POST['pagina']);
$nombre_comercial_establecimiento=$_POST['nombre_comercial_establecimiento'];

$fecha_pago=$_POST['fecha_pago'];
$numero_pago=$_POST['numero_pago'];
$monto=$_POST['monto'];

$tramite_pago=$_POST['tramite_pago'];
$tramite_pagoid=$_POST['tramite_pagoid'];
$folio=$_POST['folio'];


$sql="INSERT INTO pagos (
id_principal,
folio,
nombre_comercial_establecimiento,
id_proceso_tramites,
numero_pago,
monto,
concepto,
concepto_pago,
fecha_pago,
fechaRegistro ) VALUES (
$ID,
'$folio',
'$nombre_comercial_establecimiento',
1,
'$numero_pago',
'$monto',
'$tramite_pago',
'tramite=$tramite_pagoid',
'$fecha_pago',
'$today')";
$query_new_insert = mysqli_query($con,$sql);

##
switch ($tramite_pago) {
    case "Análisis y Revisión Documentos - Permiso Nuevo":
$Kuery_Update="UPDATE principal SET estatus='Análisis y Revisión Documentos' WHERE id=".$ID;
        break;
    case "Inspección - Permiso Nuevo":
$Kuery_Update="UPDATE principal SET estatus='Efectuar Inspeccion' WHERE id=".$ID;
        break;
    default:
$Kuery_Update="UPDATE principal SET estatus='Pago Desconocido' WHERE id=".$ID;
}


mysqli_query($con,$Kuery_Update);
##


			if ($query_new_insert) {
				$messages[] = "Se Registro el Pago con Exito Folio ($folio)";
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

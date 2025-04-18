<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['folio']) || 
	empty($_POST['id_principal'])
	) {

	if ( empty($_POST['folio']) ) $errors[] = "Campo vacío -- folio";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

#####################

$folio=$_POST['folio'];
$user_id=$_POST['user_id'];
$id_principal=$_POST['id_principal'];

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

################
################
$arregloCuenta=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folio'"));
$CUENTA=$arregloCuenta[0];
###############
##########
if ( $CUENTA>0 ) {

} else {
$sql_INSERT="INSERT INTO numero_permiso (
folio,
id_principal,
user_id,
fecha ) VALUES (
'$folio',
$id_principal,
$user_id,
'$today')";
$query_new_insert = mysqli_query($con,$sql_INSERT);
if ($query_new_insert) {
$arregloMaxid = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `numero_permiso`"));
$ID=intval($arregloMaxid[0]);

$tamano=strlen($ID);

$NP='';
## numero permiso  ME-XXXXXXX
$siglas='ME-';

switch ($tamano) {
    case 1:
        $NP=$siglas.'000000'.$ID;
    case 2:
        $NP=$siglas.'00000'.$ID;
    case 3:
        $NP=$siglas.'0000'.$ID;
    case 4:
        $NP=$siglas.'000'.$ID;
    case 5:
        $NP=$siglas.'00'.$ID;
    case 6:
        $NP=$siglas.'0'.$ID;
    case 7:
        $NP=$siglas.''.$ID;
}

$Kuery_Update="UPDATE numero_permiso SET numero_permiso='$NP'  WHERE id=".$ID;
mysqli_query($con,$Kuery_Update);

}

			 if ($query_new_user_insert) {
				$messages[] = "Se Asigno Numero de Permiso  con Exito Folio ($folio).";
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

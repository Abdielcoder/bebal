<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
$ID_USER=$_SESSION['user_id'];


	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['idprincipal']) || 
	empty($_POST['id_giro']) || 
	empty($_POST['nombre_comercial_establecimiento'])
	) {

	if ( empty($_POST['nombre_comercial_establecimiento']) ) $errors[] = "Campo vacío -- nombre_comercial_establecimiento";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

$idprincipal=$_POST['idprincipal'];
$ID_GIRO=$_POST['id_giro'];
##
$sql_giroSOLICITADO="SELECT * FROM giro WHERE id=".$ID_GIRO;
$result_giroSOLICITADO = mysqli_query($con,$sql_giroSOLICITADO);
$rowP_giroSOLICITADO = mysqli_fetch_assoc($result_giroSOLICITADO);
$GIROsolicitado=$rowP_giroSOLICITADO['descripcion_giro'];
##

#####################
$sqlSelectPrincipal="SELECT * FROM principal WHERE id=".$idprincipal;
$rowP = mysqli_fetch_array(mysqli_query($con,$sqlSelectPrincipal));

$folioDB=$rowP['folio'];
$nombre_comercial_establecimientoDB=$rowP['nombre_comercial_establecimiento'];

$id_giroDB=$rowP['giro'];
$fecha_altaDB=$rowP['fecha_alta'];

##
$sql_giro="SELECT * FROM giro WHERE id=".$id_giroDB;
$result_giro = mysqli_query($con,$sql_giro);
$rowP_giro = mysqli_fetch_assoc($result_giro);
$GIROdb=$rowP_giro['descripcion_giro'];
##

$id_proceso_tramitesDB=$rowP['id_proceso_tramites'];
$id_tramiteDB=$rowP['id_tramite'];


$tramite_cambio="(".$nombre_comercial_establecimientoDB.", Giro ".$GIROdb." fecha Alta ".$fecha_altaDB." ) Actualizar Giro [ ".$ID_GIRO.", ".$GIROsolicitado." ] ";


#####################
###
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$NIPgenerado=substr(str_shuffle($permitted_chars),0,6);
###
#
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

############
############
## Numero de Permiso

$arregloSiglasGiro=mysqli_fetch_array(mysqli_query($con,"SELECT  siglas  FROM giro WHERE id=$ID_GIRO"));
$SIGLAS_GIRO=$arregloSiglasGiro[0];

################
$id_giro_siglas=$ID_GIRO.'-'.$SIGLAS_GIRO;

$arregloCuenta=mysqli_fetch_array(mysqli_query($con,"SELECT  COUNT(*)  FROM `numero_permiso` WHERE folio='$folioDB' AND id_giro_siglas='$id_giro_siglas'"));
$CUENTA=$arregloCuenta[0];
###############
##########
if ( $CUENTA>0 ) {
##echo 'El Folio ya cuenta con un Numero de permiso<br>';
} else {

################
$NP='';
##$siglas='E-'.$SIGLAS_GIRO.$SIGLAS_DELEGACION;
$siglas='E-'.$SIGLAS_GIRO;
###############
$sql_INSERT99="INSERT INTO numero_permiso (
folio,
id_principal,
user_id,
id_giro_siglas,
fecha ) VALUES (
'$folioDB',
$idprincipal,
$ID_USER,
'$id_giro_siglas',
'$today')";
$query_new_insert99 = mysqli_query($con,$sql_INSERT99);
if ($query_new_insert99) {
$arregloMaxid99 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `numero_permiso`"));
$IDNP=intval($arregloMaxid99[0]);

$tamano=strlen($IDNP);

##echo 'Tamano='.$tamano.'<br>';

switch ($tamano) {
    case 1:
        $NP=$siglas.'00000'.$IDNP;
        break;
    case 2:
        $NP=$siglas.'0000'.$IDNP;
            break;
    case 3:
        $NP=$siglas.'000'.$IDNP;
            break;
    case 4:
        $NP=$siglas.'00'.$IDNP;
            break;
    case 5:
        $NP=$siglas.'0'.$IDNP;
            break;
    case 6:
        $NP=$siglas.''.$IDNP;
            break;
}

$Kuery_Update99="UPDATE numero_permiso SET numero_permiso='$NP'  WHERE id=".$IDNP;
mysqli_query($con,$Kuery_Update99);

}
}
################
###
##########
$sql_UpdatePrincipal="UPDATE principal SET 
giro=$ID_GIRO,
estatus='Permiso Autorizado',
operacion='Activo', 
numero_permiso='$NP',
nip='$NIPgenerado' 
WHERE id=".$idprincipal;

$query_UpdatePrincipal = mysqli_query($con,$sql_UpdatePrincipal);

##

$Kuery_Update2="UPDATE proceso_tramites SET fecha_fin='$today', numero_permiso='$NP', en_proceso='Fin', el_cambio='$tramite_cambio'  WHERE id=".$id_proceso_tramitesDB;

mysqli_query($con,$Kuery_Update2);



if ($query_UpdatePrincipal) {



				$messages[] = "El Registro ha sido  Actuaizado Exito Folio ($folioDB)";
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

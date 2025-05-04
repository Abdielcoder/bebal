<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['idprincipal']) || 
	empty($_POST['nombre_persona_fisicamoral_solicitante']) || 
	empty($_POST['nombre_representante_legal_solicitante'])
	) {

	if ( empty($_POST['nombre_persona_fisicamoral_solicitante']) ) $errors[] = "Campo vacío -- nombre_persona_fisicamoral_solicitante";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

$idprincipal=$_POST['idprincipal'];

#####################
$sqlSelectPrincipal="SELECT * FROM principal WHERE id=".$idprincipal;
$rowP = mysqli_fetch_array(mysqli_query($con,$sqlSelectPrincipal));


$folioDB=$rowP['folio'];

##$nombre_comercial_establecimientoDB=$rowP['nombre_comercial_establecimiento'];

##$id_giroDB=$rowP['giro'];
##
##$sql_giro="SELECT * FROM giro WHERE id=".$id_giroDB;
##$result_giro = mysqli_query($con,$sql_giro);
##$rowP_giro = mysqli_fetch_assoc($result_giro);
##$GIROdb=$rowP_giro['descripcion_giro'];
##

##$fecha_altaDB=$rowP['fecha_alta'];

##$id_proceso_tramitesDB=$rowP['id_proceso_tramites'];
##$id_tramiteDB=$rowP['id_tramite'];

##$nombre_persona_fisicamoral_solicitanteDB=$rowP['nombre_persona_fisicamoral_solicitante'];
##$nombre_representante_legal_solicitanteDB=$rowP['nombre_representante_legal_solicitante'];
##$domicilio_solicitanteDB=$rowP['domicilio_solicitante'];
##$email_solicitanteDB=$rowP['email_solicitante'];
##$telefono_solicitanteDB=$rowP['telefono_solicitante'];
##$rfcDB=$rowP['rfc'];
##$fisica_o_moralDB=$rowP['fisica_o_moral'];
################


##$tramite_cambio="(".$nombre_comercial_establecimientoDB.", Folio (".$folioDB.")  Giro ".$GIROdb." fecha Alta ".$fecha_altaDB." ) TITULAR [[ (".$fisica_o_moralDB.") ".$nombre_persona_fisicamoral_solicitanteDB.", Representante Legal ".$nombre_representante_legal_solicitanteDB." Domicilio ".$domicilio_solicitanteDB." RFC ".$rfcDB." Email ".$email_solicitanteDB." Telefono ".$telefono_solicitanteDB." ]] ";


#####################

$rfc_solicitante=$_POST['rfc_solicitante'];
$fisica_o_moral=$_POST['mod_fisica_o_moral'];

$nombre_persona_fisicamoral_solicitante=strtoupper($_POST['nombre_persona_fisicamoral_solicitante']);
$nombre_representante_legal_solicitante=strtoupper($_POST['nombre_representante_legal_solicitante']);
$domicilio_solicitante=strtoupper($_POST['domicilio_solicitante']);
$email_solicitante=$_POST['email_solicitante'];
$telefono_solicitante=$_POST['telefono_solicitante'];

###
##$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
##$NIPgenerado=substr(str_shuffle($permitted_chars),0,6);
###
#
##date_default_timezone_set('America/Los_Angeles');
##$today = date("Y-m-d");

################
###
##########
$sql_UpdatePrincipal="UPDATE principal SET 
nombre_persona_fisicamoral_solicitante='$nombre_persona_fisicamoral_solicitante',
nombre_representante_legal_solicitante='$nombre_representante_legal_solicitante',
domicilio_solicitante='$domicilio_solicitante',
email_solicitante='$email_solicitante',
telefono_solicitante= '$telefono_solicitante',
rfc='$rfc_solicitante',
fisica_o_moral='$fisica_o_moral' 
WHERE id=".$idprincipal;

$query_UpdatePrincipal = mysqli_query($con,$sql_UpdatePrincipal);


##

mysqli_close($con);

if ($query_UpdatePrincipal) {


				$messages[] = "El Registro ha sido Actualizado Exito Folio ($folioDB)";
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

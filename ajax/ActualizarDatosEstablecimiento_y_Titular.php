<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['idprincipal']) || 
	empty($_POST['calle_establecimiento']) || 
	empty($_POST['clave_catastral'])
	) {

	if ( empty($_POST['clave_catastral']) ) $errors[] = "Campo vacío -- clave_catastral";
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
$clave_catastralDB=$rowP['clave_catastral'];
$nombre_comercial_establecimientoDB=$rowP['nombre_comercial_establecimiento'];
$calle_establecimientoDB=$rowP['calle_establecimiento'];
$entre_calles_establecimientoDB=$rowP['entre_calles_establecimiento'];
$numero_establecimientoDB=$rowP['numero_establecimiento'];
$numerointerno_local_establecimientoDB=$rowP['numerointerno_local_establecimiento'];
$cp_establecimientoDB=$rowP['cp_establecimiento'];
$superficie_establecimientoDB=$rowP['superficie_establecimiento'];
$capacidad_comensales_personasDB=$rowP['capacidad_comensales_personas'];

$id_giroDB=$rowP['giro'];
$id_municipioDB=$rowP['id_municipio'];
$delegacion_idDB=$rowP['id_delegacion'];
$colonia_idDB=$rowP['id_colonia'];

##
$sql_giro="SELECT * FROM giro WHERE id=".$id_giroDB;
$result_giro = mysqli_query($con,$sql_giro);
$rowP_giro = mysqli_fetch_assoc($result_giro);
$GIROdb=$rowP_giro['descripcion_giro'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipioDB;
$result_municipio = mysqli_query($con,$sql_municipio);
$rowP_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIOdb=$rowP_municipio['municipio'];
##
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$delegacion_idDB;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$rowP_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACIONdb=$rowP_delegacion['delegacion'];
##
$sql_colonia="SELECT colonia FROM colonias WHERE id=".$colonia_idDB;
$result_colonia = mysqli_query($con,$sql_colonia);
$rowP_colonia = mysqli_fetch_assoc($result_colonia);
$COLONIAdb=$rowP_colonia['colonia'];
##

$fecha_altaDB=$rowP['fecha_alta'];
$observacionesDB=$rowP['observaciones'];

$id_proceso_tramitesDB=$rowP['id_proceso_tramites'];
$id_tramiteDB=$rowP['id_tramite'];

$nombre_persona_fisicamoral_solicitanteDB=$rowP['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitanteDB=$rowP['nombre_representante_legal_solicitante'];
$domicilio_solicitanteDB=$rowP['domicilio_solicitante'];
$email_solicitanteDB=$rowP['email_solicitante'];
$telefono_solicitanteDB=$rowP['telefono_solicitante'];
$rfcDB=$rowP['rfc'];
$fisica_o_moralDB=$rowP['fisica_o_moral'];
################


$tramite_cambio="(".$nombre_comercial_establecimientoDB.", Giro ".$GIROdb." fecha Alta ".$fecha_altaDB." ) Direccion Establecimiento [[Número Catastro ".$clave_catastralDB.", ".$calle_establecimientoDB." ".$numero_establecimientoDB." ".$numerointerno_local_establecimientoDB." Entre Calles ".$entre_calles_establecimientoDB." CP ".$cp_establecimientoDB." Delegación ".$DELEGACIONdb." Colonia ".$COLONIAdb." (( ".$MUNICIPIOdb." ))  Capacidad Comensales ".$capacidad_comensales_personasDB." Superficie ".$superficie_establecimientoDB." ]] TITULAR [[ (".$fisica_o_moralDB.") ".$nombre_persona_fisicamoral_solicitanteDB.", Representante Legal ".$nombre_representante_legal_solicitanteDB." Domicilio ".$domicilio_solicitanteDB." RFC ".$rfcDB." Email ".$email_solicitanteDB." Telefono ".$telefono_solicitanteDB." ]]  Observaciones [[ ".$observacionesDB." ]]";


#####################
$id_delegacion=$_POST['id_delegacion'];
$id_colonia=$_POST['mod_id_colonia'];

$rfc_solicitante=$_POST['rfc_solicitante'];
$fisica_o_moral=$_POST['mod_fisica_o_moral'];

$capacidad_comensales_personas=$_POST['capacidad_comensales_personas'];
$superficie_establecimiento=$_POST['superficie_establecimiento'];

// escaping, additionally removing everything that could be (html/javascript-) code
$observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)));
$clave_catastral=strtoupper($_POST['clave_catastral']);

##$nombre_comercial_establecimiento=strtoupper($_POST['nombre_comercial_establecimiento']);
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
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$NIPgenerado=substr(str_shuffle($permitted_chars),0,6);
###
#
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

################
###
##########
$sql_UpdatePrincipal="UPDATE principal SET 
id_municipio=$ID_MUNICIPIO, id_delegacion=$id_delegacion, id_colonia=$id_colonia,
estatus='Permiso Autorizado',
operacion='Activo',
clave_catastral='$clave_catastral',
calle_establecimiento='$calle_establecimiento',
entre_calles_establecimiento='$entre_calles_establecimiento',
numero_establecimiento='$numero_establecimiento',
numerointerno_local_establecimiento='$numerointerno_local_establecimiento',
cp_establecimiento='$cp_establecimiento',
capacidad_comensales_personas=$capacidad_comensales_personas,
superficie_establecimiento=$superficie_establecimiento,
nombre_persona_fisicamoral_solicitante='$nombre_persona_fisicamoral_solicitante',
nombre_representante_legal_solicitante='$nombre_representante_legal_solicitante',
domicilio_solicitante='$domicilio_solicitante',
email_solicitante='$email_solicitante',
telefono_solicitante= '$telefono_solicitante',
rfc='$rfc_solicitante',
fisica_o_moral='$fisica_o_moral',
observaciones= '$observaciones',
nip='$NIPgenerado' 
WHERE id=".$idprincipal;

$query_UpdatePrincipal = mysqli_query($con,$sql_UpdatePrincipal);


##

$Kuery_Update2="UPDATE proceso_tramites SET fecha_fin='$today', en_proceso='Fin', el_cambio='$tramite_cambio'  WHERE id=".$id_proceso_tramitesDB;

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

<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id'])) {
           $errors[] = "Campo vacío";
		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

$id=intval($_POST['id']);
$page = intval($_POST['page']);

#######################
$rfc_solicitante=$_POST['rfc_solicitante'];
$fisica_o_moral=$_POST['fisica_o_moral'];

$nombre_persona_fisicamoral_solicitante=strtoupper($_POST['nombre_persona_fisicamoral_solicitante']);
$nombre_representante_legal_solicitante=strtoupper($_POST['nombre_representante_legal_solicitante']);
$domicilio_solicitante=strtoupper($_POST['domicilio_solicitante']);
$email_solicitante=$_POST['email_solicitante'];
$telefono_solicitante=$_POST['telefono_solicitante'];
$observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)));

#######################

if (!isset($_POST['TRAMITES']) || empty($_POST['TRAMITES'])) {
$MODALIDAD_GA='';
$cuentaMGA=0;
} else {
$MODALIDAD_GA=$_POST['TRAMITES'];

##$monto_umas_total_modalidad_graduacion_alcoholica=0;
$TRAMITE_LISTA='';
$TRAMITE_LISTA_CONCEPTO_RECAUDACION='';
$TRAMITES_RAW='';
$cuentaMGA=count($MODALIDAD_GA);

if ( $cuentaMGA==1 ) {
#########
$TRAMITES_RAW=$MODALIDAD_GA[0];
#
$porciones0 = explode("**", $MODALIDAD_GA[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
##$monto_umas_total_modalidad_graduacion_alcoholica=$e02;
$TRAMITE_LISTA='('.$e01.')';
$TRAMITE_LISTA_CONCEPTO_RECAUDACION=','.$e01;
#
#########
} else {

if ( $cuentaMGA==2 ) {
#################
$TRAMITES_RAW=$MODALIDAD_GA[0].'--'.$MODALIDAD_GA[1];
#
$porciones0 = explode("**", $MODALIDAD_GA[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
#
$porciones1 = explode("**", $MODALIDAD_GA[1]);
$e10=$porciones1[0];
$e11=$porciones1[1];
$e12=$porciones1[2];
##$monto_umas_total_modalidad_graduacion_alcoholica=$e02+$e12;
$TRAMITE_LISTA='('.$e01.') y ('.$e11.')';
$TRAMITE_LISTA_CONCEPTO_RECAUDACION=','.$e01.','.$e11;
#
#################
} else {

$TRAMITES_RAW=$MODALIDAD_GA[0];
#
$porciones0 = explode("**", $MODALIDAD_GA[0]);
$e00=$porciones0[0];
$e01=$porciones0[1];
$e02=$porciones0[2];
##$monto_umas_total_modalidad_graduacion_alcoholica=$e02;
$TRAMITE_LISTA='('.$e01.')';
$TRAMITE_LISTA_CONCEPTO_RECAUDACION=','.$e01;
#



for($i = 1; $i<$cuentaMGA-1; $i++) {

$TRAMITES_RAW .= '--'.$MODALIDAD_GA[$i];

$porcionesi = explode("**", $MODALIDAD_GA[$i]);
$ei0=$porcionesi[0];
$ei1=$porcionesi[1];
$ei2=$porcionesi[2];
##$monto_umas_total_modalidad_graduacion_alcoholica=$ei2+$monto_umas_total_modalidad_graduacion_alcoholica;
#

$TRAMITE_LISTA.=', ('.$ei1.')';
$TRAMITE_LISTA_CONCEPTO_RECAUDACION.=','.$ei1;
}


$TRAMITES_RAW .= ' --'.$MODALIDAD_GA[$cuentaMGA-1];
$porcionesu = explode("**", $MODALIDAD_GA[$cuentaMGA-1]);
$eu0=$porcionesu[0];
$eu1=$porcionesu[1];
$eu2=$porcionesu[2];
##$monto_umas_total_modalidad_graduacion_alcoholica=$eu2+$monto_umas_total_modalidad_graduacion_alcoholica;

$TRAMITE_LISTA .= ' Y ('.$eu1.')';
$TRAMITE_LISTA_CONCEPTO_RECAUDACION .= ','.$eu1;
}
}




}
#####################
$today = date("Y-m-d");
##echo 'TRAMITE_LISTA='.$TRAMITE_LISTA;

$sql_insert = "INSERT INTO presupuesto (
id_principal,
tramites,
tramites_raw,
tramites_concepto_recaudacion,
rfc,
fisica_o_moral,
observaciones,
nombre_persona_fisicamoral_solicitante,
nombre_representante_legal_solicitante,
domicilio_solicitante,
email_solicitante,
telefono_solicitante,
fecha_alta,
estatus
) VALUES (
$id,
'$TRAMITE_LISTA',
'$TRAMITES_RAW ',
'$TRAMITE_LISTA_CONCEPTO_RECAUDACION ',
'$rfc_solicitante',
'$fisica_o_moral',
'$observaciones',
'$nombre_persona_fisicamoral_solicitante',
'$nombre_representante_legal_solicitante',
'$domicilio_solicitante',
'$email_solicitante',
'$telefono_solicitante',
'$today',
'Inicio'
)";

##echo $sql_insert;

$query_insert=mysqli_query($con,$sql_insert);

######################
######################
$sql_Cuenta_Paso="SELECT COUNT(*) CUENTA_PASO FROM de_paso WHERE id_principal=$id";
$result_CuentaPaso=mysqli_query($con,$sql_Cuenta_Paso);
$row_cuentaPaso = mysqli_fetch_assoc($result_CuentaPaso);
$CUENTA_PASO=$row_cuentaPaso['CUENTA_PASO'];
if ( $CUENTA_PASO>0 ) {
$sql_Paso="SELECT * FROM de_paso WHERE id_principal=$id";
$result_Paso=mysqli_query($con,$sql_Paso);
$row_Paso = mysqli_fetch_assoc($result_Paso);
$NUMERO_PERMISO_ANTERIOR=$row_Paso['numero_permiso'];
} else {
$NUMERO_PERMISO_ANTERIOR='No Disponible';
}
######################
######################
// Consultar datos del establecimiento
$sql = "SELECT p.*,
        g.descripcion_giro AS giro_desc,
        g.horario_funcionamiento AS horario_funcionamiento,
        mu.municipio AS municipio_desc,
        d.delegacion AS delegacion_desc,
        c.colonia AS colonia_desc
        FROM principal p
        LEFT JOIN giro g ON p.giro = g.id
        LEFT JOIN municipio mu ON p.id_municipio = mu.id
        LEFT JOIN delegacion d ON p.id_delegacion = d.id
        LEFT JOIN colonias c ON p.id_colonia = c.id
        WHERE p.id = " . $id;

$resultado = mysqli_query($con, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("Error: No se encontró el registro solicitado");
}

$datos = mysqli_fetch_assoc($resultado);


if ( $datos['calle_establecimiento']=='' || $datos['calle_establecimiento']==NULL || empty($datos['calle_establecimiento']) ) {
$domicilio_establecimiento='NA';
} else {
$domicilio_establecimiento=$datos['calle_establecimiento'].' '.$datos['numero_establecimiento'];
}


if ( $datos['clave_catastral']=='' || $datos['clave_catastral']==NULL || empty($datos['clave_catastral'])) {
$clave_catastral='NA';
} else {
$clave_catastral=$datos['clave_catastral'];
}

###
if ( $datos['capacidad_comensales_personas']=='' || empty($datos['capacidad_comensales_personas']) ) {
$CAPACIDAD_COMENSALES_PERSONAS='NA';
} else {
$CAPACIDAD_COMENSALES_PERSONAS=$datos['capacidad_comensales_personas'].' Personas';
}
###
if ( $datos['superficie_establecimiento']=='' || empty($datos['superficie_establecimiento']) ) {
$SUPERFICIE_ESTABLECIMIENTO='NA';
} else {
$SUPERFICIE_ESTABLECIMIENTO=$datos['superficie_establecimiento'].' (m²)';
}
###
$GRUPO4=$CAPACIDAD_COMENSALES_PERSONAS.' / '.$SUPERFICIE_ESTABLECIMIENTO;
###

$colonia_delegacion_municipio_establecimiento=$datos['colonia_desc'].' '.$datos['delegacion_desc'].' / '.$datos['municipio_desc'].' / '.$datos['cp_establecimiento'];


$url = "https://landingbebal-production.up.railway.app/api/datorapido";

$data = [
    "folio" => $datos['folio'],
    "giro" => $datos['giro_desc'],
    "modalidad_graduacion_alcoholica" => $datos['modalidad_graduacion_alcoholica'],
    "servicios_adicionales" => $datos['servicios_adicionales'],
    "numero_servicios_adicionales" => $datos['numero_servicios_adicionales'],
    "fecha_registro" => $datos['fecha_alta'],
    "nombre_comercial" => $datos['nombre_comercial_establecimiento'],
    "domicilio" => $domicilio_establecimiento,
    "colonia_delegacion_ciudad_cp" => $colonia_delegacion_municipio_establecimiento,
    "clave_catastral" => $clave_catastral,
    "comensales_superficie" => $GRUPO4,
    "horario_funcionamiento" => $datos['horario_funcionamiento'],
    "tramites_presupuesto"=> $TRAMITES_PRESUPUESTO,
    "rfc_solicitante"=> $RFC,
"fisica_o_moral_solicitante"=> $FISICA_O_MORAL,
"nombre_persona_fisicamoral_solicitante"=> $NOMBRE_PERSONA_FISICAMORAL_SOLICITANTE,
"nombre_representante_legal_solicitante"=> $NOMBRE_REPRESENTANTE_SOLICITANTE,
"domicilio_solicitante"=> $DOMICILIO_SOLICITANTE,
"email_solicitante"=> $EMAIL_SOLICITANTE,
"telefono_solicitante"=> $TELEFONO_SOLICITANTE,
"numero_permiso_anterior"=> $NUMERO_PERMISO_ANTERIOR,
"numero_permiso_nuevo"=> $datos['numero_permiso']

];

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    // Manejo de error
    echo "Error al consumir la API";
} else {
    // Respuesta de la API
    ##echo $result;
}

######################
###
mysqli_close($con);



			if ($query_insert) {
				$messages[] = "Se Agregaron los Datos Para la Constancia";
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

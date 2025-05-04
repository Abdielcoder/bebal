<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
$ID_USER=$_SESSION['user_id'];

	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['numero_mesas_de_billar']) || 
	empty($_POST['conjunto_musicales']) || 
	empty($_POST['espectaculos_artisticos'])
	) {

	if ( empty($_POST['conjunto_musicales']) ) $errors[] = "Campo vacío -- conjunto musicales";
	else $errors[] = "Campo vacío";


		} else {
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");

date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");
#####################
###########################
## SERVICIOS ADICIONALES
###########################
$SERVICIOS_ADICIONALES_LISTA='';
$cuentaSA=0;
$monto_umas_total_servicios_adicionales=0;
#
###############
$idprincipal=$_POST['idprincipal'];
$id_proceso_tramites=$_POST['id_proceso_tramites'];
$folio=$_POST['folio'];
$ID_TRAMITE=$_POST['id_tramite'];

$numero_mesas_de_billar=$_POST['numero_mesas_de_billar'];
$pista_de_baile=$_POST['pista_de_baile'];
$musica_grabada_y_aparatos=$_POST['musica_grabada_y_aparatos'];
$conjunto_musicales=$_POST['conjunto_musicales'];
$espectaculos_artisticos=$_POST['espectaculos_artisticos'];
###############
if ( $numero_mesas_de_billar=='Zero' && $pista_de_baile=='Zero' && $musica_grabada_y_aparatos=='Zero' && $conjunto_musicales=='Zero' && $espectaculos_artisticos=='Zero' ) {
$SERVICIOS_ADICIONALES_LISTA='0';
$cuentaSA=0;
$monto_umas_total_servicios_adicionales=0;
} else {
	if ( $numero_mesas_de_billar!='Zero' ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( '.$numero_mesas_de_billar.' Mesa(s) de Billar ) ';
	$cuentaSA++;
	} else $numero_mesas_de_billar=0;
	#
	if ( $pista_de_baile==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Pista de Baile ) ';
	$cuentaSA++;
	} else $pista_de_baile=0;
	#
	if ( $musica_grabada_y_aparatos==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Musica Grabada y Aparatos Musicales ) ';
	$cuentaSA++;
	} else $musica_grabada_y_aparatos=0;
	#
	if ( $conjunto_musicales==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Conjunto Musicales ) ';
	$cuentaSA++;
	} else $conjunto_musicales=0;
	#
	if ( $espectaculos_artisticos==1 ) {
	$SERVICIOS_ADICIONALES_LISTA.=' ( Espectaculos Artisticos ) ';
	$cuentaSA++;
	} else $espectaculos_artisticos=0;
#
$arregloSA_musica_grabada_y_aparatos=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Musica Grabada y Aparatos Musicales'"));
$umas_musica_grabada_y_aparatos=$arregloSA_musica_grabada_y_aparatos[0];
$monto_musica_grabada_y_aparatos=$umas_musica_grabada_y_aparatos*$musica_grabada_y_aparatos;
#
$arregloSA_numero_mesas_de_billar=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Mesas de Billar, por cada Mesa'"));
$umas_numero_mesas_de_billar=$arregloSA_numero_mesas_de_billar[0];
$monto_numero_mesas_de_billar=$umas_numero_mesas_de_billar*$numero_mesas_de_billar;
#
$arregloSA_pista_de_baile=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Pista de Baile'"));
$umas_pista_de_baile=$arregloSA_pista_de_baile[0];
$monto_pista_de_baile=$umas_pista_de_baile*$pista_de_baile;
#
$arregloSA_conjunto_musicales=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Conjunto Musicales'"));
$umas_conjunto_musicales=$arregloSA_conjunto_musicales[0];
$monto_conjunto_musicales=$umas_conjunto_musicales*$conjunto_musicales;
#
$arregloSA_espectaculos_artisticos=mysqli_fetch_array(mysqli_query($con,"SELECT monto_umas  FROM `servicios_adicionales` WHERE descripcion_servicios_adicionales='Espectaculos Artisticos'"));
$umas_espectaculos_artisticos=$arregloSA_espectaculos_artisticos[0];
$monto_espectaculos_artisticos=$umas_espectaculos_artisticos*$espectaculos_artisticos;
##
$monto_umas_total_servicios_adicionales=$monto_musica_grabada_y_aparatos+$monto_numero_mesas_de_billar+$monto_pista_de_baile+$monto_conjunto_musicales+$monto_espectaculos_artisticos;
}
#
###########################
###########################

$el_cambio="Tramite Servicios Adicionales (".$today.") [[".$SERVICIOS_ADICIONALES_LISTA."]]";

##########################
### SERVICIOS ADICIONALES

if ( $SERVICIOS_ADICIONALES_LISTA=='0' ) {
$Kuery_SAP="INSERT INTO servicios_adicionales_permisionario (
id_principal,
id_proceso_tramites,
folio,
musica_grabada_y_aparatos,
monto_musica_grabada_y_aparatos,
conjunto_musicales,
monto_conjunto_musicales,
mesas_de_billar,
monto_mesas_de_billar,
espectaculos_artisticos,
monto_espectaculos_artisticos,
pista_de_baile,
monto_pista_de_baile,
fecha
) VALUES (
$idprincipal,
$id_proceso_tramites,
'$folio',
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
'$today')";

} else {

$Kuery_SAP="INSERT INTO servicios_adicionales_permisionario (
id_principal,
id_proceso_tramites,
folio,
musica_grabada_y_aparatos,
monto_musica_grabada_y_aparatos,
conjunto_musicales,
monto_conjunto_musicales,
mesas_de_billar,
monto_mesas_de_billar,
espectaculos_artisticos,
monto_espectaculos_artisticos,
pista_de_baile,
monto_pista_de_baile,
fecha
) VALUES (
$idprincipal,
$id_proceso_tramites,
'$folio',
$musica_grabada_y_aparatos,
$monto_musica_grabada_y_aparatos,
$conjunto_musicales,
$monto_conjunto_musicales,
$numero_mesas_de_billar,
$monto_numero_mesas_de_billar,
$espectaculos_artisticos,
$monto_espectaculos_artisticos,
$pista_de_baile,
$monto_pista_de_baile,
'$today')";
}

mysqli_query($con,$Kuery_SAP);

####
$arregloMaxid3 = mysqli_fetch_array(mysqli_query($con,"SELECT max(`id`) FROM `servicios_adicionales_permisionario`"));
$ID_SERVICIOS_ADICIONALES_PERMISIONARIO=$arregloMaxid3[0];

#######################
##########
$sql_UpdatePrincipal="UPDATE principal SET
id_servicios_adicionales_permisionario=$ID_SERVICIOS_ADICIONALES_PERMISIONARIO, 
id_tramite=$ID_TRAMITE, 
id_proceso_tramites=$id_proceso_tramites,
servicios_adicionales='$SERVICIOS_ADICIONALES_LISTA',
numero_servicios_adicionales=$cuentaSA,
monto_umas_total_servicios_adicionales='$monto_umas_total_servicios_adicionales',
estatus='Permiso Autorizado',
operacion='Activo'
WHERE id=".$idprincipal;
$query_UpdatePrincipal = mysqli_query($con,$sql_UpdatePrincipal);
##
$Kuery_Update2="UPDATE proceso_tramites SET fecha_fin='$today', en_proceso='Fin', el_cambio='$el_cambio'  WHERE id=".$id_proceso_tramites;
$query_Update2 = mysqli_query($con,$Kuery_Update2);
################

if ($query_UpdatePrincipal) {



				$messages[] = "Se Registro  Los Servicios Adicionales Folio ($folio).";
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

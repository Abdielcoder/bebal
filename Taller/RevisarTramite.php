<?php

/* Connect To Database*/
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
include("../funciones.php");

$id=$_GET['id'];

#####################
$sqlSelectPrincipal="SELECT * FROM principal WHERE id=".$id;
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


$nombre_persona_fisicamoral_solicitanteDB=$rowP['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitanteDB=$rowP['nombre_representante_legal_solicitante'];
$domicilio_solicitanteDB=$rowP['domicilio_solicitante'];
$email_solicitanteDB=$rowP['email_solicitante'];
$telefono_solicitanteDB=$rowP['telefono_solicitante'];
$rfcDB=$rowP['rfc'];
$fisica_o_moralDB=$rowP['fisica_o_moral'];
################
$id_proceso_tramitesDB=$rowP['id_proceso_tramites'];
$id_tramiteDB=$rowP['id_tramite'];
###############

$tramite_cambio="(".$nombre_comercial_establecimientoDB.", Giro ".$GIROdb." fecha Alta ".$fecha_altaDB." ) Direccion Establecimiento [[Número Catastro ".$clave_catastralDB.", ".$calle_establecimientoDB." ".$numero_establecimientoDB." ".$numerointerno_local_establecimientoDB." Entre Calles ".$entre_calles_establecimientoDB." CP ".$cp_establecimientoDB." Delegación ".$DELEGACIONdb." Colonia ".$COLONIAdb." (( ".$MUNICIPIOdb." ))  Capacidad Comensales ".$capacidad_comensales_personasDB." Superficie ".$superficie_establecimientoDB." ]] TITULAR [[ (".$fisica_o_moralDB.") ".$nombre_persona_fisicamoral_solicitanteDB.", Representante Legal ".$nombre_representante_legal_solicitanteDB." Domicilio ".$domicilio_solicitanteDB." RFC ".$rfcDB." Email ".$email_solicitanteDB." Telefono ".$telefono_solicitanteDB." ]]  Observaciones [[ ".$observacionesDB." ]]";


#####################
date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");

echo $today.'<br>';
echo $tramite_cambio.'<br>';
echo '%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%<br>';

################
$KueryPT="SELECT * FROM proceso_tramites WHERE id_principal=$id AND id=$id_proceso_tramitesDB";
##echo $KueryPT;
$arregloPT = mysqli_fetch_array(mysqli_query($con,$KueryPT));

$en_proceso=$arregloPT['en_proceso'];
$fecha_inicio=$arregloPT['fecha_inicio'];
$fecha_fin=$arregloPT['fecha_fin'];
$nota=$arregloPT['nota'];
$el_cambio=$arregloPT['el_cambio'];

$docs_pdf1DB=$arregloPT['docs_pdf1'];
$estatus_docs_pdf1DB=$arregloPT['estatus_docs_pdf1'];
##
$docs_pdf2DB=$arregloPT['docs_pdf2'];
$estatus_docs_pdf2DB=$arregloPT['estatus_docs_pdf2'];
##
$docs_pdf3DB=$arregloPT['docs_pdf3'];
$estatus_docs_pdf3DB=$arregloPT['estatus_docs_pdf3'];
##
$docs_pdf4DB=$arregloPT['docs_pdf4'];
$estatus_docs_pdf4DB=$arregloPT['estatus_docs_pdf4'];
##echo $KueryPT_FINALIZADO.'(('.$cuentaFINALIZADO.'))<br>';
##############################
echo '<font color="red">proceso_tramites</font> en_proceso(<font color="blue">'.$en_proceso.'</font>) fecha_inicio (<font color="blue">'.$fecha_inicio.'</font>) fecha_fin (<font color="blue">'.$fecha_fin.'</font>) nota (<font color="blue">'.$nota.'</font>) el_cambio (<font color="blue">'.$el_cambio.'</font>) '  ;

################
##$KueryPT_FINALIZADO= "SELECT COUNT(*)  AS cuentaFINALIZADO FROM recepcion_analisis_documentos WHERE en_proceso='FIN' AND id_principal=$id AND id_proceso_tramites=$id_proceso_tramites";
##$arregloPT_FINALIZADO = mysqli_fetch_array(mysqli_query($con,$KueryPT_FINALIZADO));
##$cuentaFINALIZADO=$arregloPT_FINALIZADO['cuentaFINALIZADO'];
################


echo '<br>$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>';
echo '$$$$$$$$$   P A G O S   <br>';

$sql_Pagos="SELECT * FROM pagos WHERE id_principal=$id AND id_proceso_tramites=".$id_proceso_tramitesDB;
##echo $sql_Pagos.'<br>';
$resultPagos = mysqli_query($con,$sql_Pagos);
$total_resultPagos = mysqli_num_rows($resultPagos);

for ($i = 0; $i < $total_resultPagos; $i++) {
$ROW_resultPagos= mysqli_fetch_array($resultPagos,MYSQLI_NUM);

$id_pago = $ROW_resultPagos[0];
$numero_pago = $ROW_resultPagos[4];
$monto = $ROW_resultPagos[5];
$total_umas_pagar = $ROW_resultPagos[6];
$estatus_pago = $ROW_resultPagos[8];
$concepto_pago = $ROW_resultPagos[9];
$concepto = $ROW_resultPagos[7];
$fecha_pago = $ROW_resultPagos[10];

echo 'id_pago='.$id_pago.'  <font color="red">PAGO </font> monto='.$monto.', fecha pago ('.$fecha_pago.')  estatus pago <font color="blue">'.$concepto.', '.$estatus_pago.'</font>, Total UMAS a Pagar '.$total_umas_pagar.' concepto_pago='.$concepto_pago.'<br>';

}
echo '<br>$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>';
echo '$$$$$$  recepcion_analisis_documentos  <br>';

$RAD="SELECT * FROM recepcion_analisis_documentos WHERE  id_principal=$id AND id_proceso_tramites=".$id_proceso_tramitesDB;
##echo $RAD;
$arregloRAD = mysqli_fetch_array(mysqli_query($con,$RAD));
$en_proceso=$arregloPT['en_proceso'];
$fecha_inicio=$arregloPT['fecha_inicio'];
$fecha_fin=$arregloPT['fecha_fin'];

echo 'Tarea  recepcion_analisis_documentos  <font color="blue">'.$en_proceso.'</font> fecha_inicio='.$fecha_inicio.' fecha_fin='.$fecha_fin;

echo '<br>$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$<br>';
echo '$$$$$$  inspeccion  <br>';
$INS="SELECT * FROM inspeccion WHERE  id_principal=$id AND id_proceso_tramites=".$id_proceso_tramitesDB;
##echo $INS;
$arregloINS = mysqli_fetch_array(mysqli_query($con,$INS));
$en_proceso=$arregloINS['en_proceso'];
$fecha_inicio=$arregloINS['fecha_inicio'];
$fecha_fin=$arregloINS['fecha_fin'];

echo 'Tarea INSPECCION  <font color="blue">'.$en_proceso.'</font> fecha_inicio='.$fecha_inicio.' fecha_fin='.$fecha_fin;
?>

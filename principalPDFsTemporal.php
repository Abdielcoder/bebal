<!DOCTYPE html>
<html lang="en">

<?php
include('ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado


?>

<style>


input[type=submit] {
 padding: 5px 15px;
 background: #AC905B;
 border: 0 none;
 cursor: pointer;
 -webkit-border-radius: 5px;
border-radius: 5px;
}

.choose::-webkit-file-upload-button {
  color: white;
  display: inline-block;
  background: #AC905B;
  border: none;
  padding: 7px 15px;
  font-weight: 700;
  border-radius: 3px;
  white-space: nowrap;
  cursor: pointer;
  font-size: 10pt;
}


</style>

<?php
error_reporting(1);
session_start();

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$active_principal="active";
	$active_clientes="";
	$active_usuarios="";	
	$active_reportes="";


	$title="bebal";
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];


	include("modal/pdf_modal_ct1.php"); // Modal para cargar PDFs
	include("modal/pdf_modal_ct2.php"); // Modal para cargar PDFs
	include("modal/pdf_modal_ct3.php"); // Modal para cargar PDFs
	include("modal/pdf_modal_ct4.php"); // Modal para cargar PDFs


?>


  <head>


    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
<div class="container">
<?php

#################################
if (isset($_GET['id'])) {
$IDPRINCIPAL=$_GET['id'];
$page=$_GET['page'];
} else {
$IDPRINCIPAL=$_POST['IDPRINCIPAL'];
$page=$_POST['page'];
}

#################################
#################################

#################################
#################################
// move_uploaded_file
if (isset($_POST['subirnuevoPDF1']) || isset($_POST['subirnuevoPDF2']) || isset($_POST['subirnuevoPDF3']) || isset($_POST['subirnuevoPDF4']) ) {

$IDPRINCIPAL=$_POST["IDPRINCIPAL"];
$MAX_FILE_SIZE=$_POST["MAX_FILE_SIZE"];
$page=$_POST["page"];
$ID_TRAMITE=$_POST["ID_TRAMITE"];
$ID_PROCESO_TRAMITES=$_POST["ID_PROCESO_TRAMITES"];


if (isset($_POST['subirnuevoPDF1'])) $conjunto=$_POST["conjuntoc1"];
if (isset($_POST['subirnuevoPDF2'])) $conjunto=$_POST["conjuntoc2"];
if (isset($_POST['subirnuevoPDF3'])) $conjunto=$_POST["conjuntoc3"];
if (isset($_POST['subirnuevoPDF4'])) $conjunto=$_POST["conjuntoc4"];


switch ($conjunto) {
  case 'c1':
$archivoType=$_FILES["nuevoPDF1"]['type'];
$archivoSize=$_FILES["nuevoPDF1"]['size'];
$archivoTMP=$_FILES["nuevoPDF1"]['tmp_name'];
$column1_Update=$_POST["column1_Updatec1"];
$column2_Update=$_POST["column2_Updatec1"];
    break;
  case 'c2':
$archivoType=$_FILES["nuevoPDF2"]['type'];
$archivoSize=$_FILES["nuevoPDF2"]['size'];
$archivoTMP=$_FILES["nuevoPDF2"]['tmp_name'];
$column1_Update=$_POST["column1_Updatec2"];
$column2_Update=$_POST["column2_Updatec2"];
    break;
  case 'c3':
$archivoType=$_FILES["nuevoPDF3"]['type'];
$archivoSize=$_FILES["nuevoPDF3"]['size'];
$archivoTMP=$_FILES["nuevoPDF3"]['tmp_name'];
$column1_Update=$_POST["column1_Updatec3"];
$column2_Update=$_POST["column2_Updatec3"];
    break;
  case 'c4':
$archivoType=$_FILES["nuevoPDF4"]['type'];
$archivoSize=$_FILES["nuevoPDF4"]['size'];
$archivoTMP=$_FILES["nuevoPDF4"]['tmp_name'];
$column1_Update=$_POST["column1_Updatec4"];
$column2_Update=$_POST["column2_Updatec4"];
    break;
  default:
$errorpdf= 'ERROR GENERAL.........';
}


	$filename=$IDPRINCIPAL.'-'.$ID_PROCESO_TRAMITES.'-'.$conjunto.'.pdf';
	##echo "filename=".$filename."<br>";
	if ($archivoType!='application/pdf') {
	  ###
	   ##$errorpdf="El Archivo PDF$conjunto  debe de ser formato pdf $column1_Update $column2_Update $conjunto";
	   $errorpdf="El Archivo PDF$conjunto  debe de ser formato pdf ";
	  ###
	}
	else if ($archivoSize==NULL) {
	  ###
	  $errorpdf="Error el archivo PDF$conjunto  es NULL o Vacio";
	  ###
	}
	else if ($archivoSize>$MAX_FILE_SIZE) {
	  ###
	   $errorpdf="El Archivo PDF$conjunto  es muy GRANDE (Pesado)";
	  ###
	}


	else if (!move_uploaded_file($archivoTMP,'../'.PDFS.$filename)) {
	  	###
		 $errorpdf='../'.PDFS.$filename."Error al subir el PDF$conjunto";
	  	###
		}
	else {	
	// Grabarla en la base de datos  
	$queryUPDATE="UPDATE proceso_tramites_temp SET $column1_Update='$filename', $column2_Update='OK'  WHERE id=$ID_PROCESO_TRAMITES AND id_principal=".$IDPRINCIPAL;
	##echo $queryUPDATE;
if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
	$exitopdf="Con Exito se subio el Archivo PDF$conjunto";
}
}	

#################################
#################################
// Eliminar

if (isset($_POST['eliminarPDF1']) || isset($_POST['eliminarPDF2']) || isset($_POST['eliminarPDF3']) || isset($_POST['eliminarPDF4']) ) {

$IDPRINCIPAL=$_POST["IDPRINCIPAL"];
$MAX_FILE_SIZE=$_POST["MAX_FILE_SIZE"];
$page=$_POST["page"];
$ID_TRAMITE=$_POST["ID_TRAMITE"];
$ID_PROCESO_TRAMITES=$_POST["ID_PROCESO_TRAMITES"];


if (isset($_POST['eliminarPDF1'])) $conjunto=$_POST["conjuntoc1"];
if (isset($_POST['eliminarPDF2'])) $conjunto=$_POST["conjuntoc2"];
if (isset($_POST['eliminarPDF3'])) $conjunto=$_POST["conjuntoc3"];
if (isset($_POST['eliminarPDF4'])) $conjunto=$_POST["conjuntoc4"];

switch ($conjunto) {
  case 'c1':
$column1_Update=$_POST["column1_Updatec1"];
$column2_Update=$_POST["column2_Updatec1"];
    break;
  case 'c2':
$column1_Update=$_POST["column1_Updatec2"];
$column2_Update=$_POST["column2_Updatec2"];
    break;
  case 'c3':
$column1_Update=$_POST["column1_Updatec3"];
$column2_Update=$_POST["column2_Updatec3"];
    break;
  case 'c4':
$column1_Update=$_POST["column1_Updatec4"];
$column2_Update=$_POST["column2_Updatec4"];
    break;
  default:
$errorpdf= 'ERROR GENERAL.........';
}

	$queryUPDATE="UPDATE proceso_tramites_temp SET $column1_Update='', $column2_Update=''  WHERE id=$ID_PROCESO_TRAMITES AND id_principal=".$IDPRINCIPAL;
	##echo $queryUPDATE;
if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
	$exitopdf="Se Elimino el Archivo PDF$conjunto";


}



#################################
#################################
// Cerrar Finalizar 

if (isset($_POST['cerrarTrabajoPDF'])) {

$IDPRINCIPAL=$_POST["IDPRINCIPAL"];
$page=$_POST["page"];
$ID_TRAMITE=$_POST["ID_TRAMITE"];
$ID_PROCESO_TRAMITES=$_POST["ID_PROCESO_TRAMITES"];


date_default_timezone_set('America/Los_Angeles');
$today = date("Y-m-d");


$KueryPT_SEPUEDECERRAR="SELECT COUNT(*) AS cuentaSEPUEDECERRAR FROM proceso_tramites_temp WHERE en_proceso='EN PROCESO' AND id_principal=$IDPRINCIPAL AND id_tramite=$ID_TRAMITE AND id=$ID_PROCESO_TRAMITES AND estatus_docs_pdf1='OK' AND estatus_docs_pdf2='OK' AND estatus_docs_pdf3='OK' AND estatus_docs_pdf4='OK'";

$arregloPT_SEPUEDECERRAR = mysqli_fetch_array(mysqli_query($con,$KueryPT_SEPUEDECERRAR));
$cuentaSEPUEDECERRAR=$arregloPT_SEPUEDECERRAR['cuentaSEPUEDECERRAR'];

if  ( $cuentaSEPUEDECERRAR> 0 ) {
	$queryUPDATE="UPDATE  recepcion_analisis_documentos_temp SET en_proceso='FIN', fecha_fin='$today' WHERE id_principal=$IDPRINCIPAL AND id_proceso_tramites=$ID_PROCESO_TRAMITES";
	##echo $queryUPDATE;
	##  de Efectuar Inspeccion  -->  Inspeccion Realizada
#### Hay que revisar si ya se realizo la Inspeccion, siendo asi el estaus = Presupuesto
$Kuery_ChecarEstatus="SELECT COUNT(*) AS CuentaChecarEstatus FROM principal_temp WHERE estatus='Inspeccion Realizada' AND id=".$IDPRINCIPAL;
$arreglo_ChecarEstatus = mysqli_fetch_array(mysqli_query($con,$Kuery_ChecarEstatus));
$cuentaSTATUS=$arreglo_ChecarEstatus['CuentaChecarEstatus'];
if ( $cuentaSTATUS> 0 ) {
$Kuery_Update2="UPDATE principal_temp SET estatus='Presupuesto' WHERE id=".$IDPRINCIPAL;
} else {
$Kuery_Update2="UPDATE principal_temp SET estatus='RAD Realizado' WHERE id=".$IDPRINCIPAL;
}

if (!mysqli_query($con,$Kuery_Update2)) echo mysqli_error();
	
if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
$exitopdf="Finalizo la Tarea Revisión y Análisis de Documentos";
}

}


#################################
#################################


$sqlPrincipal="SELECT * FROM principal_temp WHERE id=".$IDPRINCIPAL;
$arregloPRINCIPAL = mysqli_fetch_array(mysqli_query($con,$sqlPrincipal));
$nombre_comercial_establecimientoDB=$arregloPRINCIPAL['nombre_comercial_establecimiento'];
$numero_permisoDB=$arregloPRINCIPAL['numero_permiso'];
$estatusDB=$arregloPRINCIPAL['estatus'];
$operacionDB=$arregloPRINCIPAL['operacion'];
$observacionesDB=$arregloPRINCIPAL['observaciones'];
$fecha_altaDB=$arregloPRINCIPAL['fecha_alta'];
$id_municipioDB=$arregloPRINCIPAL['id_municipio'];
$foto_principalDB=$arregloPRINCIPAL['foto'];
$folioDB=$arregloPRINCIPAL['folio'];

$modalidad_graduacion_alcoholica=$arregloPRINCIPAL['modalidad_graduacion_alcoholica'];

$calle_establecimientoDB=$arregloPRINCIPAL['calle_establecimiento'];
$entre_calles_establecimientoDB=$arregloPRINCIPAL['entre_calles_establecimiento'];
$numero_establecimientoDB=$arregloPRINCIPAL['numero_establecimiento'];
$numerointerno_local_establecimientoDB=$arregloPRINCIPAL['numerointerno_local_establecimiento'];
$cp_establecimientoDB=$arregloPRINCIPAL['cp_establecimiento'];

$id_giroDB=$arregloPRINCIPAL['giro'];
$id_modalidad_graduacion_alcoholicaDB=$arregloPRINCIPAL['modalidad_graduacion_alcoholica'];

$delegacion_id=$arregloPRINCIPAL['id_delegacion'];
$colonia_id=$arregloPRINCIPAL['id_colonia'];
################
$sql_giro="SELECT descripcion_giro FROM giro WHERE id=".$id_giroDB;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
##
##$sql_modalidad_graduacion_alcoholica="SELECT descripcion_modalidad_graduacion_alcoholica FROM modalidad_graduacion_alcoholica WHERE id=".$id_modalidad_graduacion_alcoholicaDB;
##$result_modalidad_graduacion_alcoholica = mysqli_query($con,$sql_modalidad_graduacion_alcoholica);
##$row_modalidad_graduacion_alcoholica = mysqli_fetch_assoc($result_modalidad_graduacion_alcoholica);
##$MODALIDAD_GA=$row_modalidad_graduacion_alcoholica['descripcion_modalidad_graduacion_alcoholica'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipioDB;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$delegacion_id;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$row_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACION=$row_delegacion['delegacion'];
##
$sql_colonia="SELECT colonia FROM colonias WHERE id=".$colonia_id;
$result_colonia = mysqli_query($con,$sql_colonia);
$row_colonia = mysqli_fetch_assoc($result_colonia);
$COLONIA=$row_colonia['colonia'];
##

$domicilio_establecimiento=$calle_establecimientoDB." #".$numero_establecimientoDB." ".$numerointerno_local_establecimientoDB." CP ".$cp_establecimientoDB.", ".$COLONIA." (".$DELEGACION.") ".$MUNICIPIO;

echo "<h7><b><span style='background:#AC905B;'><font color='white'>Permiso Temporal - Revisón y Análisis de Documentos  :</span></b><font color='black'> Folio (".$folioDB."), ".$nombre_comercial_establecimientoDB." (".$GIRO.")<br>".$domicilio_establecimiento."</font></h7>";
##############################
if (!isset($errorpdf)) {
	$errorpdf="";
} else {
echo '<table width="80%" border=1 align=center>';
echo '<tr><td bgcolor=red>';
echo "<span class='error' >$errorpdf</span>";
echo '</td></tr>';
echo '</table>';
}
####
if (!isset($exitopdf)) {
$exitopdf="";
} else {
echo '<table width="80%" border=1 align=center>';
echo '<tr><td bgcolor=skyblue>';
echo "<span class='exito' >$exitopdf</span>";
echo '</td></tr>';
echo '</table>';
}
##############################
################
################
$id_tramite=$arregloPRINCIPAL['id_tramite'];
$id_proceso_tramites=$arregloPRINCIPAL['id_proceso_tramites'];
################
################
$KueryPT="SELECT * FROM proceso_tramites_temp WHERE id_principal=$IDPRINCIPAL AND id=$id_proceso_tramites";
##echo $KueryPT;
$arregloPT = mysqli_fetch_array(mysqli_query($con,$KueryPT));

$en_proceso=$arregloPT['en_proceso'];

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
################
$KueryPT_FINALIZADO= "SELECT COUNT(*)  AS cuentaFINALIZADO FROM recepcion_analisis_documentos_temp WHERE en_proceso='FIN' AND id_principal=$IDPRINCIPAL AND id_proceso_tramites=$id_proceso_tramites";
$arregloPT_FINALIZADO = mysqli_fetch_array(mysqli_query($con,$KueryPT_FINALIZADO));
$cuentaFINALIZADO=$arregloPT_FINALIZADO['cuentaFINALIZADO'];
##echo $KueryPT_FINALIZADO.'(('.$cuentaFINALIZADO.'))<br>';
##############################
echo '<br>';
echo "<table border=1 width='800' aling='center'>";
echo "<tr>";
echo "<td style=\"background-color:#C0C0C0\" width='6%' align=center><font size='2'><b>-</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='35%' align=center><font size='2'><b>-</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='35%' align=center><font size='2'><b>PDF</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='12%' align=center><font size='2'><b>Eliminar</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='12%' align=center><font size='2'><b>Subir</b></font></td>";

echo "</tr>";

#########################

echo "<tr>";
echo "<td align=center><font color='black' size='2'><b>C1</b></td>";
echo "<td align=lefth><font size='1' color='black'>";
echo '1- Acta de nacimiento o acta constitutiva<br>';
echo '2- Identificacion oficial vigente<br>';
echo '3- Registro federal de contribuyente<br>';
echo '4- No antencedentes_penales y constancia de residencia<br>';
echo "</td>";
#########

echo "<td align=center>";
if (empty($docs_pdf1DB) || $docs_pdf1DB=='' ) echo '<img class="item-img img-responsive" src="img/noPDF.jpg" alt="" alt=""  style="width:80px;height:80px;">';
else {
##echo '<img class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:100px;height:100px;">';
	
echo '<a href="#"   data-bs-toggle="modal" data-bs-target="#ModalPDF1">';
echo '<image class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:80px;height:80px;"  data-target="#ModalPDF1" data-toggle="modal"></a>';
	
echo '<div class="modal" id="ModalPDF1" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C1</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf1DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf1DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';
}
echo "</td>";
#########
#
echo '<td align=center>';
if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {
echo '<form name="eliminarPDF1" action="principalPDFsTemporal.php" method="POST">';

echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";
echo "<input type='hidden' name='column1_Updatec1' value='docs_pdf1'>";
echo "<input type='hidden' name='column2_Updatec1' value='estatus_docs_pdf1'>";
echo "<input type='hidden' name='conjuntoc1' value='c1'>";

echo '<button id="eliminar1" name="eliminarPDF1" type="submit" title="Eliminar PDF1 " class="button" style="color:red;"  /><i class="bi bi-trash"></i> </button>';
echo '</form>';
}

echo '</td>';

echo '<td align=center>';

if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {

echo '<form ENCTYPE="multipart/form-data" name="subirnuevoPDF1" action="principalPDFsTemporal.php" method="POST">';
?>
<div class="input_container">
<?php
//<label for="files1" class="btn btn-info btn-sm"><i class="bi bi-file-earmark-pdf"></i><font size="1">PDF 1</font></label>
//<input id="files1" name="nuevoPDF1" style="display:none;" type="file" accept=".pdf">
echo '</div>';
echo '<p></p>';
##echo "<input type='file'   name='nuevoPDF' class='choose'>";
echo "<input type='hidden' name='prim' value='yaentro'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='15000000'>";
echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";

echo "<input type='hidden' name='column1_Updatec1' value='docs_pdf1'>";
echo "<input type='hidden' name='column2_Updatec1' value='estatus_docs_pdf1'>";
echo "<input type='hidden' name='conjuntoc1' value='c1'>";

//echo '<button name="subirnuevoPDF1" class="btn btn-primary" type="submit" title="Subir PDF Conjunto 1" class="button" style="color:white;" /><i class="bi bi-upload"></i><font color="white"> </font></button>';

echo '</form>';

//chang
echo '<a href="#" class="btn btn-sm btn-action btn-dark" title="Cargar PDF1" data-bs-toggle="modal" data-bs-target="#pdfModalct1" onclick="pdf_registro1file_ct1(\''.$IDPRINCIPAL.'\',\'c1\',\''.$folioDB.'\',\''.$id_proceso_tramites.'\',\''.$page.'\')"><i class="bi bi-upload"></i>PDF 1</a>';
}

echo '</td>';
echo "</tr>";
#########################

#########################

echo "<tr  style='background-color:#dcdcdc;'>";
echo "<td align=center><font color='black' size='2'><b>C2</b></td>";
echo "<td align=lefth><font size='1' color='black'>";
echo '1- Contrato de arrendamiento o documento que acredite la propiedad pago predial<br>';
echo '2- No adeudo municipal o libertad de gravamen municipal<br>';
echo '3- Certificado de numero oficial<br>';
echo "</td>";
#########
echo "<td align=center>";
if ( empty($docs_pdf2DB)  || $docs_pdf2DB=='' ) echo '<img class="item-img img-responsive" src="img/noPDF.jpg" alt="" alt=""  style="width:80px;height:80px;">';
else {
##echo '<img class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:100px;height:100px;">';

echo '<a href="#"   data-bs-toggle="modal" data-bs-target="#ModalPDF2">';
echo '<image class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:80px;height:80px;"  data-target="#ModalPDF2" data-toggle="modal"></a>';

echo '<div class="modal" id="ModalPDF2" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C2</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf2DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf2DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';

}
echo "</td>";
#########
#
echo '<td align=center>';

if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {
echo '<form name="eliminarPDF2" action="principalPDFsTemporal.php" method="POST">';

echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";
echo "<input type='hidden' name='column1_Updatec2' value='docs_pdf2'>";
echo "<input type='hidden' name='column2_Updatec2' value='estatus_docs_pdf2'>";
echo "<input type='hidden' name='conjuntoc2' value='c2'>";

echo '<button id="eliminar2" name="eliminarPDF2" type="submit" title="Eliminar PDF2 " class="button" style="color:red;"  /><i class="bi bi-trash"></i> </button>';
echo '</form>';
}
echo '</td>';

echo '<td align=center>';
if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {
echo '<form ENCTYPE="multipart/form-data" name="subirnuevoPDF2 action="principalPDFsTemporal.php" method="POST">';
?>
<div class="input_container">

<?php
//<label for="files2" class="btn btn-info btn-sm"><i class="bi bi-file-earmark-pdf"></i><font size="1">PDF 2</font></label>
//<input id="files2" name="nuevoPDF2" style="display:none;" type="file" accept=".pdf">
echo '</div>';
echo '<p></p>';
##echo "<input type='file'   name='nuevoPDF' class='choose'>";
echo "<input type='hidden' name='prim' value='yaentro'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='15000000'>";
echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";

echo "<input type='hidden' name='column1_Updatec2' value='docs_pdf2'>";
echo "<input type='hidden' name='column2_Updatec2' value='estatus_docs_pdf2'>";
echo "<input type='hidden' name='conjuntoc2' value='c2'>";

//echo '<button name="subirnuevoPDF2" class="btn btn-primary" type="submit" title="Subir PDF Conjunto 1" class="button" style="color:white;" /><i class="bi bi-upload"></i><font color="white"> </font></button>';

echo '</form>';
//chang
echo '<a href="#" class="btn btn-sm btn-action btn-dark" title="Cargar PDF2" data-bs-toggle="modal" data-bs-target="#pdfModalct2" onclick="pdf_registro1file_ct2(\''.$IDPRINCIPAL.'\',\'c2\',\''.$folioDB.'\',\''.$id_proceso_tramites.'\',\''.$page.'\')"><i class="bi bi-upload"></i>PDF 2</a>';

}
echo '</td>';
echo "</tr>";
#########################

#########################

echo "<tr>";
echo "<td align=center><font color='black' size='2'><b>C3</b></td>";
echo "<td align=lefth><font size='1' color='black'>";
echo '1- Croquis o plano<br>';
echo '2- Fotografias<br>';
echo "</td>";
#########

echo "<td align=center>";
if ( empty($docs_pdf3DB)  || $docs_pdf3DB=='' ) echo '<img class="item-img img-responsive" src="img/noPDF.jpg" alt="" alt=""  style="width:80px;height:80px;">';
else {
##echo '<img class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:100px;height:100px;">';

echo '<a href="#"   data-bs-toggle="modal" data-bs-target="#ModalPDF3">';
echo '<image class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:80px;height:80px;"  data-target="#ModalPDF3" data-toggle="modal"></a>';

echo '<div class="modal" id="ModalPDF3" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C3</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf3DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf3DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';


}
echo "</td>";
#########
#
echo '<td align=center>';

if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {
echo '<form name="eliminarPDF3" action="principalPDFsTemporal.php" method="POST">';

echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";
echo "<input type='hidden' name='column1_Updatec3' value='docs_pdf3'>";
echo "<input type='hidden' name='column2_Updatec3' value='estatus_docs_pdf3'>";
echo "<input type='hidden' name='conjuntoc3' value='c3'>";

echo '<button id="eliminar3" name="eliminarPDF3" type="submit" title="Eliminar PDF3 " class="button" style="color:red;"  /><i class="bi bi-trash"></i> </button>';
echo '</form>';
}
echo '</td>';

echo '<td align=center>';
if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {
echo '<form ENCTYPE="multipart/form-data" name="subirnuevoPDF3" action="principalPDFsTemporal.php" method="POST">';
?>
<div class="input_container">
<?php
//<label for="files3" class="btn btn-info btn-sm"><i class="bi bi-file-earmark-pdf"></i><font size="1">PDF 3</font></label>
//<input id="files3" name="nuevoPDF3" style="display:none;" type="file" accept=".pdf">
echo '</div>';
echo '<p></p>';
##echo "<input type='file'   name='nuevoPDF' class='choose'>";
echo "<input type='hidden' name='prim' value='yaentro'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='15000000'>";
echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";

echo "<input type='hidden' name='column1_Updatec3' value='docs_pdf3'>";
echo "<input type='hidden' name='column2_Updatec3' value='estatus_docs_pdf3'>";
echo "<input type='hidden' name='conjuntoc3' value='c3'>";

//echo '<button name="subirnuevoPDF3" class="btn btn-primary" type="submit" title="Subir PDF Conjunto 1" class="button" style="color:white;" /><i class="bi bi-upload"></i><font color="white"> </font></button>';

echo '</form>';

//chang
echo '<a href="#" class="btn btn-sm btn-action btn-dark" title="Cargar PDF3" data-bs-toggle="modal" data-bs-target="#pdfModalct3" onclick="pdf_registro1file_ct3(\''.$IDPRINCIPAL.'\',\'c3\',\''.$folioDB.'\',\''.$id_proceso_tramites.'\',\''.$page.'\')"><i class="bi bi-upload"></i>PDF 3</a>';

}
echo '</td>';
echo "</tr>";
#########################

echo "<tr  style='background-color:#dcdcdc;'>";
echo "<td align=center><font color='black' size='2'><b>C4</b></td>";
echo "<td align=lefth><font size='1' color='black'>";
echo '1- Licencia o permiso de operación municipal <br>';
echo '2- Bomberos_original del certificado de medidas de seguridad y dictamen<br>';
echo '3- Dictamen uso de suelo<br>';
echo '4- Licencia anuncio y/o rotulos<br>';
echo "</td>";
#########

echo "<td align=center>";
if ( empty($docs_pdf4DB)  || $docs_pdf4DB=='' ) echo '<img class="item-img img-responsive" src="img/noPDF.jpg" alt="" alt=""  style="width:80px;height:80px;">';
else {
##echo '<img class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:100px;height:100px;">';

echo '<a href="#"   data-bs-toggle="modal" data-bs-target="#ModalPDF4">';
echo '<image class="item-img img-responsive" src="img/pdfLogo.jpg" alt="" alt=""  style="width:80px;height:80px;"  data-target="#ModalPDF4" data-toggle="modal"></a>';

echo '<div class="modal" id="ModalPDF4" tabindex="-1" role="dialog">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content">';

echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i>PDF C4</h6>';
echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
echo '</div>';
echo '<div class="modal-body">';
//echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="http://'.IPADDRESS.'/bebal_docs/'.$docs_pdf4DB.'"></object>';
echo '<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="../bebal_docs/'.$docs_pdf4DB.'"></object>';
echo '</div>';
echo '</div>';
echo '</div>';


}
echo "</td>";
#########
#
echo '<td align=center>';
if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {
echo '<form name="eliminarPDF4" action="principalPDFsTemporal.php" method="POST">';

echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";
echo "<input type='hidden' name='column1_Updatec4' value='docs_pdf4'>";
echo "<input type='hidden' name='column2_Updatec4' value='estatus_docs_pdf4'>";
echo "<input type='hidden' name='conjuntoc4' value='c4'>";

echo '<button id="eliminar4" name="eliminarPDF4" type="submit" title="Eliminar PDF4 " class="button" style="color:red;"  /><i class="bi bi-trash"></i> </button>';
echo '</form>';
}
echo '</td>';

echo '<td align=center>';

if ( $cuentaFINALIZADO>0 ) {
echo '<font color="black">-</font>';
} else {


echo '<form ENCTYPE="multipart/form-data" name="subirnuevoPDF4" action="principalPDFsTemporal.php" method="POST">';
?>
<div class="input_container">
<?php
//<label for="files4" class="btn btn-info btn-sm"><i class="bi bi-file-earmark-pdf"></i><font size="1">PDF 4</font></label>
//<input id="files4" name="nuevoPDF4" style="display:none;" type="file" accept=".pdf">
echo '</div>';
echo '<p></p>';
##echo "<input type='file'   name='nuevoPDF' class='choose'>";
echo "<input type='hidden' name='prim' value='yaentro'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='15000000'>";
echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";

echo "<input type='hidden' name='column1_Updatec4' value='docs_pdf4'>";
echo "<input type='hidden' name='column2_Updatec4' value='estatus_docs_pdf4'>";
echo "<input type='hidden' name='conjuntoc4' value='c4'>";

//echo '<button name="subirnuevoPDF4" class="btn btn-primary" type="submit" title="Subir PDF Conjunto 1" class="button" style="color:white;" /><i class="bi bi-upload"></i><font color="white"> </font></button>';

echo '</form>';

//chang
echo '<a href="#" class="btn btn-sm btn-action btn-dark" title="Cargar PDF4" data-bs-toggle="modal" data-bs-target="#pdfModalct4" onclick="pdf_registro1file_ct4(\''.$IDPRINCIPAL.'\',\'c4\',\''.$folioDB.'\',\''.$id_proceso_tramites.'\',\''.$page.'\')"><i class="bi bi-upload"></i>PDF 4</a>';

}

echo '</td>';
echo "</tr>";
#########################
echo "</table>";


echo '<br>';

echo '<table width="60%" border="0"><tr>';
echo '<td>';
echo '<form action="principal.php" name="ir_aPrincipal" method="POST">';
echo '<input type="hidden" name="page" value="'.$page.'">';

echo '<button type="button" onclick="window.location.href=\'principal_temp.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF; color:black !important;"> <i class="bi bi-arrow-left"></i><font size="1"> Regresar a página '.$page.' </font></button>&nbsp;';

echo "</form>";

$KueryPT_SEPUEDECERRAR="SELECT COUNT(*) AS cuentaSEPUEDECERRAR FROM proceso_tramites_temp WHERE en_proceso='EN PROCESO' AND id_principal=$IDPRINCIPAL AND id_tramite=$id_tramite AND id=$id_proceso_tramites AND 
estatus_docs_pdf1='OK' AND 
estatus_docs_pdf2='OK' AND 
estatus_docs_pdf3='OK' AND 
estatus_docs_pdf4='OK'";
$arregloPT_SEPUEDECERRAR = mysqli_fetch_array(mysqli_query($con,$KueryPT_SEPUEDECERRAR));
$cuentaSEPUEDECERRAR=$arregloPT_SEPUEDECERRAR['cuentaSEPUEDECERRAR'];

##echo '<font color="black">cuentaFINALIZADO='.$cuentaSEPUEDECERRAR.'</font>';

echo '</td><td>';
echo '<form name="cerrarTrabajoPDF" action="principalPDFsTemporal.php" method="POST">';

echo "<input type='hidden' name='IDPRINCIPAL' value='".$IDPRINCIPAL."'>";
echo "<input type='hidden' name='page' value='".$page."'>";
echo "<input type='hidden' name='ID_TRAMITE' value='".$id_tramite."'>";
echo "<input type='hidden' name='ID_PROCESO_TRAMITES' value='".$id_proceso_tramites."'>";


##############################
###  DESPUES HAY QUE CAMBIARLE
if  ( $cuentaFINALIZADO>0 ) {
echo '<font size="2" color="black"><b><u>Revisión y Análisis de Documentos  Finalizada </u></b></font>';
} else {
if ( $estatus_docs_pdf1DB=='OK' && $estatus_docs_pdf2DB=='OK' && $estatus_docs_pdf3DB=='OK' && $estatus_docs_pdf4DB=='OK' ) {
echo '<button id="cerrarTrabajoPDF" name="cerrarTrabajoPDF" type="submit" title="Finalizar Revisión y Análisis de Documentos" class="btn btn-danger btn-sm" style="color:white;"  /><i class="bi bi-gear"></i><font size="1">Finalizar Trabajo RAD</font></button>';
} else {
echo '<button id="cerrarTrabajoPDF" name="cerrarTrabajoPDF" type="submit" title="Finalizar Revisión y Análisis de Documentos" class="btn btn-danger btn-sm" style="color:white;" disabled  /><i class="bi bi-gear"></i><font size="1">Se Tiene que Subir los PDFs</font></button>';
}
}

echo "</form>";
echo '</td>';
echo '</tr></table>';

echo '<br><br>';
?>	
</div>


<hr>
<?php
mysqli_close($con);
include("footer.php");
?>


<script type="text/javascript" src="js/pdf-modal_un_file_ct1.js"></script>
<script type="text/javascript" src="js/pdf-modal_un_file_ct2.js"></script>
<script type="text/javascript" src="js/pdf-modal_un_file_ct3.js"></script>
<script type="text/javascript" src="js/pdf-modal_un_file_ct4.js"></script>

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


#longitud:valid {
    color: black;
background-color: #3CBC8D;
}
#longitud:invalid {
    color: red;
}

#latitud:valid {
    color: black;
background-color: #3CBC8D;
}
#latitud:invalid {
    color: red;
}

#map {
  margin: 0px;
  width: 100%;
  height: 400px;
  padding: 0px;
  z-index: 1;
  border: 2px solid #AC905B;
  border-radius: 5px;
}

</style>


<script src="../MiLibreria/leaflet/js/leaflet.js"></script>
<link rel="stylesheet" href="../MiLibreria/leaflet/css/leaflet.css">


<?php
error_reporting(0);
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

?>
<!DOCTYPE html>
<html lang="en">
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
$ID_PROCESO_TRAMITES=$_GET['id_proceso_tramites'];
} else {
$IDPRINCIPAL=$_POST['IDPRINCIPAL'];
$page=$_POST['page'];
$ID_PROCESO_TRAMITES=$_POST["ID_PROCESO_TRAMITES"];
}
#################################
#################################
// move_uploaded_file
if (isset($_POST['subirnuevafoto'])) {

include("functions_hm.php");
$IDPRINCIPAL=$_POST["IDPRINCIPAL"];
$ID_PROCESO_TRAMITES=$_POST["ID_PROCESO_TRAMITES"];
	
$queryINSERTA="INSERT INTO fotos (descripcion,idprincipal,id_proceso_tramites) VALUES ('Inserta Row, idprincipal=".$IDPRINCIPAL."',".$IDPRINCIPAL.",".$ID_PROCESO_TRAMITES.");";
if (!mysqli_query($con,$queryINSERTA)) echo mysqli_error();
$queryMAXidfoto="SELECT MAX(idfoto) AS idfoto FROM fotos;";
$resultMAXidfoto = mysqli_query($con,$queryMAXidfoto);
$row=mysqli_fetch_assoc($resultMAXidfoto);
$nextidf=$row['idfoto'];



	$filename=$IDPRINCIPAL.'-'.$ID_PROCESO_TRAMITES.'-'.$nextidf.'.jpg';
	##echo "filename=".$filename."<br>";
	if ($_FILES["nuevafoto"]['type']!='image/jpeg') {
	  ###
	   $errorfoto="La foto debe estar en formato jpg";
	   $queryUPDATE="UPDATE fotos SET descripcion='".$errorfoto.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
	   if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
	  ###
	}
	else if (($size=getimagesize($_FILES["nuevafoto"]['tmp_name']))==NULL) {
	  ###
	  $errorfoto="Error el archivo es NULL";
	  $queryUPDATE="UPDATE fotos SET descripcion='".$errorfoto.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
	  if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
	  ###
	}
	else if (($size[0]<640) OR ($size[1]<480)) {
	  ###
	   $errorfoto="Imagen con poca resolución. Imagen actual: ".$size[0]."x".$size[1]."px. Mínimo 640x480px";
	   $queryUPDATE="UPDATE fotos SET descripcion='".$errorfoto.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
	   if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
	  ###
	}
	else if (!move_uploaded_file($_FILES["nuevafoto"]['tmp_name'],'../'.FOTOSORIGINALES.$filename)) {
		// echo FOTOSORIGINALES.$filename;
	  	###
		 $errorfoto='../'.FOTOSORIGINALES.$filename."Error al subir la foto";
	   	 $queryUPDATE="UPDATE fotos SET descripcion='".$errorfoto.", idprincipal=".$IDPRINCIPAL."', idprincipal=0 WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
	   	 if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();
	  	###
		}
	else {	
	superscaleimage('../'.FOTOSORIGINALES.$filename,'../'.FOTOSMEDIAS.$filename,ANCHOMEDIO,ALTOMEDIO,95);
	// echo '<img src="'.FOTOSMEDIAS.$filename.'">';
	superscaleimage('../'.FOTOSORIGINALES.$filename,'../'.FOTOSTHUMB.$filename,ANCHOTHUMB,ALTOTHUMB,95);
	// echo '<img src="'.FOTOSTHUMB.$filename.'">';
		
	// Grabarla en la base de datos
	// echo "** Next".$conector->next_table_id("fotos");
$queryUPDATE="UPDATE fotos SET descripcion='OK' WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();

##$queryNF="INSERT INTO fotos (idfoto,descripcion,idvalla) VALUES (".$nextidf.",'',".$IDVALLA.");";
##if (!mysqli_query($con,$queryNF)) echo mysqli_error();
##$insertID1=mysqli_insert_id($con);	
###
	
// Si hay una sola la establece como principal
$sqlFotosCuantosReg="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
$resultFotosCuantosReg = mysqli_query($con, $sqlFotosCuantosReg);
$rowsFotosCuantosReg = mysqli_num_rows($resultFotosCuantosReg);
if ($rowsFotosCuantosReg==1) {
$sqlUpdate1="UPDATE principal SET foto='$nextidf' WHERE id=".$IDPRINCIPAL;
mysqli_query($con, $sqlUpdate1);
}

	
	}
}	

#################################
#################################
// Establecer principal
$sqlFotosCuantosReg1="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
$resultFotosCuantosReg1 = mysqli_query($con, $sqlFotosCuantosReg1);
$rowsFotosCuantosReg1 = mysqli_num_rows($resultFotosCuantosReg1);
for ($i=0;$i<$rowsFotosCuantosReg1;$i++) {
		if (isset($_POST['principal'.$i])) {
		$IDFOTO=$_POST['idfoto'.$i];
		##echo "IDFOTO=".$IDFOTO;
		$sqlUpdate2="UPDATE principal SET foto='$IDFOTO' WHERE id=".$IDPRINCIPAL;
		##echo $sqlUpdate2;
		mysqli_query($con, $sqlUpdate2);
		}
}	


#################################
#################################
// Eliminar
$sqlFotosCuantosReg2="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
$resultFotosCuantosReg2 = mysqli_query($con, $sqlFotosCuantosReg2);
$rowsFotosCuantosReg2 = mysqli_num_rows($resultFotosCuantosReg2);
for ($i=0;$i<$rowsFotosCuantosReg2;$i++) {
	if (isset($_POST['eliminar'.$i])) {
		$IDFOTO=$_POST['idfoto'.$i];
		$sqlUpdate2="DELETE FROM fotos WHERE idfoto=".$IDFOTO;
		mysqli_query($con, $sqlUpdate2);
// Si hay una sola la establece como principal
$sqlFotosCuantosReg="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
$resultFotosCuantosReg = mysqli_query($con, $sqlFotosCuantosReg);
$rowsFotosCuantosReg = mysqli_num_rows($resultFotosCuantosReg);

// Si NO hay fotos NULL
if ($rowsFotosCuantosReg==0) {
$sqlUpdate4="UPDATE principal SET foto=NULL WHERE id=".$IDPRINCIPAL;
mysqli_query($con, $sqlUpdate4);
} else {
$sqlFotos1="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL." AND id_proceso_tramites=".$ID_PROCESO_TRAMITES;
$resultFotos1 = mysqli_query($con,$sqlFotos1);
$rowsFotos1 = mysqli_num_rows($resultFotos1);
for ($j=0;$j<1;$j++) {
$rowFotos1= mysqli_fetch_array($resultFotos1,MYSQLI_NUM);
$IDFOTO_DB=$rowFotos1[0];
}

$sqlUpdate3="UPDATE principal SET foto='$IDFOTO_DB' WHERE id=".$IDPRINCIPAL;
mysqli_query($con, $sqlUpdate3);

}

}
}



$sqlPrincipal="SELECT * FROM principal WHERE id=".$IDPRINCIPAL;
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
################
$id_tramite=$arregloPRINCIPAL['id_tramite'];
$id_proceso_tramites=$arregloPRINCIPAL['id_proceso_tramites'];
################
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



##
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
################
$KueryPT_FINALIZADO= "SELECT COUNT(*)  AS cuentaFINALIZADO FROM inspeccion WHERE en_proceso='FIN' AND id_principal=$IDPRINCIPAL AND id_proceso_tramites=$id_proceso_tramites";
##echo $KueryPT_FINALIZADO.'<br>';
$arregloPT_FINALIZADO = mysqli_fetch_array(mysqli_query($con,$KueryPT_FINALIZADO));
$cuentaFINALIZADO=$arregloPT_FINALIZADO['cuentaFINALIZADO'];
##############################

$domicilio_establecimiento=$calle_establecimiento." #".$numero_establecimiento." ".$numerointerno_local_establecimiento." CP ".$cp_establecimiento.", ".$COLONIA." (".$DELEGACION.") ".$MUNICIPIO;

echo "<h6><b><span style='background:#AC905B;'><font color='white'>Inspección:</span></b><font color='black'> ".$folioDB.", ".$nombre_comercial_establecimientoDB." (".$GIRO."), ".$domicilio_establecimiento."</font></h5>";
####################
####################
$SiHayFotos='';
$kuery00="SELECT COUNT(*) AS CUENTA00 FROM `proceso_tramites` WHERE id_principal=$IDPRINCIPAL AND en_proceso='Fin' ORDER by ID DESC LIMIT 1";
$arreglo00=mysqli_fetch_array(mysqli_query($con,$kuery00));
$CUENTA00=$arreglo00['CUENTA00'];
if ( $CUENTA00>0 ) {
$kuery800="SELECT * FROM proceso_tramites WHERE id_principal=$IDPRINCIPAL AND en_proceso='Fin' ORDER by ID DESC LIMIT 1";
$arreglo_PT800=mysqli_fetch_array(mysqli_query($con,$kuery800));
$ID_PT=$arreglo_PT800['id'];
$NOTA_PT=$arreglo_PT800['nota'];
$FECHA_FIN_PT=$arreglo_PT800['fecha_fin'];
$ID_TRAMITE_PT=$arreglo_PT800['id_tramite'];
#
$kuery000="SELECT COUNT(*) AS CUENTA000 FROM fotos WHERE descripcion='OK' AND id_proceso_tramites=$ID_PT";
$arreglo_FOTOS00=mysqli_fetch_array(mysqli_query($con,$kuery000));
$CUENTA000=$arreglo_FOTOS00['CUENTA000'];
#
$kueryTramite="SELECT * FROM tramite WHERE id=$ID_TRAMITE_PT";
$arreglo_Tramite=mysqli_fetch_array(mysqli_query($con,$kueryTramite));
$TRAMITE=$arreglo_Tramite['descripcion_tramite'];
#
if ( $CUENTA000>0 ) $SiHayFotos='SiHayFotos';
echo '<font color="red" size="2"><i class="bi bi-currency-dollar"></i></font><font color="black" size="2">  El Ultimo Tramite ('.$TRAMITE.') con ('.$CUENTA000.') Fotos </font><br>';
###
$kueryPRINCIPAL="SELECT * FROM principal WHERE id=$IDPRINCIPAL";
$arreglo_PRINCIPAL=mysqli_fetch_array(mysqli_query($con,$kueryPRINCIPAL));
$latitudDB=$arreglo_PRINCIPAL['latitud'];
$longitudDB=$arreglo_PRINCIPAL['longitud'];
$capacidad_comensales_personasDB=$arreglo_PRINCIPAL['capacidad_comensales_personas'];
$superficie_establecimientoDB=$arreglo_PRINCIPAL['superficie_establecimiento'];
###
#chang
$kueryINSPECCION="SELECT * FROM inspeccion WHERE id_principal=$IDPRINCIPAL AND id_proceso_tramites=$ID_PT";
##echo $kueryINSPECCION.'<br>';
$arreglo_INSPECCION=mysqli_fetch_array(mysqli_query($con,$kueryINSPECCION));
$observacion_1_cumple=$arreglo_INSPECCION['observacion_1_cumple'];
$observacion_1_datos=$arreglo_INSPECCION['observacion_1_datos'];
$observacion_1_metros=$arreglo_INSPECCION['observacion_1_metros'];
if ( empty($observacion_1_cumple) || $observacion_1_cumple==''  ) $observacion_1_cumple='NO';
if ( empty($observacion_1_metros) || $observacion_1_metros==''  ) $observacion_1_metros='0';
#
$observacion_2_cumple=$arreglo_INSPECCION['observacion_2_cumple'];
$observacion_2_datos=$arreglo_INSPECCION['observacion_2_datos'];
$observacion_2_metros=$arreglo_INSPECCION['observacion_2_metros'];
if ( empty($observacion_2_cumple) || $observacion_2_cumple==''  ) $observacion_2_cumple='NO';
if ( empty($observacion_2_metros) || $observacion_2_metros==''  ) $observacion_2_metros='0';
#
$observacion_3_cumple=$arreglo_INSPECCION['observacion_3_cumple'];
$observacion_3_datos=$arreglo_INSPECCION['observacion_3_datos'];
$observacion_3_metros=$arreglo_INSPECCION['observacion_3_metros'];
if ( empty($observacion_3_cumple) || $observacion_3_cumple==''  ) $observacion_3_cumple='NO';
if ( empty($observacion_3_metros) || $observacion_3_metros==''  ) $observacion_3_metros='0';
#
$observacion_4_cumple=$arreglo_INSPECCION['observacion_4_cumple'];
$observacion_4_datos=$arreglo_INSPECCION['observacion_4_datos'];
$observacion_4_metros=$arreglo_INSPECCION['observacion_4_metros'];
if ( empty($observacion_4_cumple) || $observacion_4_cumple==''  ) $observacion_4_cumple='NO';
if ( empty($observacion_4_metros) || $observacion_4_metros==''  ) $observacion_4_metros='0';
#
$observacion_5_cumple=$arreglo_INSPECCION['observacion_5_cumple'];
$observacion_5_datos=$arreglo_INSPECCION['observacion_5_datos'];
$observacion_5_metros=$arreglo_INSPECCION['observacion_5_metros'];
if ( empty($observacion_5_cumple) || $observacion_5_cumple==''  ) $observacion_5_cumple='NO';
if ( empty($observacion_5_metros) || $observacion_5_metros==''  ) $observacion_5_metros='0';
#
$observaciones=$arreglo_INSPECCION['observaciones'];
} else {
echo '<font color="black" size="2"><i class="bi bi-sign-no-parking"></i>   No existe Tramite Anterior.</font><br>';
$latitudDB='';
$longitudDB='';
$capacidad_comensales_personasDB='';
$superficie_establecimientoDB='';
$observacion_1_cumple='NO';
$observacion_1_datos='';
$observacion_1_metros=0;

$observacion_2_cumple='NO';
$observacion_2_datos='';
$observacion_2_metros=0;

$observacion_3_cumple='NO';
$observacion_3_datos='';
$observacion_3_metros=0;

$observacion_4_cumple='NO';
$observacion_4_datos='';
$observacion_4_metros=0;

$observacion_5_cumple='NO';
$observacion_5_datos='';
$observacion_5_metros=0;

$observaciones='';
}


#################################
##include("modal/efectuar_inspeccion.php");
include("modal/copiarFotos.php");
##############################
/* Agregar foto */
$ret="";
if (!isset($errorfoto)) $errorfoto="";

$ret .= '<form ENCTYPE="multipart/form-data" name="subirnuevafoto" action="principalFotos.php" method="POST">';

###
$ret .='<h6><u><font color="blue">Subir Foto</u></font></h6>';
$ret .='<table width="70%" border=0 align=center>';
$ret .='<tr><td>';
$ret .= "<input type=\"file\"  name=\"nuevafoto\" class='choose' accept='image/gif, image/jpeg, iamge/jpg' >";
$ret .= "<input type=\"hidden\" name=\"prim\" value=\"yaentro\">";
$ret .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"7000000\">";
$ret .= "<input type=\"hidden\" name=\"IDPRINCIPAL\" value=\"".$IDPRINCIPAL."\">";
$ret .= "<input type=\"hidden\" name=\"page\" value=\"".$page."\">";
$ret .= "<input type=\"hidden\" name=\"ID_PROCESO_TRAMITES\" value=\"".$id_proceso_tramites."\">";
$ret .='</td><td align=center>';

$ret .='<button name="subirnuevafoto" class="btn btn-primary btn-sm" type="submit" title="Subir Fotografia" class="button" style="color:white" /><i class="bi bi-upload"></i><font color="white" size="2">&nbsp;&nbsp;Subir Fotografia</font></button>';

$ret .='</td><td>';
//$ret .= '<a type="button" class="btn btn-default" href="vallas.php?pagina='.$page.'"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</a>';

$ret .='</td></tr>';
$ret .='</table>';
$ret .='<table width="80%" border=1 align=center>';
$ret .='<tr><td bgcolor=red>';
$ret .= "<span class=\"error\" >$errorfoto</span>";
$ret .='</td></tr>';
$ret .='</table>';
if  ( $cuentaFINALIZADO> 0 ) {
} else {
echo $ret;
}
echo '<br><br>';
##############################
$foto_file='../'.FOTOSMEDIAS.$IDPRINCIPAL.'-'.$ID_PROCESO_TRAMITES.'-'.$foto_principalDB.'.jpg';
echo "<table border=1 width='500' aling=center>";
echo "<tr>";
echo "<td style=\"background-color:#C0C0C0\" width='40%' align=center><font size='2'><b>Foto Principal</b></font></td>";
####
echo "<td align=center>";

if ( $foto_principalDB==NULL || $foto_principalDB=='' )
echo '<img class="item-img img-responsive" src="img/no_imagen.jpg" alt="" alt=""  style="width:50px;height:50px;">';
else {
	if ( file_exists($foto_file)!=1 ) echo '<img class="item-img img-responsive" src="img/no_imagen.jpg" alt="" alt=""  style="width:50px;height:50px;">';
	else {
	echo '<img id="myImg" src="'.$foto_file.'" alt="Principal  '.$folioDB.' / '.$numero_permisoDB.'  ('.$direccionDB.')"  style="width:90px;height:70px;">';
	}
}

echo "</td>";
####
echo "</tr>";
echo "</table>";
$sqlFotos="SELECT * FROM fotos f WHERE f.idprincipal=".$IDPRINCIPAL." AND f.id_proceso_tramites=".$ID_PROCESO_TRAMITES." ORDER BY f.idfoto;";
##echo $sqlFotos;
$resultFotos = mysqli_query($con, $sqlFotos);
$rowsFotos = mysqli_num_rows($resultFotos);

if ( $rowsFotos>0 ) {
##############################
echo '<br>';
echo "<table border=1 width='500' aling=center>";
echo "<tr>";
echo "<td style=\"background-color:#C0C0C0\" width='5%' align=center><font size='2'><b>-</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='35%' align=center><font size='2'><b>Fotografa</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='30%' align=center><font size='2'><b>Eliminar</b></font></td>";
echo "<td style=\"background-color:#C0C0C0\" width='30%' align=center><font size='2'><b>Como Principal</b></font></td>";
echo "</tr>";

$numero_foto=0;

for ($i=0; $i<$rowsFotos; $i++) {

$rowFotos= mysqli_fetch_array($resultFotos,MYSQLI_NUM);
$idfoto_db=$rowFotos[0];
$idprincipal=$rowFotos[2];
echo "<td align=center>";

$numero_foto=$i+1;
echo "<tr>";
echo "<td align=center>".$numero_foto."</td>";
#########
echo "<td align=center>";
$foto_fileSecundaria='../'.FOTOSMEDIAS.$IDPRINCIPAL.'-'.$ID_PROCESO_TRAMITES.'-'.$idfoto_db.'.jpg';
//echo $foto_fileSecundaria.'<br>';
if ( file_exists($foto_fileSecundaria)!=1 ) echo '<img class="item-img img-responsive" src="img/no_imagen.jpg" alt="" alt=""  style="width:50px;height:50px;">';
else {
echo '<img id="myImg" src="'.$foto_fileSecundaria.'" alt="Principal  '.$folioDB.' / '.$numero_permisoDB.'  ('.$direccionDB.')"  style="width:90px;height:70px;">';
}
echo "</td>";
#########
echo '<td align=center>';
#

if  ( $cuentaFINALIZADO> 0 ) {
echo '<font size="2" color="black">-</font>';
} else {
echo '<input type="hidden" name="idfoto'.$i.'" value="'.$idfoto_db.'" />';
echo '<button id="eliminar'.$i.'" name="eliminar'.$i.'" type="submit" title="Eliminar Fotografia '.$numero_foto.'" class="button" style="color:red;"  /><i class="bi bi-trash"></i> </button>';
}

echo '</td>';

echo '<td align=center>';

echo '<button id="principal'.$i.'" name="principal'.$i.'" type="submit" title="Fijar Como Princial Fotografia '.$numero_foto.'" class="button" style="color:green;" /><i class="bi bi-hand-thumbs-up"></i></button>';

echo '</td>';
echo "</tr>";
}
echo "</table>";

} else {
echo "<br/><br/>El Registro no posee fotos";
}
echo "</form>";

######################################

##echo '<div id="map" class="map" style="height:200px; width:100%;background-color: powderblue;"></div>';

######################################

echo '<br>';
echo '<FORM action="principal.php" name="ir_aPrincipal" method="POST">';
echo '<input type="hidden" name="pagina" value="'.$page.'">';


echo '<button type="button" onclick="window.location.href=\'principal.php?page='.$page.'&action=ajax\'" class="btn btn-info bs-sm" style="background-color:#FFFFFF; color:black !important;"> <i class="bi bi-arrow-left"></i><font size="1"> Regresar a Página '.$page.' </font></button>&nbsp;';



##echo '<a href="#EfectuarInspeccion" data-bs-toggle="modal" data-nombre_comercial_establecimiento="'.$nombre_comercial_establecimiento.'" data-folio="'.$folio.'" data-idprincipal="'.$IDPRINCIPAL.'" data-pagina="'.$page.'" class="btn btn-danger bs-sm" title="Registrar Inspección"> <i class="bi bi-clipboard-check"></i><font size="1"> Registrar Inspección </font></a>&nbsp;';


echo '<input type="hidden" id="nombre_comercial_establecimiento" value="'.$nombre_comercial_establecimientoDB.'" >';
echo '<input type="hidden" id="folio" value="'.$folioDB.'" >';
echo '<input type="hidden" id="pagina" value="'.$page.'" >';
echo '<input type="hidden" id="idprincipal" value="'.$IDPRINCIPAL.'" >';
echo '<input type="hidden" id="id_tramite" value="'.$id_tramite.'" >';
echo '<input type="hidden" id="id_proceso_tramites" value="'.$id_proceso_tramites.'" >';

##echo 'cuentaFINALIZADO='.$cuentaFINALIZADO;

if  ( $cuentaFINALIZADO> 0 ) {
echo '<font size="2" color="black"><b><u>Inspección Finalizada </u></b></font>';
} else {
##echo '<a href="#" class="btn btn-outline-success" title="Efectuar Inspeccion" onclick="obtener_datosInspeccion('.$IDPRINCIPAL.');" data-bs-toggle="modal" data-bs-target="#EfectuarInspeccion"><i class="bi bi-clipboard-check"></i> Registrar Inspección </a>';
echo '<a href="#" class="btn btn-danger bs-sm" id="myBtn"  title="Efectuar Inspeccion" onclick="obtener_datosInspeccion('.$IDPRINCIPAL.');" data-bs-toggle="modal" data-bs-target="#EfectuarInspeccion"><i class="bi bi-gear"></i><font size="1"> Registrar Inspección </font></a>&nbsp;';

if ( $SiHayFotos=='SiHayFotos' ) {
echo  '<a href="#CopiarFotos" data-bs-toggle="modal" data-bs-target="#CopiarFotos"  class="btn btn-dark bs-sm" title="Copiar Fotos"><font color="red" size="2"><i class="bi bi-c-square"></i></font><font color="white" size="1"> Copiar Imagenes</font></a>';
}


}

##########
$sql_proceso_tramites="SELECT * FROM proceso_tramites WHERE id=$id_proceso_tramites";
$result_proceso_tramites = mysqli_query($con,$sql_proceso_tramites);
$row_proceso_tramites = mysqli_fetch_assoc($result_proceso_tramites);
$MEMO=$row_proceso_tramites['memo'];
##########
echo '<br><p><font size="1" color="black"><u>Campo Memo:</u> '.$MEMO.'</font></p>';

mysqli_close($con);

echo "</FORM>";

echo '<br><br>';
?>	
</div>
		 
	<hr>
	<?php
	include("footer.php");
?>

  </body>
</html>

<script>



$( "#copiarFotos" ).submit(function( event ) {
  $('#Button_copiarFotos').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/copiarFotos.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxcopiarFotos").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxcopiarFotos").html(datos);
                        $('#Button_copiarFotos').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});

<?php
echo "location.replace('principalFotos.php?id=".$IDPRINCIPAL."&page=".$page."&id_proceso_tramites=".$ID_PROCESO_TRAMITES."');";
?>



                        }, 2000);

                  }
        });
  event.preventDefault();
});





function obtener_datosInspeccion(id){

        var id = $("#id").val();
        var nombre_comercial_establecimiento = $("#nombre_comercial_establecimiento").val();
        var folio = $("#folio").val();
        var id_tramite = $("#id_tramite").val();
        var pagina = $("#pagina").val();
        var idprincipal = $("#idprincipal").val();
        var id_proceso_tramites = $("#id_proceso_tramites").val();


        $("#mod_id").val(id);
        $("#mod_nombre_comercial_establecimiento").val(nombre_comercial_establecimiento);
        $("#mod_folio").val(folio);
        $("#mod_id_tramite").val(id_tramite);
        $("#mod_pagina").val(pagina);
        $("#mod_idprincipal").val(idprincipal);
        $("#mod_id_proceso_tramites").val(id_proceso_tramites);

}


</script>


<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
<!--<div id="map" style="height:200px; width:100%;background-color: powderblue;"></div>-->

<div id="EfectuarInspeccion" class="modal fade" tabindex="-1">
 <div class="modal-dialog modal-dialog-scrollable modal-xl"  role="document">
<!--
<div class="modal fade" id="EfectuarInspeccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
-->
		<div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

			<h6 class="modal-title" id="EfectuarInspeccionLabel"><i class="bi bi-clipboard-check"></i> Registrar Inspección</h6>
 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
		  </div>
		  <div class="modal-body">
<!--
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccion" name="registro_guardar_inspeccion" action="ajax/registro_guardar_inspeccion.php">
-->
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccion" name="registro_guardar_inspeccion">
			<div id="resultados_ajaxInspeccion"></div>

<?php

echo '<font size="2" color="black">Nombre Establecimiento: </font><font size="2" color="blue">'.$nombre_comercial_establecimientoDB.'</font>, ';
echo '<font size="2" color="black">Folio: </font><font size="2" color="blue">'.$folioDB.'</font>';
?>

<?php

echo '<input type="hidden" id="mod_id" name="mod_id" value="'.$IDPRINCIPAL.'">';
echo '<input type="hidden" id="mod_id_tramite" name="id_tramite" value="'.$id_tramite.'">';
echo '<input type="hidden" id="mod_pagina" name="pagina" value="'.$page.'">';
echo '<input type="hidden" id="mod_idprincipal" name="idprincipal" value="'.$IDPRINCIPAL.'">';
echo '<input type="hidden" id="mod_id_proceso_tramites" name="id_proceso_tramites" value="'.$id_proceso_tramites.'">';

echo '<input type="hidden" id="mod_folio" name="folio" value="'.$folioDB.'">';

###
##echo '<div class="form-group row">';
##echo '<label for="superficie_establecimiento" class="col-sm-2 control-label"><font color="black">Superficie (m²)</font></label>';
##echo '<div class="col-sm-3">';
##echo '<input type="number" class="form-control" id="superficie_establecimiento" name="superficie_establecimiento" value="'.$superficie_establecimientoDB.'" required>';
##echo '</div>';
//##
##echo '<label for="capacidad_comensales_personas" class="col-sm-2 control-label"><font color="black">Capacidad Comensales</font></label>';
##echo '<div class="col-sm-3">';
##echo '<input type="number" class="form-control" id="capacidad_comensales_personas" name="capacidad_comensales_personas" value="'.$capacidad_comensales_personasDB.'" required>';
##echo '</div>';
##echo '</div>';
###



###

if ( empty($latitudDB) || $latitudDB==''  ) $latitudDB="32.5317397";
if ( empty($longitudDB) || $longitudDB==''  ) $longitudDB="-117.019529";

echo '<div class="mb-3 row">';
echo '<label for="latitud" class="col-sm-2 col-form-label"><font color="black">Latitud</font><br><font size="2" color="blue">Ej: 32.5317397</font></label>';
echo '<div class="col-sm-2">';
echo '<input type="text" class="form-control required" title="Enter Latitud ( 32.5317387 )"  pattern="(32\.)[\d]{6,}"  id="latitud" name="latitud" maxlength="12" autocomplete="off" value="'.$latitudDB.'"  required>';
echo '</div>';
//##
echo '<label for="longitud" class="col-sm-2 col-form-label"><font color="black">Longitud</font><br><font size="2" color="blue">Ej: -117.019529</font></label>';
echo '<div class="col-sm-2">';
echo '<input type="text" class="form-control required"  title="Enter Longitud (-117.019529)"   pattern="(-)(116|117)(\.)[\d]{6,}" id="longitud" name="longitud" maxlength="12" autocomplete="off" value="'.$longitudDB.'"  required>';
echo '</div>';
echo '</div>';
###
echo '<div class="mb-3">';
echo '<div class="alert alert-info" role="alert">';
echo '<i class="bi bi-info-circle"></i> <strong>Instrucciones del Mapa:</strong> ';
echo 'Haga clic en cualquier punto del mapa para actualizar las coordenadas, o arrastre el marcador rojo a la ubicación exacta del establecimiento.';
echo '</div>';
echo '</div>';
echo '<div id="map" class="map" style="height:400px; width:100%;background-color: powderblue;"></div>';
##echo '<iframe id="map" src="mapaMarcaCoordenadas.php" height="200px" width="100%"></iframe>';
###
echo '<br>';
echo '<br>';
echo '<div class="form-group row" style="background-color:#ECECEC;color:black">';
echo '<label for="observacion_1" class="col-sm-4 control-label"><font size="1">INSTITUCIONES EDUCATIVAS, CENTROS RELIGIOSOS, DEPORTIVOS, HOSPITALES, ETC. ARTICULO 20 FRACCION V Y ARTICULO 39 DEL REGLAMENTO PARA LA VENTA, ALMACENAJE Y  CONSUMO DE BEBIDAS ALCOHOLICAS PARA EL MUNICIPIO DE TIJUANA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_1_cumple' id='observacion_1_cumple' required>";
echo '<option value="'.$observacion_1_cumple.'" selected>'.$observacion_1_cumple.'</option>';
echo '<option value="NO">NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_1_datos" name="observacion_1_datos"   maxlength="1000" rows="3" >'.$observacion_1_datos.'</textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_1_metros" name="observacion_1_metros"  value="'.$observacion_1_metros.'">';


echo '</div>';
echo '</div>';

###
###
###
echo '<br>';
echo '<div class="form-group row">';
echo '<label for="observacion_2" class="col-sm-4 control-label"><font size="1" color="black">ZONAS HABITACIONALES, ESCOLARES Y/O FABRILES. ARTICULO 22 DEL REGLAMENTO DE LA MATERIA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2' color='black'><b>Cumple</b></font><select class='form-control form-select' name='observacion_2_cumple' id='observacion_2_cumple' required>";
echo '<option value="'.$observacion_2_cumple.'" selected>'.$observacion_2_cumple.'</option>';
echo '<option value="NO">NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2" color="black"><b>Dato</b></font><textarea class="form-control" id="observacion_2_datos" name="observacion_2_datos"   maxlength="1000" rows="3" >'.$observacion_2_datos.'</textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1" color="black"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_2_metros" name="observacion_2_metros"  value="'.$observacion_2_metros.'">';


echo '</div>';
echo '</div>';
###
###
echo '<br>';
echo '<div class="form-group row"  style="background-color:#ECECEC;color:black">';
echo '<label for="observacion_3" class="col-sm-4 control-label"><font size="1">MISMO GIRO ARTICULO 20 FRACCION IV DE LA LEY Y ARTICULO 39 DEL REGLAMENTO DE LA MATERIA U OTROS GIROS</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_3_cumple' id='observacion_3_cumple' required>";
echo '<option value="'.$observacion_3_cumple.'" selected>'.$observacion_3_cumple.'</option>';
echo '<option value="NO">NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_3_datos" name="observacion_3_datos"   maxlength="1000" rows="3"  >'.$observacion_3_datos.'</textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_3_metros" name="observacion_3_metros"  value="'.$observacion_3_metros.'">';


echo '</div>';
echo '</div>';
###
###
echo '<br>';
echo '<div class="form-group row">';
echo '<label for="observacion_4" class="col-sm-4 control-label"><font size="1" color="black">COMUNICACION DIRECTA CON VIVIENDA O ALGUN ESTABLECIMIENTO MERCANTIL, ARTICULO 24 DE LA LEY DE LA METERIA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2' color='black'><b>Cumple</b></font><select class='form-control form-select' name='observacion_4_cumple' id='observacion_4_cumple' required>";
echo '<option value="'.$observacion_4_cumple.'" selected>'.$observacion_4_cumple.'</option>';
echo '<option value="NO">NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2" color="black"><b>Dato</b></font><textarea class="form-control" id="observacion_4_datos" name="observacion_4_datos"   maxlength="1000" rows="3"  >'.$observacion_4_datos.'</textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1" color="black"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_4_metros" name="observacion_4_metros"  value="'.$observacion_4_metros.'">';


echo '</div>';
echo '</div>';
###
###
echo '<br>';
echo '<div class="form-group row"  style="background-color:#ECECEC;color:black">';
echo '<label for="observacion_5" class="col-sm-4 control-label"><font size="1">COLOCACION DEL AVISO PUBLICO ARTICULO 26 Y 27 DEL REGLAMENTO PARA LA VENTA, ALMACENAJE Y CONSUMO DE BEBIDAS ALCOHOLICAS PARA EL MUNICIPIO DE TIJUANA Y ARTICULO 21 DE LA LEY DE LA MATERIA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_5_cumple' id='observacion_5_cumple' required>";
echo '<option value="'.$observacion_5_cumple.'" selected>'.$observacion_5_cumple.'</option>';
echo '<option value="NO">NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_5_datos" name="observacion_5_datos"   maxlength="1000" rows="3"  >'.$observacion_5_datos.'</textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_5_metros" name="observacion_5_metros"  value="'.$observacion_5_metros.'">';


echo '</div>';
echo '</div>';


##




echo '<br>';
echo '<div class="mb-3 row">';
echo '<label for="observaciones" class="col-sm-2 col-form-label"><font size="2" color="black"><b>Observaciones Generales</b></font></label>';
echo '<div class="col-sm-9">';
echo '<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" rows="3">'.$observaciones.'</textarea>';
echo '</div>';
echo '</div>';



?>


<div class="alert alert-info">
  <i class="bi bi-info-circle"></i> <font size="1" color="red">Asegúrese de completar todos los campos con información precisa de la inspección.</font>
</div>


		  </div>
		  <div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal"><font size="2"> Cerrar</font></button>
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_inspeccion"  style="background-color:#AC905B;color:black"><font size="2"> Registrar Inspección </font></button>
		  </div>
		  </form>
<font size="1" color="white">modal/efectuar_inspeccion.php-(Button_registro_guardar_inspeccion)->ajax/registro_guardar_inspeccion.php</font>
		</div>
	  </div>
	</div>

<!--
 <script src="js/mapaLatLon.js"></script>
 <script src="js/simple_mapa.js"></script>
-->

	<?php
		}
?>


<script>
$(document).ready(function(){
  var map; // Variable global para el mapa
  var marker; // Variable global para el marcador
  
  // Evento cuando el modal se abre completamente
  $('#EfectuarInspeccion').on('shown.bs.modal', function () {
    var msgInfo;
    <?php
    echo 'var Lat="'.$latitudDB.'";';
    echo 'var Lon="'.$longitudDB.'";';
    ?>
    
    // Mostrar indicador de carga
    $('#map').html('<div class="d-flex justify-content-center align-items-center" style="height: 400px;"><div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div><p class="mt-2">Cargando mapa...</p></div></div>');
    
    // Si el mapa ya existe, destruirlo primero
    if (map) {
      map.remove();
    }
    
    // Crear el mapa después de un pequeño delay para mostrar el loading
    setTimeout(function() {
      // Limpiar el contenido de loading
      $('#map').empty();
      
      // Crear el mapa
      map = L.map("map").setView([Lat, Lon], 14);
      
      // Agregar la capa de tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: 'Map data &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://cloudmade.com">CloudMade</a>',
          maxZoom: 18
      }).addTo(map);
      
      // Crear el marcador
      marker = L.marker([Lat, Lon], {
          draggable: true
      }).addTo(map);
      
      // Forzar que el mapa se redimensione correctamente
      setTimeout(function() {
          map.invalidateSize();
          map.setView([Lat, Lon], 14);
      }, 200);
      
      // Evento cuando se arrastra el marcador
      marker.on('dragend', function (e) {
        document.getElementById('latitud').value = marker.getLatLng().lat.toFixed(7);
        document.getElementById('longitud').value = marker.getLatLng().lng.toFixed(6);
        msgInfo = "Lat (" + marker.getLatLng().lat.toFixed(7) + "), Lon (" + marker.getLatLng().lng.toFixed(6) + ")";
        marker.bindPopup(msgInfo).openPopup();
      });
      
      // Evento cuando se hace clic en el mapa
      map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(6);
        
        // Mover el marcador a la nueva posición
        marker.setLatLng([lat, lng]);
        
        // Actualizar los campos de latitud y longitud
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        
        // Mostrar popup con las nuevas coordenadas
        msgInfo = "Lat (" + lat + "), Lon (" + lng + ")";
        marker.bindPopup(msgInfo).openPopup();
      });
      
      // Mostrar popup inicial
      msgInfo = "Lat (" + Lat + "), Lon (" + Lon + ")";
      marker.bindPopup(msgInfo).openPopup();
      
    }, 100); // Delay mínimo para mostrar el loading
    
  });
  
  // Limpiar el mapa cuando se cierre el modal
  $('#EfectuarInspeccion').on('hidden.bs.modal', function () {
    if (map) {
      map.remove();
      map = null;
    }
  });
  
  // Evento del botón para abrir el modal
  $("#myBtn").click(function(){
    // Solo obtener los datos de inspección, el mapa se inicializará con el evento shown.bs.modal
  });
});
</script>


<script>


$( "#registro_guardar_inspeccion" ).submit(function( event ) {
  $('#Button_registro_guardar_inspeccion').attr("disabled", true);

 var parametros = $(this).serialize();
         $.ajax({
                        type: "POST",
                        url: "ajax/registro_guardar_inspeccion.php",
                        data: parametros,
                         beforeSend: function(objeto){
                                $("#resultados_ajaxInspeccion").html("Mensaje: Cargando...");
                          },
                        success: function(datos){
                        $("#resultados_ajaxInspeccion").html(datos);
                        $('#Button_registro_guardar_inspeccion').attr("disabled", true);
                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
<?php
//location.replace('principal.php');
echo "location.replace('principal.php?page=".$page."&action=ajax');";
?>

                        }, 2000);

                  }
        });
  event.preventDefault();
});


</script>







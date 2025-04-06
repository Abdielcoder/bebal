
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
} else {
$IDPRINCIPAL=$_POST['IDPRINCIPAL'];
$page=$_POST['page'];
}
#################################
#################################
// move_uploaded_file
if (isset($_POST['subirnuevafoto'])) {

include("functions_hm.php");
$IDPRINCIPAL=$_POST["IDPRINCIPAL"];
	
$queryINSERTA="INSERT INTO fotos (descripcion,idprincipal) VALUES ('Inserta Row, idprincipal=".$IDPRINCIPAL."',".$IDPRINCIPAL.");";
if (!mysqli_query($con,$queryINSERTA)) echo mysqli_error();
$queryMAXidfoto="SELECT MAX(idfoto) AS idfoto FROM fotos;";
$resultMAXidfoto = mysqli_query($con,$queryMAXidfoto);
$row=mysqli_fetch_assoc($resultMAXidfoto);
$nextidf=$row['idfoto'];



	$filename=$IDPRINCIPAL.'-'.$nextidf.'.jpg';
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
$queryUPDATE="UPDATE fotos SET descripcion='OK' WHERE idfoto=".$nextidf." AND idprincipal=".$IDPRINCIPAL;
if (!mysqli_query($con,$queryUPDATE)) echo mysqli_error();

##$queryNF="INSERT INTO fotos (idfoto,descripcion,idvalla) VALUES (".$nextidf.",'',".$IDVALLA.");";
##if (!mysqli_query($con,$queryNF)) echo mysqli_error();
##$insertID1=mysqli_insert_id($con);	
###
	
// Si hay una sola la establece como principal
$sqlFotosCuantosReg="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL;
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
$sqlFotosCuantosReg1="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL;
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
$sqlFotosCuantosReg2="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL;
$resultFotosCuantosReg2 = mysqli_query($con, $sqlFotosCuantosReg2);
$rowsFotosCuantosReg2 = mysqli_num_rows($resultFotosCuantosReg2);
for ($i=0;$i<$rowsFotosCuantosReg2;$i++) {
	if (isset($_POST['eliminar'.$i])) {
		$IDFOTO=$_POST['idfoto'.$i];
		$sqlUpdate2="DELETE FROM fotos WHERE idfoto=".$IDFOTO;
		mysqli_query($con, $sqlUpdate2);
// Si hay una sola la establece como principal
$sqlFotosCuantosReg="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL;
$resultFotosCuantosReg = mysqli_query($con, $sqlFotosCuantosReg);
$rowsFotosCuantosReg = mysqli_num_rows($resultFotosCuantosReg);

// Si NO hay fotos NULL
if ($rowsFotosCuantosReg==0) {
$sqlUpdate4="UPDATE principal SET foto=NULL WHERE id=".$IDPRINCIPAL;
mysqli_query($con, $sqlUpdate4);
} else {
$sqlFotos1="SELECT * FROM fotos WHERE idprincipal=".$IDPRINCIPAL;
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

#################################
#################################


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

$domicilio_establecimiento=$calle_establecimiento." #".$numero_establecimiento." ".$numerointerno_local_establecimiento." CP ".$cp_establecimiento.", ".$COLONIA." (".$DELEGACION.") ".$MUNICIPIO;

echo "<h6><b>Modificar Fotos :</b> ".$folioDB.", ".$nombre_comercial_establecimientoDB." (".$GIRO."), ".$domicilio_establecimiento."</h5>";
##############################
/* Agregar foto */
$ret="";
if (!isset($errorfoto)) $errorfoto="";

$ret .= '<form ENCTYPE="multipart/form-data" name="subirnuevafoto" action="principalFotos.php" method="POST">';

###
$ret .='<h6><u>Subir Foto</u></h6>';
$ret .='<table width="70%" border=0 align=center>';
$ret .='<tr><td>';
$ret .= "<input type=\"file\"  name=\"nuevafoto\" class='choose'>";
$ret .= "<input type=\"hidden\" name=\"prim\" value=\"yaentro\">";
$ret .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"7000000\">";
$ret .= "<input type=\"hidden\" name=\"IDPRINCIPAL\" value=\"".$IDPRINCIPAL."\">";
$ret .= "<input type=\"hidden\" name=\"page\" value=\"".$page."\">";
$ret .='</td><td align=center>';

$ret .='<button name="subirnuevafoto" class="btn btn-primary" type="submit" title="Subir Fotografia" class="button" style="color:black;" /><i class="glyphicon glyphicon-upload"></i><font color="white">&nbsp;&nbsp;Subir Fotografia</font></button>';

$ret .='</td><td>';
//$ret .= '<a type="button" class="btn btn-default" href="vallas.php?pagina='.$page.'"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</a>';

$ret .='</td></tr>';
$ret .='</table>';
$ret .='<table width="80%" border=1 align=center>';
$ret .='<tr><td bgcolor=red>';
$ret .= "<span class=\"error\" >$errorfoto</span>";
$ret .='</td></tr>';
$ret .='</table>';
echo $ret;
echo '<br><br>';
##############################
$foto_file='../'.FOTOSMEDIAS.$IDPRINCIPAL.'-'.$foto_principalDB.'.jpg';
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

$sqlFotos="SELECT * FROM fotos f WHERE f.idprincipal=".$IDPRINCIPAL." ORDER BY f.idfoto;";
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
$foto_fileSecundaria='../'.FOTOSMEDIAS.$IDPRINCIPAL.'-'.$idfoto_db.'.jpg';
if ( file_exists($foto_fileSecundaria)!=1 ) echo '<img class="item-img img-responsive" src="img/no_imagen.jpg" alt="" alt=""  style="width:50px;height:50px;">';
else {
echo '<img id="myImg" src="'.$foto_fileSecundaria.'" alt="Principal  '.$folioDB.' / '.$numero_permisoDB.'  ('.$direccionDB.')"  style="width:90px;height:70px;">';
}
echo "</td>";
#########
echo '<input type="hidden" name="idfoto'.$i.'" value="'.$idfoto_db.'" />';
#
echo '<td align=center>';
echo '<button id="eliminar'.$i.'" name="eliminar'.$i.'" type="submit" title="Eliminar Fotografia '.$numero_foto.'" class="button" style="color:red;"  /><i class="bi bi-trash"></i> </button>';
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

echo '<br>';
echo '<FORM action="principal.php" name="ir_aPrincipal" method="POST">';
echo '<input type="hidden" name="pagina" value="'.$page.'">';

echo '<button class="btn btn-info" name="ir_aPrincipal" type="submit" title="Regresar" class="button" style="background-color:#FFFFFF;"  /><i class="bi bi-arrow-left"></i><font color="black">&nbsp;&nbsp;Regresar</font></button>';




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



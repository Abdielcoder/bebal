<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$per_page = 3; //how much records you want to show

echo '<style>';

echo '.modal_Emergente1 {';
echo 'display: none;';
echo 'position: fixed;';
echo 'z-index: 1;';
echo 'padding-top: 100px;';
echo 'left: 0;';
echo 'top: 0;';
echo 'width: 100%;';
echo 'height: 100%;';
echo 'overflow: auto;';
echo 'background-color: rgb(0,0,0);';
echo 'background-color: rgba(0,0,0,0.4);';
echo '}';

echo '.modal_Emergente1-content {';
echo 'background-color: #cccccc;';
echo 'margin: auto;';
echo 'padding: 20px;';
echo 'border: 1px solid #888;';
echo 'width: 60%;';
echo '}';

echo '.close_Emergente1 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente1:hover,';
echo '.close_Emergente1:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

########################
########################
echo '.close_Emergente1_1 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente1_1:hover,';
echo '.close_Emergente1_1:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

echo '.close_Emergente1_2 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente1_2:hover,';
echo '.close_Emergente1_2:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

echo '.close_Emergente1_3 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente1_3:hover,';
echo '.close_Emergente1_3:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';


###############################
###############################
echo '.modal_Emergente2 {';
echo 'display: none;';
echo 'position: fixed;';
echo 'z-index: 1;';
echo 'padding-top: 100px;';
echo 'left: 0;';
echo 'top: 0;';
echo 'width: 100%;';
echo 'height: 100%;';
echo 'overflow: auto;';
echo 'background-color: rgb(0,0,0);';
echo 'background-color: rgba(0,0,0,0.4);';
echo '}';

echo '.modal_Emergente2-content {';
echo 'background-color: #cccccc;';
echo 'margin: auto;';
echo 'padding: 20px;';
echo 'border: 1px solid #888;';
echo 'width: 60%;';
echo '}';

echo '.close_Emergente2 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente2:hover,';
echo '.close_Emergente2:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

########################
########################
echo '.close_Emergente2_1 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente2_1:hover,';
echo '.close_Emergente2_1:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

echo '.close_Emergente2_2 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente2_2:hover,';
echo '.close_Emergente2_2:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

echo '.close_Emergente2_3 {';
echo 'color: #aaaaaa;';
echo 'float: right;';
echo 'font-size: 28px;';
echo 'font-weight: bold;';
echo '}';

echo '.close_Emergente2_3:hover,';
echo '.close_Emergente2_3:focus {';
echo 'color: #000;';
echo 'text-decoration: none;';
echo 'cursor: pointer;';
echo '}';

###############################
###############################
?>

#myImg1 {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg2 {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg3 {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg1:hover {opacity: 0.7;}
#myImg2:hover {opacity: 0.7;}
#myImg3:hover {opacity: 0.7;}



/* The Modal (background) */
.modalFoto {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-contentFoto {
  margin: auto;
  display: block;
  width: 60%;
  max-width: 500px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-contentFoto, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.closeFoto1 {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

/* The Close Button */
.closeFoto2 {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

/* The Close Button */
.closeFoto3 {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.closeFoto1:hover,
.closeFoto1:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

.closeFoto2:hover,
.closeFoto2:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

.closeFoto3:hover,
.closeFoto3:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-contentFoto {
    width: 100%;
  }
}


<?php
echo '</style>';

######################################
######################################

echo '<script>';

//##var modal_Emergente1 = document.getElementById("myModal_Emergente1");
//##var btn1=document.getElementById("myBtn1");
//##var spanCierra1 = document.getElementsByClassName("close_Emergente1")[0];

//##btn1.onclick = function() {
//##modal_Emergente1.style.display = "block";
//##}
//##spanCierra1.onclick = function() {
//##modal_Emergente1.style.display = "none";
//##}

//##window.onclick = function(event) {
//##if (event.target == modal_Emergente1) {
//##modal_Emergente1.style.display = "none";
//##}
//##}

//##var modal_Emergente2 = document.getElementById("myModal_Emergente2");
//##var btn2 = document.getElementById("myBtn2");
//##var spanCierra2 = document.getElementsByClassName("close_Emergente2")[0];

//##btn2.onclick = function() {
//##modal_Emergente2.style.display = "block";
//##}

//##spanCierra2.onclick = function() {
//## modal_Emergente2.style.display = "none";
//##}

//##window.onclick = function(event) {
//##if (event.target == modal_Emergente2) {
//##modal_Emergente2.style.display = "none";
//##}
//##}

?>

var modal_Emergente1_1 = document.getElementById("myModal_Emergente1_1");
var btn1_1=document.getElementById("myBtn1_1");
var spanCierra1_1 = document.getElementsByClassName("close_Emergente1_1")[0];

btn1_1.onclick = function() {
modal_Emergente1_1.style.display = "block";
}
spanCierra1_1.onclick = function() {
modal_Emergente1_1.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal_Emergente1_1) {
modal_Emergente1_1.style.display = "none";
}
}

var modal_Emergente1_2 = document.getElementById("myModal_Emergente1_2");
var btn1_2=document.getElementById("myBtn1_2");
var spanCierra1_2 = document.getElementsByClassName("close_Emergente1_2")[0];

btn1_2.onclick = function() {
modal_Emergente1_2.style.display = "block";
}
spanCierra1_2.onclick = function() {
modal_Emergente1_2.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal_Emergente1_2) {
modal_Emergente1_2.style.display = "none";
}
}

var modal_Emergente1_3 = document.getElementById("myModal_Emergente1_3");
var btn1_3=document.getElementById("myBtn1_3");
var spanCierra1_3 = document.getElementsByClassName("close_Emergente1_3")[0];

btn1_3.onclick = function() {
modal_Emergente1_3.style.display = "block";
}
spanCierra1_3.onclick = function() {
modal_Emergente1_3.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal_Emergente1_3) {
modal_Emergente1_3.style.display = "none";
}
}





var modal_Emergente2_1 = document.getElementById("myModal_Emergente2_1");
var btn2_1=document.getElementById("myBtn2_1");
var spanCierra2_1 = document.getElementsByClassName("close_Emergente2_1")[0];

btn2_1.onclick = function() {
modal_Emergente2_1.style.display = "block";
}
spanCierra2_1.onclick = function() {
modal_Emergente2_1.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal_Emergente2_1) {
modal_Emergente2_1.style.display = "none";
}
}



var modal_Emergente2_2 = document.getElementById("myModal_Emergente2_2");
var btn2_2=document.getElementById("myBtn2_2");
var spanCierra2_2 = document.getElementsByClassName("close_Emergente2_2")[0];

btn2_2.onclick = function() {
modal_Emergente2_2.style.display = "block";
}
spanCierra2_2.onclick = function() {
modal_Emergente2_2.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal_Emergente2_2) {
modal_Emergente2_2.style.display = "none";
}
}

var modal_Emergente2_3 = document.getElementById("myModal_Emergente2_3");
var btn2_3=document.getElementById("myBtn2_3");
var spanCierra2_3 = document.getElementsByClassName("close_Emergente2_3")[0];

btn2_3.onclick = function() {
modal_Emergente2_3.style.display = "block";
}
spanCierra2_3.onclick = function() {
modal_Emergente2_3.style.display = "none";
}

window.onclick = function(event) {
if (event.target == modal_Emergente2_3) {
modal_Emergente2_3.style.display = "none";
}
}




</script>



<?php
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_vallas=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * FROM vallas WHERE estatus!='ELIMINADO' AND id=".$id_vallas);
		$count=mysqli_num_rows($query);
		if ($count!=0){
			##if ($delete1=mysqli_query($con,"DELETE FROM vallas WHERE id=".$id_vallas)){
			if ($delete1=mysqli_query($con,"UPDATE vallas SET estatus='ELIMINADO', operacion='ELIMINADO' WHERE id=".$id_vallas)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Registro Eliminado Exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar Registro de la Valla. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('direccion');//Columnas de busqueda
		 $sTable = "vallas";
	 	 if ( $ID_MUNICIPIO==0 ) $sWhere = "  estatus!='ELIMINADO' ";
		 else $sWhere = " WHERE  estatus!='ELIMINADO' AND id_municipio=".$ID_MUNICIPIO;
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE  estatus!='ELIMINADO' AND id_municipio=".$ID_MUNICIPIO."  AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by id_municipio, id";
		//echo $sWhere;
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './vallas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th width="20%"><font size="1">Datos Generales</font></th>
					<th width="30%"><font size="1">Dirección</font></th>
<?php
##<th><font size="1" width="15%">Fecha Alta</font></th>
?>
					<th width="30%"><font size="1">Descripción</font></th>
					<th  width="20%"><font size="1">Acciones</font></th>
					
				</tr>
				<?php
				$ciclo=1;
				while ($row=mysqli_fetch_array($query)) {
					$id=$row['id'];
					$valla_id=$row['id'];
					$folio=$row['folio'];
					$numero_permiso=$row['numero_permiso'];
					$estatus=$row['estatus'];
					$operacion=$row['operacion'];
					$dimension_id=$row['dimension_id'];
					$direccion=$row['direccion'];
					$descripcion=$row['descripcion'];
					$fecha_alta=$row['fecha_alta'];
					$id_municipio=$row['id_municipio'];
					$delegacion_id=$row['id_delegacion'];
					$foto=$row['foto'];
					$video_url=htmlspecialchars($row['video_url']);
					$VIDEO_URL=$row['video_url'];
					$MAPA=htmlspecialchars($row['mapa']);

##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
$result_municipio = mysqli_query($con,$sql_municipio);
$row_municipio = mysqli_fetch_assoc($result_municipio);
$MUNICIPIO=$row_municipio['municipio'];
##
$sql_dimension="SELECT * FROM dimensiones WHERE id=".$dimension_id;
$result_dimension=mysqli_query($con,$sql_dimension);
$row_dimension=mysqli_fetch_assoc($result_dimension);
$DIMENSION=$row_dimension['dimension'];
if ( $DIMENSION==NULL OR $DIMENSION=='' ) $DIMENSION=0;
##
$sql_delegacion="SELECT delegacion FROM delegacion WHERE id=".$delegacion_id;
$result_delegacion = mysqli_query($con,$sql_delegacion);
$row_delegacion = mysqli_fetch_assoc($result_delegacion);
$DELEGACION=$row_delegacion['delegacion'];
##


echo '<input type="hidden" value="'.$valla_id.'" id="ID_VALLA" name="ID_VALLA">';
echo '<input type="hidden" value="'.$folio.'" id="folio'.$valla_id.'">';
echo '<input type="hidden" value="'.$numero_permiso.'" id="numero_permiso'.$valla_id.'">';
echo '<input type="hidden" value="'.$estatus.'" id="estatus'.$valla_id.'">';
echo '<input type="hidden" value="'.$operacion.'" id="operacion'.$valla_id.'">';
echo '<input type="hidden" value="'.$direccion.'" id="direccion'.$valla_id.'">';
echo '<input type="hidden" value="'.$descripcion.'" id="descripcion'.$valla_id.'">';
echo '<input type="hidden" value="'.$video_url.'" id="video_url'.$valla_id.'">';
echo '<input type="hidden" value="'.$MAPA.'" id="mapa'.$valla_id.'">';
echo '<input type="hidden" value="'.$dimension_id.'" id="dimension'.$valla_id.'">';
echo '<input type="hidden" value="'.$delegacion_id.'" id="delegacion'.$valla_id.'">';

echo '<tr>';
##########
echo '<td>';
#################
###  FOTO
#################
$foto_file='../../'.FOTOSMEDIAS.$id.'-'.$foto.'.jpg';
if ( $foto==NULL || $foto=='' )
echo '<img  id="myImg'.$ciclo.'"  class="item-img img-responsive" src="img/no_imagen.jpg" alt="No Existe Foto" style="width:50px;height:50px;">';
else {
	if ( file_exists($foto_file)!=1 ) echo '<img class="item-img img-responsive"  id="myImg'.$ciclo.'"  src="img/no_imagen.jpg" alt="No Existe Foto" style="width:50px;height:50px;">';
	else {
	echo '<img id="myImg'.$ciclo.'"  class="item-img img-responsive"  src="'.$foto_file.'" alt="Valla  '.$folio.' / '.$numero_permiso.'  ('.$direccion.')" style="width:110px;height:80px;">';
	}
}

echo '<font size="1">('.$id.') <b>'.$DIMENSION.'</b></font><br><font color="red" size="1">'.$estatus.'</font><font color="black" size="1"> '.$fecha_alta.'</font><br><font color="blue" size="1">'.$operacion.'</font><BR><font size="1">'.$folio.'/'.$numero_permiso.'</font>';
echo '</td>';
##########
echo '<td><font size="1">'.$direccion.'<br><u>Delegación: </u>'.$DELEGACION.'('.$MUNICIPIO.')</font></td>';
##########

//echo '<td ><font size="1">'.$fecha_alta.'</font></td>';

##if ( strlen($descripcion)>150 ) echo '<td><font size="1">'.substr($descripcion,0,150).'...More</font></td>';
##else {
echo '<td><font size="1">'.$descripcion.'</font></td>';
##}
?>
						
					<td class='text-right'>


<?php

echo '<button id="myBtn1_'.$ciclo.'" title="Video Youtube"><i class="glyphicon glyphicon-facetime-video"></i></button>';
echo '<div id="myModal_Emergente1_'.$ciclo.'" class="modal_Emergente1">';
echo '<div class="modal_Emergente1-content">';
echo '<span class="close_Emergente1_'.$ciclo.'">&times;</span>';

echo '<p><font color="black" size="2">Folio ('.$folio.'), Número de Permiso ('.$numero_permiso.')</font></p>';
echo '<table width="90%"><tr>';
echo '<td width="80%">';
if ( $VIDEO_URL=='' || $VIDEO_URL==NULL ) echo '<font size=6><b>NO EXISTE VIDEO</b></font>';
else echo $VIDEO_URL;
echo '</td>';
echo '<td width="20%"></td>';
echo '</tr></table>';
echo '</div>';
echo '</div>';


echo '<button id="myBtn2_'.$ciclo.'" title="Mapa Google Maps"><i class="glyphicon glyphicon-map-marker"></i></button>';
echo '<div id="myModal_Emergente2_'.$ciclo.'" class="modal_Emergente2">';
echo '<div class="modal_Emergente2-content">';
echo '<span class="close_Emergente2_'.$ciclo.'">&times;</span>';

echo '<p><font color="black" size="2">Folio ('.$folio.'), Número de Permiso ('.$numero_permiso.')<br>'.$direccion.'</font></p>';
echo '<table width="90%"><tr>';
echo '<td width="80%">';
if ( $row['mapa']=='' || $row['mapa']==NULL ) echo '<font size=6><b>NO EXISTE INFORMACION</b></font>';
else echo $row["mapa"];
echo '</td>';
echo '<td width="20%">';
echo '</td>';
echo '</tr></table>';
echo '</div>';
echo '</div>';


##echo '<a href="#editarFoto'.$row["id"].'" data-toggle="modal"  class="btn btn-default" title="Foto"> <i class="glyphicon glyphicon-camera"></i></a>';
##include('../modal/editar_foto.php');

echo '<a href="vallaFotos.php?id='.$row["id"].'" class="btn btn-default" title="Galerias de Fotos Valla"> <i class="glyphicon glyphicon-camera"></i></a>';
?>

<a href="#" class='btn btn-default' title='Editar Valla' onclick="obtener_datos('<?php echo $valla_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 

<a href="#" class='btn btn-default' title='Programar Dias' onclick="obtener_datos('<?php echo $valla_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-cog"></i></a> 

<a href="#" class='btn btn-default' title='Cambiar Estatus' onclick="obtener_datos('<?php echo $valla_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-screenshot"></i></a> 

<a href="#" class='btn btn-warning' title='Borrar Registro de la Valla' onclick="eliminar('<?php echo $valla_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					</td>
						
					</tr>
<?php
	echo '<div id="myModalFoto'.$ciclo.'" class="modalFoto">';
  	echo '<span class="closeFoto'.$ciclo.'">&times;</span>';
  	echo '<img class="modal-contentFoto" id="img0'.$ciclo.'">';
  	echo '<div id="caption"></div>';
	echo '</div>';
$ciclo++;
}   //**  WHILE PRINCIPAL
###################
###################
## Para completar ROWS que hagan falta
if ( ($ciclo-1)==$per_page ) {
##echo "Ciclo Completado";
} else {
$faltaron=($per_page-$ciclo)+1;
echo "Faltaron $faltaron Registros, Arranco ( $ciclo )";
for ( $b=$ciclo; $b<=$per_page; $b++ ) {

###########################
echo '<input type="hidden" value="0" id="ID_VALLA" name="ID_VALLA">';
echo '<input type="hidden" value="0" id="folio'.$b.'">';
echo '<input type="hidden" value="0" id="numero_permiso'.$b.'">';
echo '<input type="hidden" value="0" id="estatus'.$b.'">';
echo '<input type="hidden" value="0" id="operacion'.$b.'">';
echo '<input type="hidden" value="0" id="direccion'.$b.'">';
echo '<input type="hidden" value="0" id="descripcion'.$b.'">';
echo '<input type="hidden" value="0" id="video_url'.$b.'">';
echo '<input type="hidden" value="0" id="mapa'.$b.'">';
echo '<input type="hidden" value="0" id="dimension'.$b.'">';
###########################

echo '<tr>';
echo '<td><font size="1" color="white">'.$b.'</font>';
echo '<img  id="myImg'.$b.'"  class="item-img img-responsive" src="img/no_imagen.jpg" alt="No Existe Foto" style="width:0px;height:0px;">';
echo '</td>';
echo '<td ><font size="1">-</td>';
echo '<td ><font size="1">-</font></td>';
echo '<td><font size="1">-</font></td>';
echo '<td class="text-right">';

echo '<button id="myBtn1_'.$b.'" title="Video Youtube"><i class="glyphicon glyphicon-facetime-video"  disabled></i></button>';
echo '<div id="myModal_Emergente1_'.$b.'" class="modal_Emergente1">';
echo '<div class="modal_Emergente1-content">';
echo '<span class="close_Emergente1_'.$b.'">&times;</span>';
echo '<center><font size=6><b>NO EXISTE REGISTRO</b></font></center>';
echo '</div>';
echo '</div>';

echo '<button id="myBtn2_'.$b.'" title="Mapa Google Maps"><i class="glyphicon glyphicon-map-marker"  disabled></i></button>';
echo '<div id="myModal_Emergente2_'.$b.'" class="modal_Emergente2">';
echo '<div class="modal_Emergente2-content">';
echo '<span class="close_Emergente2_'.$b.'">&times;</span>';
echo '<center><font size=6><b>NO EXISTE REGISTRO</b></font></center>';
echo '</div>';
echo '</div>';

echo '</td>';
echo '</tr>';


echo '<div id="myModalFoto'.$b.'" class="modalFoto">';
echo '<span class="closeFoto'.$b.'">&times;</span>';
echo '<img class="modal-contentFoto" id="img0'.$b.'">';
echo '<div id="caption"></div>';
echo '</div>';

}
}

				?>
				<tr>
					<td colspan=4><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
<?php


		}
	}
?>

<script>
var modalImagen1 = document.getElementById("myModalFoto1");
var modalImagen2 = document.getElementById("myModalFoto2");
var modalImagen3 = document.getElementById("myModalFoto3");

var img1 = document.getElementById("myImg1");
var img2 = document.getElementById("myImg2");
var img3 = document.getElementById("myImg3");

var modalImg01 = document.getElementById("img01");
var modalImg02 = document.getElementById("img02");
var modalImg03 = document.getElementById("img03");

var captionText = document.getElementById("caption");

img1.onclick = function(){
  modalImagen1.style.display = "block";
  modalImg01.src = this.src;
  captionText.innerHTML = this.alt;
}

img2.onclick = function(){
  modalImagen2.style.display = "block";
  modalImg02.src = this.src;
  captionText.innerHTML = this.alt;
}

img3.onclick = function(){
  modalImagen3.style.display = "block";
  modalImg03.src = this.src;
  captionText.innerHTML = this.alt;
}



var span1 = document.getElementsByClassName("closeFoto1")[0];
var span2 = document.getElementsByClassName("closeFoto2")[0];
var span3 = document.getElementsByClassName("closeFoto3")[0];

span1.onclick = function() { 
  modalImagen1.style.display = "none";
}

span2.onclick = function() { 
  modalImagen2.style.display = "none";
}

span3.onclick = function() { 
  modalImagen3.style.display = "none";
}
</script>


<?php
##echo '<script>alert("AQUI ");</script>';

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$per_page = 3; //how much records you want to show
?>


<style>

.closeYouTube {
  position:absolute;
  right:-30px;
  top:0;
  z-index:999;
  font-size:2rem;
  font-weight: normal;
  color:#000;
  opacity:1;
}


.mySlides {display: none}
.mySlides1 {display: none}
.mySlides2 {display: none}
.mySlides3 {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 400px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* Position the "prev button" to the left */
.prev {
  left: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot1 {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active1, .dot1:hover {
  background-color: #717171;
}


/* The dots/bullets/indicators */
.dot2 {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active2, .dot2:hover {
  background-color: #717171;
}

/* The dots/bullets/indicators */
.dot3 {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active3, .dot3:hover {
  background-color: #717171;
}





/* Fading animation */
.fadeCarusel {
  animation-name: fadeCarusel;
  animation-duration: 1.5s;
}

@keyframes fadeCarusel {
  from {opacity: .4} 
  to {opacity: 1}
}



/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}

<?php

//##	echo '.modal_Emergente1 {';
//##	echo 'display: none;';
//##	echo 'position: fixed;';
//##	echo 'z-index: 1;';
//##	echo 'padding-top: 100px;';
//##	echo 'left: 0;';
//##	echo 'top: 0;';
//##	echo 'width: 100%;';
//##	echo 'height: 100%;';
//##	echo 'overflow: auto;';
//##	echo 'background-color: rgb(0,0,0);';
//##	echo 'background-color: rgba(0,0,0,0.4);';
//##	echo '}';

//##	echo '.modal_Emergente1-content {';
//##	echo 'background-color: #cccccc;';
//##	echo 'margin: auto;';
//##	echo 'padding: 20px;';
//##	echo 'border: 1px solid #888;';
//##	echo 'width: 60%;';
//##	echo '}';

//##	echo '.close_Emergente1 {';
//##	echo 'color: #aaaaaa;';
//##	echo 'float: right;';
//##	echo 'font-size: 28px;';
//##	echo 'font-weight: bold;';
//##	echo '}';

//##	echo '.close_Emergente1:hover,';
//##	echo '.close_Emergente1:focus {';
//##	echo 'color: #000;';
//##	echo 'text-decoration: none;';
//##	echo 'cursor: pointer;';
//##	echo '}';

########################
########################
//##	echo '.close_Emergente1_1 {';
//##	echo 'color: #aaaaaa;';
//##	echo 'float: right;';
//##	echo 'font-size: 28px;';
//##	echo 'font-weight: bold;';
//##	echo '}';

//##	echo '.close_Emergente1_1:hover,';
//##	echo '.close_Emergente1_1:focus {';
//##	echo 'color: #000;';
//##	echo 'text-decoration: none;';
//##	echo 'cursor: pointer;';
//##	echo '}';

//##	echo '.close_Emergente1_2 {';
//##	echo 'color: #aaaaaa;';
//##	echo 'float: right;';
//##	echo 'font-size: 28px;';
//##	echo 'font-weight: bold;';
//##	echo '}';

//##	echo '.close_Emergente1_2:hover,';
//##	echo '.close_Emergente1_2:focus {';
//##	echo 'color: #000;';
//##	echo 'text-decoration: none;';
//##	echo 'cursor: pointer;';
//##	echo '}';

//##	echo '.close_Emergente1_3 {';
//##	echo 'color: #aaaaaa;';
//##	echo 'float: right;';
//##	echo 'font-size: 28px;';
//##	echo 'font-weight: bold;';
//##	echo '}';

//##	echo '.close_Emergente1_3:hover,';
//##	echo '.close_Emergente1_3:focus {';
//##	echo 'color: #000;';
//##	echo 'text-decoration: none;';
//##	echo 'cursor: pointer;';
//##	echo '}';


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

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}





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


</style>


<script>


<?php

//##	var modal_Emergente1_1 = document.getElementById("myModal_Emergente1_1");
//##	var btn1_1=document.getElementById("myBtn1_1");
//##	var spanCierra1_1 = document.getElementsByClassName("close_Emergente1_1")[0];

//##	btn1_1.onclick = function() {
//##	modal_Emergente1_1.style.display = "block";
//##	}
//##	spanCierra1_1.onclick = function() {
//##	modal_Emergente1_1.style.display = "none";
//##	}

//##	window.onclick = function(event) {
//##	if (event.target == modal_Emergente1_1) {
//##	modal_Emergente1_1.style.display = "none";
//##	}
//##	}

 
//##	var modal_Emergente1_2 = document.getElementById("myModal_Emergente1_2");
//##	var btn1_2=document.getElementById("myBtn1_2");
//##	var spanCierra1_2 = document.getElementsByClassName("close_Emergente1_2")[0];

//##	btn1_2.onclick = function() {
//##	modal_Emergente1_2.style.display = "block";
//##	}
//##	spanCierra1_2.onclick = function() {
//##	modal_Emergente1_2.style.display = "none";
//##	}

//##	window.onclick = function(event) {
//##	if (event.target == modal_Emergente1_2) {
//##	modal_Emergente1_2.style.display = "none";
//##	}
//##	}

//##	var modal_Emergente1_3 = document.getElementById("myModal_Emergente1_3");
//##	var btn1_3=document.getElementById("myBtn1_3");
//##	var spanCierra1_3 = document.getElementsByClassName("close_Emergente1_3")[0];

//##	btn1_3.onclick = function() {
//##	modal_Emergente1_3.style.display = "block";
//##	}
//##	spanCierra1_3.onclick = function() {
//##	modal_Emergente1_3.style.display = "none";
//##	}

//##	window.onclick = function(event) {
//##	if (event.target == modal_Emergente1_3) {
//##	modal_Emergente1_3.style.display = "none";
//##	}
//##	}

?>



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

<script>
window.console = window.console || function(t) {};
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

##############################
##############################
			
//$VIDEO_URL1='https://www.youtube.com/embed/Tos5vaJ4IAM';
//$VIDEO_URL2='https://www.youtube.com/embed/dEp4pyz_G1c';
//$VIDEO_URL3='https://www.youtube.com/embed/nz76eNAJTWU';
  
//<!-- Button trigger modal -->
//echo '<button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="'.$VIDEO_URL1.'" data-target="#myModalYouTube1"> Play Video 1 - autoplay </button>&nbsp;';
  
//<!-- Button trigger modal -->
//echo '<button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="'.$VIDEO_URL2.'" data-target="#myModalYouTube2"> Play Video 2 </button>&nbsp;';
  
  
 //<!-- Button trigger modal -->
//echo '<button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="'.$VIDEO_URL3.'" data-target="#myModalYouTube3"> Play Video 3 </button>&nbsp;';
  
  
//<!-- Button trigger modal -->
//echo '<button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://player.vimeo.com/video/58385453?badge=0&autoplay=1&loop=1" data-target="#myModalYouTube1"> Play Vimeo Video </button>';

##############################
##############################


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
	echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$ciclo.'"><img class="item-img img-responsive" src="img/no_imagen.jpg" alt="No Existe Foto" style="width:50px;height:50px;"></a>';
else {
	if ( file_exists($foto_file)!=1 ) echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$ciclo.'"><img class="item-img img-responsive"   src="img/no_imagen.jpg" alt="No Existe Foto" style="width:50px;height:50px;"></a>';
	else {
	  echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$ciclo.'"><img id="myImg" src="'.$foto_file.'" class="item-img img-responsive" alt="Valla  '.$folio.' / '.$numero_permiso.'  ('.$direccion.')" style="width:110px;height:80px;"></a>';
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


############################
############################
####  VIDEO

//<button type="button" class="btn btn-primary video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/JJUo8Fe3_JY" data-target="#myModal"> Play Video 2 </button>

## https://icons.getbootstrap.com/icons/youtube/

//echo '<button id="myBtn1_'.$ciclo.'" title="Video Youtube"><i class="glyphicon glyphicon-facetime-video"></i></button>';
//##	echo '<button id="myBtn1_'.$ciclo.'" title="Video Youtube"></button>&nbsp;';

echo '<button type="button" data-toggle="modal" class="btn btn-primary video-btn" data-src="'.$VIDEO_URL.'" data-target="#myModalYouTube'.$ciclo.'"  title="Video Youtube" style="background-color: white;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z" fill="red" ></svg></button>&nbsp;';


//##	echo '<div id="myModal_Emergente1_'.$ciclo.'" class="modal_Emergente1">';
//##	echo '<div class="modal_Emergente1-content">';
//##	echo '<span class="close_Emergente1_'.$ciclo.'">&times;</span>';

//##	echo '<p><font color="black" size="2">Folio ('.$folio.'), Número de Permiso ('.$numero_permiso.')</font></p>';
//##	echo '<table width="90%"><tr>';
//##	echo '<td width="80%">';
//##	if ( $VIDEO_URL=='' || $VIDEO_URL==NULL ) echo '<font size=6><b>NO EXISTE VIDEO</b></font>';
//##	else echo $VIDEO_URL;
//##	echo '</td>';
//##	echo '<td width="20%"></td>';
//##	echo '</tr></table>';
//##	echo '</div>';
//##	echo '</div>';

############################
############################
####  MAPA

echo '<button id="myBtn2_'.$ciclo.'" title="Mapa Google Maps"><i class="glyphicon glyphicon-map-marker"></i></button>&nbsp;';
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


############################
############################
####  FOTOS
##echo '<a href="#editarFoto'.$row["id"].'" data-toggle="modal"  class="btn btn-default" title="Foto"> <i class="glyphicon glyphicon-camera"></i></a>';
##include('../modal/editar_foto.php');

echo '<a href="vallaFotos.php?id='.$row["id"].'" class="btn btn-default" title="Galerias de Fotos Valla"> <i class="glyphicon glyphicon-camera"></i></a>';
?>

<a href="#" class='btn btn-default' title='Editar Valla' onclick="obtener_datos('<?php echo $valla_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 

<a href="#" class='btn btn-default' title='Programar Dias' onclick="obtener_datos('<?php echo $valla_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-cog"></i></a> 

<a href="#" class='btn btn-default' title='Cambiar Estatus' onclick="obtener_datos('<?php echo $valla_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-screenshot"></i></a> 

<a href="#" class='btn btn-default' title='Borrar Registro de la Valla' onclick="eliminar('<?php echo $valla_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					</td>
						
					</tr>
<?php
##########################
##########################
###  myCarusel Gallery

echo '<div class="modal fade" id="myCarusel'.$ciclo.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"  align="center">';

echo '<div class="modal-dialog" style="width:450px;">';
echo '<div class="modal-content"  style="background-color: black;">';
echo '<div class="modal-body">';
echo '<h5><font color="white">'.$folio.' / '.$numero_permiso.'  ('.$direccion.')</font></h5>';
#############
echo '<div class="slideshow-container">';

$sqlFotos="SELECT * FROM fotos WHERE idvalla=".$id;

$resultFotos = mysqli_query($con, $sqlFotos);
$rowsFotosCuantos = mysqli_num_rows($resultFotos);
##echo "Ciclo= $ciclo -- Rows Foto = $rowsFotosCuantos <br>";
if ( $rowsFotosCuantos>0 ) {

$NUMERO_FOTO=1;

for ($ii=1;$ii<=$rowsFotosCuantos;$ii++) {
$rowFotos= mysqli_fetch_array($resultFotos,MYSQLI_NUM);
$idfoto_db=$rowFotos[0];
$idvalla_db=$rowFotos[2];
$foto_fileCarusel='../../'.FOTOSMEDIAS.$id.'-'.$idfoto_db.'.jpg';

echo '<div class="mySlides'.$ciclo.' fadeCarusel">';
echo '<div class="numbertext">'.$NUMERO_FOTO.' / '.$rowsFotosCuantos.'</div>';
echo '<img src="'.$foto_fileCarusel.'" style="width:100%">';
echo '<div class="text">Fotografia '.$NUMERO_FOTO.'</div>';
echo '</div>';

$NUMERO_FOTO++;
}
echo '<a class="prev" onclick="plusSlides'.$ciclo.'(-1)">&#10094;</a>';
echo '<a class="next" onclick="plusSlides'.$ciclo.'(1)">&#10095;</a>';

echo '</div>';
echo '<br>';

echo '<div style="text-align:center">';
for ($jj=1;$jj<=$rowsFotosCuantos;$jj++) {

if ( $jj==1 ) echo '<span class="dot'.$ciclo.'" onclick="currentSlide'.$ciclo.'(1)"></span>';
else
echo '<span class="dot'.$ciclo.'" onclick="currentSlide'.$ciclo.'('.$jj.')"></span>';
}
} else {
echo '<div class="mySlides'.$ciclo.' fadeCarusel">';
echo '<div class="numbertext">0 / 0</div>';
echo '<img src="img/no_imagen.jpg" style="width:50%">';
echo '<div class="text">No Existe Fotografia</div>';
echo '</div>';

echo '<a class="prev" onclick="plusSlides'.$ciclo.'(-1)">&#10094;</a>';
echo '<a class="next" onclick="plusSlides'.$ciclo.'(1)">&#10095;</a>';
echo '</div>';
echo '<br>';
echo '<span class="dot'.$ciclo.'" onclick="currentSlide'.$ciclo.'(1)"></span>';

echo '<h4><font color="pink">No Existe Fotografias</font></h4>';
}

echo '</div>';
#############
      
echo '<div class="modal-footer">';
echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
echo '</div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

##############################
##############################

//<!-- Modal Youtube -->
echo '<div class="modal fade" id="myModalYouTube'.$ciclo.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content"  style="background-color: black;">';

echo '<div class="modal-body">';

echo '<button type="button" class="closeYouTube" data-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
//<!-- 16:9 aspect ratio -->
echo '<div class="embed-responsive embed-responsive-16by9">';
echo '<iframe class="embed-responsive-item" src="" id="video'.$ciclo.'"  allowscriptaccess="always" allow="autoplay"></iframe>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
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

//##	echo '<button id="myBtn1_'.$b.'" title="Video Youtube"><i class="glyphicon glyphicon-facetime-video"  disabled></i></button>';
//##	echo '<div id="myModal_Emergente1_'.$b.'" class="modal_Emergente1">';
//##	echo '<div class="modal_Emergente1-content">';
//##	echo '<span class="close_Emergente1_'.$b.'">&times;</span>';
//##	echo '<center><font size=6><b>NO EXISTE REGISTRO</b></font></center>';
//##	echo '</div>';
//##	echo '</div>';

//##	echo '<button id="myBtn2_'.$b.'" title="Mapa Google Maps"><i class="glyphicon glyphicon-map-marker"  disabled></i></button>';
//##	echo '<div id="myModal_Emergente2_'.$b.'" class="modal_Emergente2">';
//##	echo '<div class="modal_Emergente2-content">';
//##	echo '<span class="close_Emergente2_'.$b.'">&times;</span>';
//##	echo '<center><font size=6><b>NO EXISTE REGISTRO</b></font></center>';
//##	echo '</div>';
//##	echo '</div>';

echo '</td>';
echo '</tr>';


//echo '<div id="myModalFoto'.$b.'" class="modalFoto">';
//echo '<span class="closeFoto'.$b.'">&times;</span>';
//echo '<img class="modal-contentFoto" id="img0'.$b.'">';
//echo '<div id="caption"></div>';
//echo '</div>';

echo '<div class="modal fade" id="myCarusel'.$ciclo.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"  align="center">';
echo '<div class="slideshow-container">';
echo '<div class="mySlides'.$ciclo.' fadeCarusel">';
echo '<div class="numbertext">0 / 0</div>';
echo '<img src="img/no_imagen.jpg" style="width:50%">';
echo '<div class="text">No Existe Fotografia</div>';
echo '</div>';

echo '<a class="prev" onclick="plusSlides'.$ciclo.'(-1)">&#10094;</a>';
echo '<a class="next" onclick="plusSlides'.$ciclo.'(1)">&#10095;</a>';
echo '</div>';
echo '<br>';
echo '<span class="dot'.$ciclo.'" onclick="currentSlide'.$ciclo.'(1)"></span>';

echo '<h4><font color="pink">No Existe Fotografias</font></h4>';

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




?>



<script>

let slideIndex1 = 1;
showSlides1(slideIndex1);

let slideIndex2 = 1;
showSlides2(slideIndex2);

let slideIndex3 = 1;
showSlides3(slideIndex3);

function plusSlides1(n) {
  showSlides1(slideIndex1 += n);
}

function plusSlides2(n) {
  showSlides2(slideIndex2 += n);
}

function plusSlides3(n) {
  showSlides3(slideIndex3 += n);
}

function currentSlide1(n) {
  showSlides1(slideIndex1 = n);
}

function currentSlide2(n) {
  showSlides2(slideIndex2 = n);
}

function currentSlide3(n) {
  showSlides3(slideIndex3 = n);
}

function showSlides1(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides1");
  let dots = document.getElementsByClassName("dot1");
  if (n > slides.length) {slideIndex1 = 1}    
  if (n < 1) {slideIndex1 = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active1", "");
  }
  slides[slideIndex1-1].style.display = "block";  
  dots[slideIndex1-1].className += " active1";
}

function showSlides2(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides2");
  let dots = document.getElementsByClassName("dot2");
  if (n > slides.length) {slideIndex2 = 1}    
  if (n < 1) {slideIndex2 = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active2", "");
  }
  slides[slideIndex2-1].style.display = "block";  
  dots[slideIndex2-1].className += " active2";
}

function showSlides3(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides3");
  let dots = document.getElementsByClassName("dot3");
  if (n > slides.length) {slideIndex3 = 1}    
  if (n < 1) {slideIndex3 = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active3", "");
  }
  slides[slideIndex3-1].style.display = "block";  
  dots[slideIndex3-1].className += " active3";
}


</script>

<script src='https://code.jquery.com/jquery-3.1.1.slim.min.js'></script>
<script src='https://cdn.rawgit.com/JacobLett/bootstrap4-latest/master/bootstrap-4-latest.min.js'></script>

<script id="rendered-js" >
$(document).ready(function () {

  var $videoSrc1;
  var $videoSrc2;
  var $videoSrc3;

  $('.video-btn').click(function () {
    $videoSrc1 = $(this).data("src");
  });
  console.log($videoSrc1);

  $('.video-btn').click(function () {
    $videoSrc2 = $(this).data("src");
  });
  console.log($videoSrc2);

  $('.video-btn').click(function () {
    $videoSrc3 = $(this).data("src");
  });
  console.log($videoSrc3);

$('#myModalYouTube1').on('shown.bs.modal', function (e) {
$("#video1").attr('src', $videoSrc1 + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
});

$('#myModalYouTube2').on('shown.bs.modal', function (e) {
$("#video2").attr('src', $videoSrc2 + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
});
$('#myModalYouTube3').on('shown.bs.modal', function (e) {
$("#video3").attr('src', $videoSrc2 + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
});

  $('#myModalYouTube1').on('hide.bs.modal', function (e) {
    $("#video1").attr('src', $videoSrc1);
  });

  $('#myModalYouTube2').on('hide.bs.modal', function (e) {
    $("#video2").attr('src', $videoSrc2);
  });

  $('#myModalYouTube3').on('hide.bs.modal', function (e) {
    $("#video3").attr('src', $videoSrc2);
  });


  // document ready  
});
//# sourceURL=pen.js


</script>

<?php
	}
?>

<?php
session_start();

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
		$id_principal=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * FROM principal WHERE estatus!='ELIMINADO' AND id=".$id_principal);
		$count=mysqli_num_rows($query);
		if ($count!=0){
			##if ($delete1=mysqli_query($con,"DELETE FROM vallas WHERE id=".$id_vallas)){
			if ($delete1=mysqli_query($con,"UPDATE principal SET estatus='ELIMINADO', operacion='ELIMINADO' WHERE id=".$id_principal)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Registro Eliminado Exitosamente.
			</div>
			<?php 
		} else {
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
			  <strong>Error!</strong> No se pudo eliminar Registro. 
			</div>
			<?php
		}
	}


	if($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('domicilio');//Columnas de busqueda
		 $sTable = "principal";
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
		$reload = './principal.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table registro-table">
				<thead>
				<tr>
					<th>Imagen</th>
					<th>Datos Establecimiento</th>
					<th>Solicitante</th>
					<th>Observación</th>
					<th class="text-end">Acciones</th>
				</tr>
				</thead>
				<tbody>
				<?php
			
			$ciclo=1;
			while ($row=mysqli_fetch_array($query)) {
				$id=$row['id'];
				$principal_id=$row['id'];
				$folio=$row['folio'];

$nombre_comercial_establecimiento=$row['nombre_comercial_establecimiento'];
$calle_establecimiento=$row['calle_establecimiento'];
$entre_calles_establecimiento=$row['entre_calles_establecimiento'];
$numero_establecimiento=$row['numero_establecimiento'];
$numerointerno_local_establecimiento=$row['numerointerno_local_establecimiento'];
$cp_establecimiento=$row['cp_establecimiento'];
$nombre_persona_fisicamoral_solicitante=$row['nombre_persona_fisicamoral_solicitante'];
$nombre_representante_legal_solicitante=$row['nombre_representante_legal_solicitante'];
$domicilio_solicitante=$row['domicilio_solicitante'];
$email_solicitante=$row['email_solicitante'];
$telefono_solicitante=$row['telefono_solicitante'];

$id_giro=$row['giro'];
$id_modalidad_graduacion_alcoholica=$row['modalidad_graduacion_alcoholica'];



	$numero_permiso=$row['numero_permiso'];
	$estatus=$row['estatus'];
	$operacion=$row['operacion'];

	$latitud=$row['latitud'];
	$longitud=$row['longitud'];

	$observaciones=$row['observaciones'];
	$fecha_alta=$row['fecha_alta'];
	$id_municipio=$row['id_municipio'];
	$delegacion_id=$row['id_delegacion'];
	$colonia_id=$row['id_colonia'];
	$foto=$row['foto'];

##
$sql_giro="SELECT descripcion_giro FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
##
$sql_modalidad_graduacion_alcoholica="SELECT descripcion_modalidad_graduacion_alcoholica FROM modalidad_graduacion_alcoholica WHERE id=".$id_modalidad_graduacion_alcoholica;
$result_modalidad_graduacion_alcoholica = mysqli_query($con,$sql_modalidad_graduacion_alcoholica);
$row_modalidad_graduacion_alcoholica = mysqli_fetch_assoc($result_modalidad_graduacion_alcoholica);
$MODALIDAD_GA=$row_modalidad_graduacion_alcoholica['descripcion_modalidad_graduacion_alcoholica'];
##
$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
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

$direccion_establecimiento_completa=$calle_establecimiento.' '.$numero_establecimiento.' ['.$numerointerno_local_establecimiento.'], '.$entre_calles_establecimiento.', CP '.$cp_establecimiento;
echo '<input type="hidden" value="'.$page.'" id="pagina" name="pagina">';
echo '<input type="hidden" value="'.$principal_id.'" id="ID_PRINCIPAL" name="ID_PRINCIPAL">';
echo '<input type="hidden" value="'.$folio.'" id="folio'.$principal_id.'">';
echo '<input type="hidden" value="'.$numero_permiso.'" id="numero_permiso'.$principal_id.'">';
echo '<input type="hidden" value="'.$estatus.'" id="estatus'.$principal_id.'">';
echo '<input type="hidden" value="'.$operacion.'" id="operacion'.$principal_id.'">';
echo '<input type="hidden" value="'.$observaciones.'" id="observaciones'.$principal_id.'">';
echo '<input type="hidden" value="'.$delegacion_id.'" id="delegacion_id'.$principal_id.'">';
echo '<input type="hidden" value="'.$colonia_id.'" id="colonia_id'.$colonia_id.'">';
echo '<input type="hidden" value="'.$COLONIA.'" id="COLONIA'.$principal_id.'">';
echo '<input type="hidden" value="'.$DELEGACION.'" id="DELEGACION'.$principal_id.'">';
echo '<input type="hidden" value="'.$GIRO.'" id="GIRO'.$principal_id.'">';
echo '<input type="hidden" value="'.$MODALIDAD_GA.'" id="MODALIDAD_GA'.$principal_id.'">';
####
echo '<input type="hidden" value="'.$COLONIA.', '.$DELEGACION.'" id="COLONIAyDELEGACION'.$principal_id.'">';
echo '<input type="hidden" value="'.$direccion_establecimiento_completa.'" id="direccion_establecimiento_completa'.$principal_id.'">';
####
echo '<input type="hidden" value="'.$nombre_comercial_establecimiento.'" id="nombre_comercial_establecimiento'.$principal_id.'">';
echo '<input type="hidden" value="'.$calle_establecimiento.'" id="calle_establecimiento'.$principal_id.'">';
echo '<input type="hidden" value="'.$entre_calles_establecimiento.'" id="entre_calles_establecimiento'.$principal_id.'">';
echo '<input type="hidden" value="'.$numero_establecimiento.'" id="numero_establecimiento'.$principal_id.'">';
echo '<input type="hidden" value="'.$numerointerno_local_establecimiento.'" id="numerointerno_local_establecimiento'.$principal_id.'">';
echo '<input type="hidden" value="'.$cp_establecimiento.'" id="cp_establecimiento'.$principal_id.'">';
echo '<input type="hidden" value="'.$nombre_persona_fisicamoral_solicitante.'" id="nombre_persona_fisicamoral_solicitante'.$principal_id.'">';
echo '<input type="hidden" value="'.$nombre_representante_legal_solicitante.'" id="nombre_representante_legal_solicitante'.$principal_id.'">';
echo '<input type="hidden" value="'.$domicilio_solicitante.'" id="domicilio_solicitante'.$principal_id.'">';
echo '<input type="hidden" value="'.$email_solicitante.'" id="email_solicitante'.$principal_id.'">';
echo '<input type="hidden" value="'.$telefono_solicitante.'" id="telefono_solicitante'.$principal_id.'">';


echo '<tr>';
##########
echo '<td data-label="Imagen">';
#################
###  FOTO
#################
$foto_file='../../'.FOTOSMEDIAS.$id.'-'.$foto.'.jpg';
if ( $foto==NULL || $foto=='' )
	echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$ciclo.'"><img class="img-thumbnail-custom" src="img/no_imagen.jpg" alt="No Existe Foto"></a>';
else {
	if ( file_exists($foto_file)!=1 ) echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$ciclo.'"><img class="img-thumbnail-custom" src="img/no_imagen.jpg" alt="No Existe Foto"></a>';
	else {
	  echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$ciclo.'"><img id="myImg" src="'.$foto_file.'" class="img-thumbnail-custom" alt="Registro '.$folio.' / '.$numero_permiso.'  ('.$calle_establecimiento.')"></a>';
	}
}

echo '<span class="d-block text-muted mt-2"><small>'.$id.' | '.$fecha_alta.'</small></span>';
echo '<span class="d-block text-primary"><small>'.$operacion.' | '.$numero_permiso.'</small></span>';

echo '</td>';
##########
echo '<td data-label="Datos Establecimiento">
	<div class="datos-establecimiento">
		<span class="nombre-comercial">'.ucwords($nombre_comercial_establecimiento).'</span>
		<span class="detalle-giro">'.$GIRO.', '.$MODALIDAD_GA.'</span>
		<span class="direccion">'.$calle_establecimiento.' '.$numero_establecimiento.', CP '.$cp_establecimiento.'</span>
		<span class="direccion"><span class="etiqueta">Delegación:</span> '.$DELEGACION.', '.$COLONIA.' ('.$MUNICIPIO.')</span>
	</div>
</td>';
##########
echo '<td data-label="Solicitante">
	<div class="datos-solicitante">
		<span class="nombre-comercial">'.ucwords($nombre_persona_fisicamoral_solicitante).'</span>
		<span class="detalle-giro" style="background-color:var(--color-secondary); color:var(--color-primary);">'.$nombre_representante_legal_solicitante.'</span>
		<span class="contacto"><span class="etiqueta">Email:</span> '.$email_solicitante.'</span>
		<span class="contacto"><span class="etiqueta">Tel:</span> '.$telefono_solicitante.'</span>
	</div>
</td>';
##########

if ( strlen($observaciones)>150 ) 
	echo '<td data-label="Observación"><div class="info-tooltip">' . substr($observaciones,0,150) . '...<span class="tooltip-text">'.$observaciones.'</span></div></td>';
else {
	echo '<td data-label="Observación">'.$observaciones.'</td>';
}
?>
						
<td data-label="Acciones" class="text-end">
<div class="action-buttons">

<?php


if ( $operacion!='NUEVO' ) {

############################
############################
####  MAPA

echo '<button id="myBtn2_'.$ciclo.'" class="btn btn-sm btn-action btn-primary-custom" title="Mapa Google Maps"><i class="bi bi-geo-alt"></i></button>';
echo '<div id="myModal_Emergente2_'.$ciclo.'" class="modal_Emergente2">';
echo '<div class="modal_Emergente2-content" width="">';
echo '<span class="close_Emergente2_'.$ciclo.'">&times;</span>';

echo '<p><font color="black" size="2">Folio ('.$folio.'), Número de Permiso ('.$numero_permiso.')<br>'.$nombre_comercial_establecimiento.'</font></p>';
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
} else {
##if ( $estatus=='Efectuar Inspeccion' ) {
echo '<button id="myBtn2_'.$ciclo.'" class="btn btn-sm btn-action btn-secondary-custom" title="Mapa Google Maps" disabled><i class="bi bi-geo-alt"></i></button>';
echo '<div id="myModal_Emergente2_'.$ciclo.'" class="modal_Emergente2">';
echo '<div class="modal_Emergente2-content" width="">';
echo '<span class="close_Emergente2_'.$ciclo.'">&times;</span>';
echo '<table width="90%"><tr>';
echo '<td width="80%">';
echo '<font size=6 color="pink"><b>NO REGISTRO</b></font>';
echo '</td>';
echo '<td width="20%">';
echo '</td>';
echo '</tr></table>';
echo '</div>';
echo '</div>';

echo '<a href="principalFotos.php?id='.$row["id"].'&page='.$page.'" class="btn btn-sm btn-action btn-secondary-custom" title="Galerías de Fotos"><i class="bi bi-camera"></i></a>';

}

############
echo '<a href="detalleRegistro.php?id='.$row["id"].'&page='.$page.'" class="btn btn-sm btn-action btn-primary-custom" title="Detalle Registro"><i class="bi bi-pencil"></i></a>';
############

if ( $estatus=='Efectuar Inspeccion' ) {
echo '<div class="estatus-badge estatus-inspeccion mt-2">'.$estatus.'</div>';
} else if ( $estatus=='Inspeccion Realizada' ) {
echo '<div class="estatus-badge estatus-realizada mt-2">'.$estatus.'</div>';
} else {
echo '<div class="estatus-badge estatus-generar mt-2">'.$estatus.'</div>';
}

?>
</div>
</td>
</tr>


<?php
##########################
##########################
###  myCarusel Gallery

echo '<div class="modal fade" id="myCarusel'.$ciclo.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"  align="center">';

echo '<div class="modal-dialog" style="width:600px;">';
echo '<div class="modal-content"  style="background-color:none;">';
echo '<div class="modal-body">';
echo '<h5><font color="black">'.$folio.' / '.$numero_permiso.'  ('.$nombre_comercial_establecimiento.')</font></h5>';
#############
echo '<div class="slideshow-container">';

$sqlFotos="SELECT * FROM fotos WHERE idprincipal=".$id;

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
echo '<input type="hidden" value="0" id="ID_PRINCIPAL" name="ID_PRINCIPAL">';
echo '<input type="hidden" value="0" id="folio'.$b.'">';
echo '<input type="hidden" value="0" id="numero_permiso'.$b.'">';
echo '<input type="hidden" value="0" id="estatus'.$b.'">';
echo '<input type="hidden" value="0" id="operacion'.$b.'">';
echo '<input type="hidden" value="0" id="observaciones'.$b.'">';

echo '<input type="hidden" value="0" id="delegacion_id'.$b.'">';
echo '<input type="hidden" value="0" id="colonia_id'.$b.'">';
echo '<input type="hidden" value="0" id="COLONIA'.$b.'">';
echo '<input type="hidden" value="0" id="DELEGACION'.$b.'">';
echo '<input type="hidden" value="0" id="GIRO'.$b.'">';
echo '<input type="hidden" value="0" id="MODALIDAD_GA'.$b.'">';

echo '<input type="hidden" value="0" id="nombre_comercial_establecimiento'.$b.'">';
echo '<input type="hidden" value="0" id="calle_establecimiento'.$b.'">';
echo '<input type="hidden" value="0" id="entre_calles_establecimiento'.$b.'">';
echo '<input type="hidden" value="0" id="numero_establecimiento'.$b.'">';
echo '<input type="hidden" value="0" id="numerointerno_local_establecimiento'.$b.'">';
echo '<input type="hidden" value="0" id="cp_establecimiento'.$b.'">';
echo '<input type="hidden" value="0" id="nombre_persona_fisicamoral_solicitante'.$b.'">';
echo '<input type="hidden" value="0" id="nombre_representante_legal_solicitante'.$b.'">';
echo '<input type="hidden" value="0" id="domicilio_solicitante'.$b.'">';
echo '<input type="hidden" value="0" id="email_solicitante'.$b.'">';
echo '<input type="hidden" value="0" id="telefono_solicitante'.$b.'">';



###########################

echo '<tr>';
echo '<td><font size="1" color="white">'.$b.'</font>';

echo '<a href="#" data-toggle="modal" data-target="#myCarusel'.$b.'"><img class="item-img img-responsive" src="img/no_imagen.jpg" alt="No Existe Foto" style="width:50px;height:50px;"></a>';
//echo '<img  id="myImg'.$b.'"  class="item-img img-responsive" src="img/no_imagen.jpg" alt="No Existe Foto" style="width:0px;height:0px;">';
echo '</td>';
echo '<td ><font size="1">-</td>';
echo '<td ><font size="1">-</font></td>';
echo '<td ><font size="1">-</font></td>';
echo '<td class="text-right">';



################################
#####  MAPA
echo '<button id="myBtn2_'.$b.'" title="Mapa Google Maps"  disabled></button>';
echo '<div id="myModal_Emergente2_'.$b.'" class="modal_Emergente2">';
echo '<div class="modal_Emergente2-content" width="">';
echo '<span class="close_Emergente2_'.$b.'">&times;</span>';

echo '<table width="90%"><tr>';
echo '<td width="80%">';
echo '<font size=6 color="pink"><b>NO REGISTRO</b></font>';
echo '</td>';
echo '<td width="20%">';
echo '</td>';
echo '</tr></table>';
echo '</div>';
echo '</div>';



################################

//<!-- Modal Youtube -->
echo '<div class="modal fade" id="myModalYouTube'.$b.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
echo '<div class="modal-dialog" role="document">';
echo '<div class="modal-content"  style="background-color: black;">';

echo '<div class="modal-body">';

echo '<button type="button" class="closeYouTube" data-dismiss="modal" aria-label="Close">';
echo '<span aria-hidden="true">&times;</span>';
echo '</button>';
//<!-- 16:9 aspect ratio -->
echo '<div class="embed-responsive embed-responsive-16by9">';
echo '<iframe class="embed-responsive-item" src="" id="video'.$b.'"  allowscriptaccess="always" allow="autoplay"></iframe>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

################################
##  Carusel

echo '<div class="modal fade" id="myCarusel'.$b.'" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"  align="center">';
echo '<div class="slideshow-container">';
echo '<div class="mySlides'.$b.' fadeCarusel">';
echo '<div class="numbertext">0 / 0</div>';
echo '<img src="img/no_imagen.jpg" style="width:50%">';
echo '<div class="text">No Existe Fotografia</div>';
echo '</div>';

echo '<a class="prev" onclick="plusSlides'.$b.'(-1)">&#10094;</a>';
echo '<a class="next" onclick="plusSlides'.$b.'(1)">&#10095;</a>';
echo '</div>';
echo '<br>';
echo '<span class="dot'.$b.'" onclick="currentSlide'.$b.'(1)"></span>';

echo '<h4><font color="pink">NO REGISTRO</font></h4>';

echo '</div>';



echo '</td>';
echo '</tr>';
}
}

echo '</tbody>';
echo '</table>';
echo '</div>';
		
$inicios=$offset+1;
$finales=$offset+$numrows;
echo '<div class="clearfix"></div>';
echo '<div class="row">';
echo '<div class="col-md-12">';
echo '<div class="pagination-container text-center mt-4">';
echo paginate($reload, $page, $total_pages, $adjacents);
echo '</div>';
echo '<div class="col-md-12 text-center">';
echo '<p class="text-muted">Mostrando '.$inicios.' al '.$finales.' de '.$numrows.' registros</p>';
echo '</div>';
echo '</div>';
echo '</div>';
		
} else {
echo '<div class="alert alert-warning text-center">No hay resultados para esta búsqueda.</div>';
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

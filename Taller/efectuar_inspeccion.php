<style>
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
  height: 100%;
  padding: 0px;
}

</style>


<script src="../../MiLibreria/leaflet/js/leaflet.js"></script>
<link rel="stylesheet" href="../../Taller/MapP/leaflet/css/leaflet.css">



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
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccion" name="registro_guardar_inspeccion">
			<div id="resultados_ajaxInspeccion"></div>

<?php

echo '<font size="2" color="black">Nombre Establecimiento: </font><font size="2" color="blue">'.$nombre_comercial_establecimientoDB.'</font>, ';
echo '<font size="2" color="black">Folio: </font><font size="2" color="blue">'.$folioDB.'</font>';
?>


<input type="hidden" id="mod_id" name="mod_id">
<input type="hidden" id="mod_id_tramite" name="id_tramite">
<input type="hidden" id="mod_pagina" name="pagina">
<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_id_proceso_tramites" name="id_proceso_tramites">

<input type="hidden" id="mod_folio" name="folio">

<?php
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
echo '<div id="map" class="map" style="height:200px; width:100%;background-color: powderblue;"></div>';
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
  <i class="bi bi-info-circle"></i> <font size="1">Asegúrese de completar todos los campos con información precisa de la inspección.</font>
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


<script>
$(document).ready(function(){
  $("#myBtn").click(function(){
    $("#EfectuarInspeccion").modal();



<?php
echo 'var Lat="'.$latitudDB.'";';
echo 'var Lon="'.$longitudDB.'";';
?>

const modal = document.getElementById('EfectuarInspeccion');
//const modalBs = new bootstrap.Modal(EfectuarInspeccion);

const map = L.map("map")
map.setView([Lat,Lon], 14);


L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
}).addTo(map);

//modalBs.show();

var marker = L.marker([Lat,Lon],{
draggable: true
}).addTo(map);


map.whenReady(() => {
    setTimeout(() => {
        map.invalidateSize();
    }, 450);
});

marker.on('dragend', function (e) {
  document.getElementById('latitud').value = marker.getLatLng().lat;
  document.getElementById('longitud').value = marker.getLatLng().lng;
});



  });
});



</script>


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
</style>



<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
        <div class="modal fade" id="EfectuarInspeccionTemp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  <div class="modal-dialog modal-xl"  role="document">
		<div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

			<h6 class="modal-title" id="EfectuarInspeccionLabel"><i class="bi bi-clipboard-check"></i> Registrar Inspección - Permiso Temporal</h6>
 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccionTemp" name="registro_guardar_inspeccionTemp">
			<div id="resultados_ajaxInspeccionTemp"></div>


<?php

echo '<font size="2" color="black">Nombre Establecimiento: </font><font size="2" color="blue">'.$nombre_comercial_establecimientoDB.'</font>,   ';
echo '<font size="2" color="black">Folio: </font><font size="2" color="blue">'.$folioDB.'</font><br>';
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
##echo '<label for="superficie_establecimiento" class="col-sm-2 control-label">Superficie (m²)</label>';
##echo '<div class="col-sm-3">';
##echo '<input type="number" class="form-control" id="superficie_establecimiento" name="superficie_establecimiento" required>';
##echo '</div>';
//##
##echo '<label for="capacidad_comensales_personas" class="col-sm-2 control-label">Capacidad Comensales</label>';
##echo '<div class="col-sm-3">';
##echo '<input type="number" class="form-control" id="capacidad_comensales_personas" name="capacidad_comensales_personas" required>';
##echo '</div>';
##echo '</div>';
###
?>



<?php
###
echo '<div class="mb-3 row">';
echo '<label for="latitud" class="col-sm-2 col-form-label">Latitud<br><font size="2" color="blue">Ej: 32.5317397</font></label>';
echo '<div class="col-sm-2">';
echo '<input type="text" class="form-control required" title="Enter Latitud ( 32.5317387 )"  pattern="(32\.)[\d]{6,}"  id="latitud" name="latitud" maxlength="12" autocomplete="off"   required>';
echo '</div>';
//##
echo '<label for="longitud" class="col-sm-2 col-form-label">Longitud<br><font size="2" color="blue">Ej: -117.019529</font></label>';
echo '<div class="col-sm-2">';
echo '<input type="text" class="form-control required"  title="Enter Longitud (-117.019529)"   pattern="(-)(116|117)(\.)[\d]{6,}" id="longitud" name="longitud" maxlength="12" autocomplete="off"  required>';
echo '</div>';
echo '</div>';
###
###
echo '<div class="form-group row" style="background-color:#ECECEC;color:black">';
echo '<label for="observacion_1" class="col-sm-4 control-label"><font size="1">INSTITUCIONES EDUCATIVAS, CENTROS RELIGIOSOS, DEPORTIVOS, HOSPITALES, ETC. ARTICULO 20 FRACCION V Y ARTICULO 39 DEL REGLAMENTO PARA LA VENTA, ALMACENAJE Y  CONSUMO DE BEBIDAS ALCOHOLICAS PARA EL MUNICIPIO DE TIJUANA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_1_cumple' id='observacion_1_cumple' required>";
echo '<option value="NO" selected>NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_1_datos" name="observacion_1_datos"   maxlength="1000" rows="3"></textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_1_metros" name="observacion_1_metros" >';


echo '</div>';
echo '</div>';

###
###
###
echo '<br>';
echo '<div class="form-group row">';
echo '<label for="observacion_2" class="col-sm-4 control-label"><font size="1">ZONAS HABITACIONALES, ESCOLARES Y/O FABRILES. ARTICULO 22 DEL REGLAMENTO DE LA MATERIA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_2_cumple' id='observacion_2_cumple' required>";
echo '<option value="NO" selected>NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_2_datos" name="observacion_2_datos"   maxlength="1000" rows="3"></textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_2_metros" name="observacion_2_metros">';


echo '</div>';
echo '</div>';
###
###
echo '<br>';
echo '<div class="form-group row"  style="background-color:#ECECEC;color:black">';
echo '<label for="observacion_3" class="col-sm-4 control-label"><font size="1">MISMO GIRO ARTICULO 20 FRACCION IV DE LA LEY Y ARTICULO 39 DEL REGLAMENTO DE LA MATERIA U OTROS GIROS</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_3_cumple' id='observacion_3_cumple' required>";
echo '<option value="NO" selected>NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_3_datos" name="observacion_3_datos"   maxlength="1000" rows="3"></textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_3_metros" name="observacion_3_metros">';


echo '</div>';
echo '</div>';
###
###
echo '<br>';
echo '<div class="form-group row">';
echo '<label for="observacion_4" class="col-sm-4 control-label"><font size="1">COMUNICACION DIRECTA CON VIVIENDA O ALGUN ESTABLECIMIENTO MERCANTIL, ARTICULO 24 DE LA LEY DE LA METERIA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_4_cumple' id='observacion_4_cumple' required>";
echo '<option value="NO" selected>NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_4_datos" name="observacion_4_datos"   maxlength="1000" rows="3"></textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_4_metros" name="observacion_4_metros">';


echo '</div>';
echo '</div>';
###
###
echo '<br>';
echo '<div class="form-group row"  style="background-color:#ECECEC;color:black">';
echo '<label for="observacion_5" class="col-sm-4 control-label"><font size="1">COLOCACION DEL AVISO PUBLICO ARTICULO 26 Y 27 DEL REGLAMENTO PARA LA VENTA, ALMACENAJE Y CONSUMO DE BEBIDAS ALCOHOLICAS PARA EL MUNICIPIO DE TIJUANA Y ARTICULO 21 DE LA LEY DE LA MATERIA</font></label>';

echo '<div class="col-sm-1">';

echo "<font size='2'><b>Cumple</b></font><select class='form-control form-select' name='observacion_5_cumple' id='observacion_5_cumple' required>";
echo '<option value="NO" selected>NO</option>';
echo '<option value="SI">SI</option>';
echo '</select>';

echo '</div>';

echo '<div class="col-sm-6">';
echo '<font size="2"><b>Dato</b></font><textarea class="form-control" id="observacion_5_datos" name="observacion_5_datos"   maxlength="1000" rows="3"></textarea>';
echo '</div>';

echo '<div class="col-sm-1">';
echo '<font size="1"><b>Dist.Metros</b></font><input type="number" class="form-control" id="observacion_5_metros" name="observacion_5_metros">';


echo '</div>';
echo '</div>';


##
?>
<br>
<div class="mb-3 row">
<label for="observaciones" class="col-sm-2 col-form-label"><font size="2"><b>Observaciones Generales</b></font></label>
<div class="col-sm-9">
<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" rows="3"></textarea>
</div>
</div>




<div class="alert alert-info">
  <i class="bi bi-info-circle"></i> <font size="1">Asegúrese de completar todos los campos con información precisa de la inspección.</font>
</div>



			
		  </div>
		  <div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal"><font size="2"> Cerrar</font></button>
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_inspeccionTemp"  style="background-color:#AC905B;color:black"><font size="2"> Registrar Inspección </font></button>
		  </div>
		  </form>
<p><font color="white" size="1">modal/efectuar_inspeccionTemp.php-(Button_registro_guardar_inspeccionTemp)->ajax/registro_guardar_inspeccionTemporal.php</font></p>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

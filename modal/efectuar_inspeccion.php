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
        <div class="modal fade" id="EfectuarInspeccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	  <div class="modal-dialog modal-lg"  role="document">
		<div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

			<h6 class="modal-title" id="EfectuarInspeccionLabel"><i class="bi bi-clipboard-check"></i> Registrar Inspección</h6>
 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="registro_guardar_inspeccion" name="registro_guardar_inspeccion">
			<div id="resultados_ajaxInspeccion"></div>




			<div class="mb-3 row">


<label for="mod_nombre_comercial_establecimiento" class="col-sm-4 col-form-label"><font color="black">Nombre Establecimiento</font></label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento"  disabled>






</div>
</div>

<div class="mb-3 row">
<label for="mod_folio" class="col-sm-4 col-form-label"><font color="black">Folio</font></label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="mod_folio"  disabled>
</div>
</div>

<input type="hidden" id="mod_id" name="mod_id">
<input type="hidden" id="mod_id_tramite" name="id_tramite">
<input type="hidden" id="mod_pagina" name="pagina">
<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_id_proceso_tramites" name="id_proceso_tramites">

<input type="hidden" id="mod_folio" name="folio">

<?php
###
echo '<div class="form-group row">';
echo '<label for="superficie_establecimiento" class="col-sm-2 control-label"><font color="black">Superficie (m²)</font></label>';
echo '<div class="col-sm-3">';
echo '<input type="number" class="form-control" id="superficie_establecimiento" name="superficie_establecimiento" value="'.$superficie_establecimientoDB.'" required>';
echo '</div>';
//##
echo '<label for="capacidad_comensales_personas" class="col-sm-2 control-label"><font color="black">Capacidad Comensales</font></label>';
echo '<div class="col-sm-3">';
echo '<input type="number" class="form-control" id="capacidad_comensales_personas" name="capacidad_comensales_personas" value="'.$capacidad_comensales_personasDB.'" required>';
echo '</div>';
echo '</div>';
###
?>


<?php
###
echo '<div class="mb-3 row">';
echo '<label for="latitud" class="col-sm-2 col-form-label"><font color="black">Latitud</font><br><font size="2" color="blue">Ej: 32.5317397</font></label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control required" title="Enter Latitud ( 32.5317387 )"  pattern="(32\.)[\d]{6,}"  id="latitud" name="latitud" maxlength="12" autocomplete="off" value="'.$latitudDB.'"  required>';
echo '</div>';
//##
echo '<label for="longitud" class="col-sm-2 col-form-label"><font color="black">Longitud</font><br><font size="2" color="blue">Ej: -117.019529</font></label>';
echo '<div class="col-sm-4">';
echo '<input type="text" class="form-control required"  title="Enter Longitud (-117.019529)"   pattern="(-)(116|117)(\.)[\d]{6,}" id="longitud" name="longitud" maxlength="12" autocomplete="off" value="'.$longitudDB.'"  required>';
echo '</div>';
echo '</div>';
###
?>



<div class="mb-3 row">
<label for="observaciones" class="col-sm-4 col-form-label"><font color="black">Observaciones</font></label>
<div class="col-sm-8">
<textarea class="form-control" id="observaciones" name="observaciones"   maxlength="1000" rows="3"></textarea>
</div>
</div>

<div class="alert alert-info">
  <i class="bi bi-info-circle"></i> <font size="1">Asegúrese de completar todos los campos con información precisa de la inspección.</font>
</div>



			
		  </div>
		  <div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="Button_registro_guardar_inspeccion"  style="background-color:#AC905B;color:black"> Registrar Inspección </button>
		  </div>
		  </form>
<font size="1" color="white">modal/efectuar_inspeccion.php-(Button_registro_guardar_inspeccion)->ajax/registro_guardar_inspeccion.php</font>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

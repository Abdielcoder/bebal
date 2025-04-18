<style> 
input[type=text] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid red;
  border-radius: 4px;
}

input[type=number] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid blue;
  border-radius: 4px;
}
input[type=email] {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid green;
  border-radius: 4px;
}

#mod_clave_catastral:valid {
    color: black;
background-color: #3CBC8D;
}
#mod_clave_catastral:invalid {
    color: red;
}

#rfc_solicitante:valid {
    color: black;
background-color: #3CBC8D;
}
#rfc_solicitante:invalid {
    color: red;
}

</style>


<?php
	$PROFILE=$_SESSION['user_profile'];
	$ID_MUNICIPIO=$_SESSION['user_id_municipio'];
	if (isset($con))
	{
	?>
	<!-- Modal -->
	<div class="modal fade" id="ActualizarDatosNombreComercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header"  style="background-color:#FF0000;color:black">
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i>Actualizar - Nombre  Comercial </h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_DatosNombreComercial" name="guardar_DatosNombreComercial">
			<div id="resultados_ajaxDatosNombreComercial"></div>

<input type="hidden" id="mod_idprincipal" name="idprincipal">
<input type="hidden" id="mod_folio" name="folio">


<?php

##########################
##########################
##echo '<h4><span style="background:black"><font color="white" size="3">Datos del Establecimiento</font></span></h4>';
###
echo '<div class="form-group row">';
echo '<label for="mod_nombre_comercial_establecimiento" class="col-sm-3 control-label">Nombre Comercial</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" disabled>';
echo '</div>';
echo '</div>';
//##

echo '<br>';

###
echo '<div class="form-group row">';
echo '<label for="nombre_comercial_establecimiento_NUEVO" class="col-sm-3 control-label">Nuevo Nombre</label>';
echo '<div class="col-sm-8">';
echo '<input type="text" class="form-control form-control-sm" style="text-transform:uppercase" name="nombre_comercial_establecimiento_NUEVO" required>';
echo '</div>';
echo '</div>';
//##


?>



</div>

<div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_guardar_DatosNombreComercial"  style="background-color:#FF0000;color:black"> Actualizar Registro </button>
</div>

</form>
</div>
</div>
</div>
<?php
}
?>

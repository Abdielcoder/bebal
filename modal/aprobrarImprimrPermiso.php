	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="aprobrarImpresionPermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">


<!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--!>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-p-square'></i> Aprobrar Imprimir Permiso</h6>
		  </div>
		  <div class="modal-body"   style="background-color:#FFFFFF;color:black">

			<form class="form-horizontal" method="post" id="aprobrarTramiteImpresionPermiso" name="aprobrarTramiteImpresionPermiso">

			<div id="resultados_ajaxaprobrarTramiteImpresionPermiso"></div>


<input type="hidden" id="mod_folio" name="folio">

<input type="hidden" id="mod_idprincipal" name="IDPRINCIPAL">
<input type="hidden" id="mod_pagina" name="page">

<input type="hidden" id="mod_id_tramite_solicitado" name="id_tramite_solicitado">
<input type="hidden" id="mod_tramite_solicitado" name="tramite_solicitado">

<input type="hidden" id="mod_descripcion_tramite_solicitado" name="descripcion_tramite_solicitado">
<input type="hidden" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento">
<input type="hidden" id="mod_monto_umas_tramite_solicitado" name="monto_umas_tramite_solicitado">


<div class="form-group row">
<label for="mod_nombre_comercial_establecimiento" class="col-sm-3 control-label">Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="mod_nombre_comercial_establecimiento" disabled>
</div>
</div>


<div class="form-group row">
<label for="mod_folio" class="col-sm-3 control-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="mod_folio" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_tramite_solicitado" class="col-sm-3 control-label">Trámite Solicitado</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_tramite_solicitado" name="mod_tramite_solicitado" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_monto_umas_tramite_solicitado" class="col-sm-3 control-label">Monto UMAS</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_monto_umas_tramite_solicitado" name="mod_monto_umas_tramite_solicitado" disabled>
</div>
</div>

<br>

<div class="alert alert-info">
  <i class="bi bi-info-circle"></i> Asegúrese de que el Contribuyente Conoce el Presupuesto para la Impresión del Permiso.
</div>

			 
			
</div>
 <div class="modal-footer">
<!--<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>--!>
<button type="submit" class="btn btn-primary" id="Button_aprobrarTramiteImpresionPermiso"> Aprobar Impresión </button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

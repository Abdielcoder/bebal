	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="imprimirpermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document" >
		<div class="modal-content"  style="background-color:#FF0000;color:white">

                  <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="ImprimirPermisoLabel"><i class="bi bi-postcard"></i> Imprimir Permiso</h5>

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="imprimirPermiso" name="imprimirPermiso" action="iPermiso.php">
			<div id="resultados_ajaxImprimirPermiso"></div>


<input type="hidden" id="mod_id_imprimir" name="IDPRINCIPAL">


<div class="form-group row">
<label for="mod_nombre_comercial_establecimiento_imprimir" class="col-sm-3 control-label">Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento_imprimir" name="mod_nombre_comercial_establecimiento_imprimir" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_folio_imprimir" class="col-sm-3 control-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio_imprimir" name="mod_folio_imprimir" disabled>
</div>
</div>

<br>
<div class="form-group row">
<label for="mod_numero_permiso_imprimir" class="col-sm-3 control-label">Número Permiso</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_numero_permiso_imprimir" name="mod_numero_permiso_imprimir" disabled>
</div>
</div>

<br>

<div class="form-group row">
<label for="nip" class="col-sm-3 col-form-label">NIP </label>
<div class="col-sm-6">
<input type="text" class="form-control" id="nip" name="nip"  autocomplete="off"   required>
</div>
</div>

<br>

<div class="alert alert-warning">
<i class="bi bi-exclamation-triangle"></i> Esta acción Imprimirá el Permiso, requieres el NIP.
</div>




<br>

			 
			
</div>
 <div class="modal-footer">
<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-danger" id="Button_imprimirPermiso">
<i class="bi bi-key"></i>Validar NIP</button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

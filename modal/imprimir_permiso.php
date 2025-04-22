	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="imprimirpermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

                  <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="ImprimirPermisoLabel"><i class="bi bi-postcard"></i> Imprimir Permiso</h5>

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="elegir_tramite" name="elegir_tramite" action="aprobarPresupuestoCambio.php">
			<div id="resultados_ajaxElegirTramite"></div>


<input type="hidden" id="mod_id" name="IDPRINCIPAL">


<div class="form-group row">
<label for="nombre_comercial_establecimiento" class="col-sm-3 control-label">Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento" name="nombre_comercial_establecimiento" disabled>
</div>
</div>

<div class="form-group row">
<label for="folio" class="col-sm-3 control-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio" name="folio" disabled>
</div>
</div>

<br>

<div class="form-group row">
<label for="nip" class="col-sm-3 col-form-label">NIP </label>
<div class="col-sm-6">
<input type="password" class="form-control" id="nip" name="nip"  autocomplete="off"   required>
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
<button type="submit" class="btn btn-danger" id="Button_imprimir_permiso">
<i class="bi bi-key"></i>Validar NIP</button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

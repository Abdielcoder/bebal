
<script type="text/javascript">
function mostrarPassword(){

                var cambio = document.getElementById("txtPassword");
                if(cambio.type == "password"){
                        cambio.type = "text";
                        $('.icon').removeClass('bi bi-eye-slash-fill').addClass('bi bi-eye-fill');
                }else{
                        cambio.type = "password";
                        $('.icon').removeClass('bi bi-eye-fill').addClass('bi bi-eye-slash-fill');
                }
        }


        $(document).ready(function () {
        //CheckBox mostrar contraseña
        $('#ShowPassword').click(function () {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        });
});




</script>

<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

?>
	<!-- Modal -->
	<div class="modal fade" id="imprimirpermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" >
		<div class="modal-content"  style="background-color:#FF0000;color:white">

                  <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="ImprimirPermisoLabel"><i class="bi bi-p-square"></i> Imprimir Permiso</h5>

			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="imprimirPermiso" name="imprimirPermiso" action="permiso_pdf_html.php" target="_blank">
			<div id="resultados_ajaxImprimirPermiso"></div>


<input type="hidden" id="mod_id_imprimir" name="id">


<div class="form-group row">
<label for="mod_nombre_comercial_establecimiento_imprimir" class="col-sm-3 control-label"><font size="2">Establecimiento</font></label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_nombre_comercial_establecimiento_imprimir" name="mod_nombre_comercial_establecimiento_imprimir" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_folio_imprimir" class="col-sm-3 control-label"><font size="2">Folio del Sistema</font></label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio_imprimir" name="mod_folio_imprimir" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_numero_permiso_imprimir" class="col-sm-3 control-label"><font size="2">Número Permiso</font></label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_numero_permiso_imprimir" name="mod_numero_permiso_imprimir" disabled>
</div>
</div>

<div class="form-group row">
<label for="folio_carton" class="col-sm-3 control-label"><font size="2">Folio del Cartón</font></label>
<div class="col-sm-8">
<input type="text" class="form-control" id="folio_carton" name="folio_carton" pattern="[0-9]{5}"  title="Formato VALIDO -->  NNNNNN" minlength="5" maxlength="5"  required>
</div>
</div>

<div class="input-group mb-2">
<label for="nip" class="col-sm-4 col-form-label"><font size="2">NIP</font></label>
<input type="password" ID="txtPassword" class="form-control" id="nip" name="nip"  autocomplete="off"   minlength="6" maxlength="6"  required>
<div class="input-group-append">
    <button id="show_password" class="btn btn-xs btn-basic" type="button" onclick="mostrarPassword()"> <i class="bi bi-eye-slash-fill icon"></i> </button>

          </div>
</div>

<br>
<div class="alert alert-warning">
<i class="bi bi-exclamation-triangle"></i><font size="2">Esta acción Imprimirá el Permiso, requieres el NIP.</font></div>

			
</div>
 <div class="modal-footer">
<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal"><font size="2">Cancelar</font></button>
<button type="submit" class="btn btn-xs btn-danger" id="imprimirPermiso">
<i class="bi bi-key"></i><font size="2">Validar NIP</font></button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

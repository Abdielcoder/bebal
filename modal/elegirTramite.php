	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="elegirTramite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">


			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Seleccionar Tramite</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="elegir_tramite" name="elegir_tramite" action="aprobarPresupuestoCambio.php">
			<div id="resultados_ajaxElegirTramite"></div>


<input type="hidden" id="mod_id" name="IDPRINCIPAL">
<input type="hidden" id="pagina" name="page">


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

<div class="form-group row">
<?php
echo '<label for="ID_TRAMITE_SOLICITADO" class="col-sm-3 control-label">Tramite</label>';
?>
<div class="col-sm-8">
<select class='form-control  form-select' name='ID_TRAMITE_SOLICITADO' id='ID_TRAMITE_SOLICITADO' required>
<?php 
echo '<option value="">Seleccione Tramite</option>';
$query=mysqli_query($con,"SELECT * FROM tramite WHERE operacion='Cambio' OR operacion='Imprimir' OR operacion='Revalidacion' ORDER BY operacion");
while($row=mysqli_fetch_array($query))	{
$id_tramite=$row['id'];
$descripcion_tramite=$row['descripcion_tramite'];
$monto_umas=$row['monto_umas'];
$descuento=$row['descuento'];

if ( $descuento=='SI' ) {
$COBRO=$monto_umas.' % Descuento';
} else {
$COBRO=$monto_umas.' UMAS';
}
echo '<option value="'.$id_tramite.'">'.$descripcion_tramite.' ('.$COBRO.')</option>';
}

##mysqli_close($con);

?>
</select>			  
</div>
</div>

<br>

			 
			
</div>
 <div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary" id="Button_elegir_tramite"> Selecciona Tramite </button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

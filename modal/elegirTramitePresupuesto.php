	<?php
		if (isset($con))
		{
$PROFILE=$_SESSION['user_profile'];
$ID_MUNICIPIO=$_SESSION['user_id_municipio'];

	?>
	<!-- Modal -->
	<div class="modal fade" id="elegirTramitePresupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
<div class="modal-header"  style="background-color:#AC905B;color:white">


			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h6 class="modal-title" id="myModalLabel"><i class='bi bi-calculator'></i> Seleccionar Tramite Presupuesto</h6>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="elegir_tramitePresupuesto" name="elegir_tramitePresupuesto" action="generarPresupuesto_pdf_html.php">
			<div id="resultados_ajaxElegirTramitePresupuesto"></div>


<input type="hidden" id="mod_id_data" name="IDPRINCIPAL">
<input type="hidden" id="pagina" name="page">


<div class="form-group row">
<label for="nombre_comercial_establecimiento_data" class="col-sm-3 control-label">Establecimiento</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="nombre_comercial_establecimiento_data" name="nombre_comercial_establecimiento" disabled>
</div>
</div>

<div class="form-group row">
<label for="mod_folio_data" class="col-sm-3 control-label">Folio</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="mod_folio_data" name="mod_folio_data" disabled>
</div>
</div>

<div class="form-group row">
<?php
echo '<label for="ID_TRAMITE_SOLICITADO" class="col-sm-3 control-label">Seleccione Tramite</label>';
?>
<div class="col-sm-8">
<?php 
$query=mysqli_query($con,"SELECT * FROM tramite WHERE operacion='Cambio' OR operacion='Imprimir' OR operacion='Revalidacion' ORDER BY operacion");

while($row=mysqli_fetch_array($query))	{

$id_tramite=$row['id'];
$descripcion_tramite=$row['descripcion_tramite'];
$monto_umas=$row['monto_umas'];
$descuento=$row['descuento'];

echo '<input type="checkbox" name="TRAMITES[]" value="'.$id_tramite.'**'.$descripcion_tramite.'**'.$monto_umas.'**">&nbsp; <font size="1">'.$descripcion_tramite.'</font><br>';
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
<button type="submit" class="btn btn-primary" id="Button_elegir_tramitePresupuesto"> Selecciona Tramite </button>
  </div>
  </form>
 </div>
 </div>
</div>
	<?php
		}
	?>

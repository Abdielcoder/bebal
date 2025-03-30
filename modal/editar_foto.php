<style>

::-webkit-file-upload-button {
  background: orange;
  color: white;
  padding: 1em;
}

</style>


<?php
	if (isset($con)) {


	##<!-- Modal -->
	echo '<div class="modal fade" id="editarFoto'.$row["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabelFoto">';
	?>
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabelFoto"><i class='glyphicon glyphicon-edit'></i> Editar Foto Valla</h4>
		  </div>
<?php
echo '<div class="modal-body">';


$ID=$row['id'];
$foto=$row['foto'];

echo '<form ENCTYPE="multipart/form-data" name="formaEditar_foto'.$row["id"].'" action="ajax/editar_valla_foto.php" method = "POST">';


$ret='';
//$ret .= '<form ENCTYPE="multipart/form-data" name="formaEditar_foto'.$row["id"].'" action="ajax/editar_valla_foto.php" method = "POST">';
//$ret  .= '<form enctype="multipart/form-data" method="post"  action="editar_producto_foto"  id="editar_producto_foto" name="editar_producto_foto">';
//$ret .= '<div id="resultados_ajax20"></div>';
$ret .= "<input type=\"file\" name=\"imagenFilechang\" >";
$ret .= "<input type=\"hidden\" name=\"prim\" value=\"yaentro\">";
$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$row['id']."\">";
$ret .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"7000000\">";

		echo '<table width="95%">';

		echo '<tr>';
		echo '<td width="30%">';
		echo '<label for="Id" class="col-sm-3 control-label">Id</label>';
		echo '</td>';
		echo '<td width="70%">';
		echo '<input type="text" class="form-control" name="valla_id" value="'.$row["id"].'" disabled>';
		echo '</td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td width="30%">';
		echo '<label for="folio" class="col-sm-3 control-label">Folio</label>';
		echo '</td>';
		echo '<td width="70%">';
		echo '<input type="text" class="form-control" name="valla_numero_permiso" value="'.$row["numero_permiso"].'" disabled>';
		echo '</td>';

		echo '</tr><tr></tr>';
		echo '<tr>';
		echo '<td width="30%">';
		echo '<label for="mod_codigo" class="col-sm-3 control-label">Imagen</label>';
		echo '</td>';
		echo '<td width="70%">'.$ret;
		echo '</td>';

		echo '</tr></table>';


echo '<div class="form-group">';
echo '</div>';
echo '</div>';

echo '<div class="form-group">';
echo '<div class="col-sm-4">';
echo '</div>';
echo '</div>';
			 

echo '<div class="form-group">';
echo '<div class="col-sm-6"> ';
$foto_file= '../../'.FOTOSMEDIAS.$foto;

if ( $foto==NULL || $foto=='' ) echo '<img class="item-img img-responsive" src="img/no_imagen.jpg" alt="" alt="" width="160px">';
else {
	if ( file_exists($foto_file)!=1 ) echo '<img class="item-img img-responsive" src="img/no_imagen.jpg" alt="" alt="" width="160px">';
	else 
	 echo '<img class="item-img img-responsive" src="'.$foto_file.'" alt=""  width="200">';
}

echo '</div>';



echo '</div>';
echo '<div class="modal-footer">';
//echo '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>';
echo '<button type="submit" class="btn btn-info" name="actualizar_datos_foto'.$row["id"].'" id="actualizar_datos_foto'.$row["id"].'">Actualizar Imagen</button>';

echo '</div>';
echo '</form>';
echo '</div>';
?>
	 </div>
	</div>
	<?php
	}
?>


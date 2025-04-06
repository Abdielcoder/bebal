<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_colonia=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * FROM colonias WHERE id=".$id_colonia);
		$count=mysqli_num_rows($query);
		if ($count==1){
			if ($delete1=mysqli_query($con,"DELETE FROM colonias WHERE id=".$id_colonia)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar esta  Colonia.. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('colonia');//Columnas de busqueda
		 $sTable = "colonias";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" ORDER BY id_delegacion, id_municipio";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './colonia.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			<table class="table">
			<tr  class="success">
			<th><font size="2">Nombre Colonia</font></th>
			<th><font size="2">Delegación</font></th>
			<th><font size="2">Municipio</font></th>
			<th class='text-right'><font size="2">Acciones</font></th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
				$id=$row['id'];
				$id_delegacion=$row['id_delegacion'];
				$id_municipio=$row['id_municipio'];
				$colonia=$row['colonia'];

				$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
				$result_municipio = mysqli_query($con,$sql_municipio);
				$row_municipio = mysqli_fetch_assoc($result_municipio);
				$MUNICIPIO=$row_municipio['municipio'];

				$sql_delegacion="SELECT delegacion FROM delegacion WHERE id_municipio=".$id_municipio." AND id=".$id_delegacion;
				$result_delegacion = mysqli_query($con,$sql_delegacion);
				$row_delegacion = mysqli_fetch_assoc($result_delegacion);
				$DELEGACION=$row_delegacion['delegacion'];

?>

					
<input type="hidden" value="<?php echo $row['colonia'];?>" id="colonia<?php echo $id;?>">
<input type="hidden" value="<?php echo $row['id'];?>" id="id<?php echo $id;?>">
<input type="hidden" value="<?php echo $id_colonia;?>" id="id_colonia<?php echo $id;?>">
<input type="hidden" value="<?php echo $id_delegacion;?>" id="id_delegacion<?php echo $id;?>">
<input type="hidden" value="<?php echo $DELEGACION;?>" id="DELEGACION<?php echo $id;?>">


				<tr>
						
				<td><font size="2"><?php echo $colonia; ?></font></td>
				<td><font size="2"><?php echo $DELEGACION; ?></font></td>
				<td><font size="2"><?php echo $MUNICIPIO; ?></font></td>
						
				<td class='text-right'>
<?php
echo '<a href="#" class="btn btn-outline-success" title="Editar Colonia" onclick="obtener_datos('.$id.');" data-bs-toggle="modal" data-bs-target="#editarColonia"><i class="bi bi-pencil"></i></a>';

echo '&nbsp;&nbsp;';

echo '<a href="#" class="btn btn-outline-danger" title="Eliminar Colonia" onclick="eliminar('.$id.')"><i class="bi bi-trash bg-warnig"></i></a>';
?>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=4><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>

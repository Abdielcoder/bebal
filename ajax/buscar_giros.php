<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_giro=intval($_GET['id']);
		$query=mysqli_query($con, "SELECT * FROM giro WHERE id=".$id_giro);
		$count=mysqli_num_rows($query);
		if ($count==1){
			if ($delete1=mysqli_query($con,"DELETE FROM giro WHERE id=".$id_giro)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Dato eliminado exitosamente.
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
		 $aColumns = array('descripcion_giro');//Columnas de busqueda
		 $sTable = "giro";
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
		$sWhere.=" ORDER BY descripcion_giro, id";
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
		$reload = './giro.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			<table class="table">
			<tr  class="success">
			<th><font size="2">Giro</font></th>
			<th><font size="2">Cuenta</font></th>
			<th><font size="2">Monto UMAS</font></th>
			<th><font size="2">Horario Funcionamiento</font></th>
			<th><font size="2">Concepto</font></th>
			<th><font size="2">Acciones</font></th>
			</tr>
<?php
	while ($row=mysqli_fetch_array($query)){
	$id=$row['id'];
	$descripcion_giro=$row['descripcion_giro'];
	$cuenta=$row['cuenta'];
	$monto_umas=$row['monto_umas'];
	$concepto=$row['concepto'];
	$fecha=$row['fecha'];
	$horario_funcionamiento=$row['horario_funcionamiento'];


?>

					
<input type="hidden" value="<?php echo $row['id'];?>" id="id<?php echo $id;?>">
<input type="hidden" value="<?php echo $row['descripcion_giro'];?>" id="descripcion_giro<?php echo $id;?>">
<input type="hidden" value="<?php echo $cuenta;?>" id="cuenta<?php echo $id;?>">
<input type="hidden" value="<?php echo $monto_umas;?>" id="monto_umas<?php echo $id;?>">
<input type="hidden" value="<?php echo $concepto;?>" id="concepto<?php echo $id;?>">
<input type="hidden" value="<?php echo $horario_funcionamiento;?>" id="horario_funcionamiento<?php echo $id;?>">
<input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id;?>">


		<tr>
		<td><font size="2"><?php echo $descripcion_giro; ?></font></td>
		<td><font size="2"><?php echo $cuenta; ?></font></td>
		<td ><font size="2"><?php echo $monto_umas; ?></font></td>
		<td><font size="1"><?php echo $horario_funcionamiento; ?></font></td>
		<td ><font size="1"><?php echo $concepto; ?></font></td>
		<td class='text-right'>
<?php
echo '<a href="#" class="btn btn-outline-success" title="Editar Giro" onclick="obtener_datosGiro('.$id.');" data-bs-toggle="modal" data-bs-target="#editarGiro" disabled><i class="bi bi-pencil"></i></a>';

echo '&nbsp;&nbsp;';

echo '<a href="#" class="btn btn-outline-danger" title="Eliminar Giro" onclick="eliminar('.$id.')" disabled><i class="bi bi-trash"></i></a>';
?>
						
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

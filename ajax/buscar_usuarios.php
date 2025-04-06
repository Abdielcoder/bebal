<?php

	/*-------------------------
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$user_id=intval($_GET['id']);
		$query=mysqli_query($con, "select * from users where user_id='".$user_id."'");
		$rw_user=mysqli_fetch_array($query);
		$count=$rw_user['user_id'];
		if ($user_id!=1){
			if ($delete1=mysqli_query($con,"DELETE FROM users WHERE user_id='".$user_id."'")){
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
			  <strong>Error!</strong> No se puede borrar el usuario administrador. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('firstname', 'lastname');//Columnas de busqueda
		 $sTable = "users";
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
		$sWhere.=" order by user_id desc";
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
		$reload = './usuarios.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			 <table class="table">
			<tr  class="success">
			<th><font size="2">Nombres</font></th>
			<th><font size="2">Usuario</font></th>
			<th><font size="2">Profile</font></th>
			<th><font size="2">Email</font></th>
			<th><font size="2">Municipio</font></th>
			<th><font size="2">Agregado</font></th>
			<th><span class="pull-right"><font size="2">Acciones</span></font></th>
					
			</tr>
			<?php
			while ($row=mysqli_fetch_array($query)){
				$user_id=$row['user_id'];
				$fullname=$row['firstname']." ".$row["lastname"];
				$user_name=$row['user_name'];
				$user_email=$row['user_email'];
				$user_profile=$row['profile'];
				$date_added= date('d/m/Y', strtotime($row['date_added']));
				$id_municipio=$row['id_municipio'];


				if ( $id_municipio==0 ) {
				$MUNICIPIO='Todos';
				} else {
				if ( $id_municipio=='' || $id_municipio==NULL ) {
				$MUNICIPIO='Sin Municipio';
				} else {

				$sql_municipio="SELECT municipio FROM municipio WHERE id=".$id_municipio;
				$result_municipio = mysqli_query($con,$sql_municipio);
				$row_municipio = mysqli_fetch_assoc($result_municipio);
				$MUNICIPIO=$row_municipio['municipio'];


				}
				}

						
			?>
					
<input type="hidden" value="<?php echo $row['firstname'];?>" id="nombres<?php echo $user_id;?>">
<input type="hidden" value="<?php echo $row['lastname'];?>" id="apellidos<?php echo $user_id;?>">
<input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
<input type="hidden" value="<?php echo $user_email;?>" id="email<?php echo $user_id;?>">
				
			<tr>
			<td><font size="2"><?php echo $fullname; ?></font></td>
			<td><font size="2"><?php echo $user_name; ?></font></td>
			<td><font size="2"><?php echo $user_profile; ?></font></td>
			<td><font size="2"><?php echo $user_email; ?></font></td>
			<td><font size="2"><?php echo $MUNICIPIO; ?></font></td>
			<td><font size="2"><?php echo $date_added;?></font></td>
						
			<td><span class="pull-right">

<?php

echo '<a href="#" class="btn btn-outline-success" title="Editar usuario" onclick="obtener_datosUsuario('.$user_id.');" data-bs-toggle="modal" data-bs-target="#editarUsuario"><i class="bi bi-pencil"></i></a> ';

echo '&nbsp;&nbsp;';

echo '<a href="#" class="btn btn-outline-warning" title="Cambiar contraseña" onclick="get_user_id('.$user_id.');" data-bs-toggle="modal" data-bs-target="#cambiarPassUsuario"><i class="bi bi-key"></i></a>';

echo '&nbsp;&nbsp;';

echo '<a href="#" class="btn btn-outline-danger" title="Borrar usuario" onclick="eliminar('.$user_id.')"><i class="bi bi-trash"></i> </a></span></td>';

?>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=9><span class="pull-right">
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

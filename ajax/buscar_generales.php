<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_almacen=intval($_GET['id']);
		$query=mysqli_query($con, "select * from generales where id='".$id_generales."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM generales WHERE id='".$id_generales."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  almacén. Existen productos vinculados a éste almacén. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('dato_general');//Columnas de busqueda
		 $sTable = "generales";
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
		$sWhere.=" order by id";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);


    // Validar que la página solicitada esté dentro del rango válido
    if ($page < 1) $page = 1;
    if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

    // Recalcular el offset basado en la página validada
    $offset = ($page - 1) * $per_page;

    // Definir URL de recarga para la paginación (mantiene la búsqueda)
     $reload = './generales.php';
    if (!empty($q)) {
        $reload .= "?q=" . urlencode($q) . "&";
    } else {
        $reload .= "?";
    }



		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			<table class="table  registro-table">
                	<thead>
			<tr  class="success">
			<th><font size="1">Dato General</font></th>
			<th><font size="1">Descripción</font></th>
			<th class='text-right'><font size="1">Acciones</font></th>
			</tr>
                	</thead>
                	<tbody>

				<?php
			while ($row=mysqli_fetch_array($query)){
				$id=$row['id'];
				$dato_general=$row['dato_general'];
				$descripcion=$row['descripcion'];
				$fecha=$row['fecha'];



					?>
					<tr>
				
				<td><font size="2"><?php echo $dato_general; ?></font></td>
				<td><font size="2"><?php echo $descripcion; ?></font></td>

<input type="hidden"  id="dato_general<?php echo $id;?>"   value="<?php echo $dato_general;?>"  >
<input type="hidden"  id="descripcion<?php echo $id;?>"  value="<?php echo $descripcion;?>"  >

<input type="hidden"  id="dato_generalOtro<?php echo $id;?>"   value="<?php echo $dato_general;?>"  >
<input type="hidden"  id="descripcionOtro<?php echo $id;?>"  value="<?php echo $descripcion;?>"  >


				<td class='text-right'>


<?php
if ( $dato_general=='Firma' )  {
echo '<a href="#" class="btn btn-outline-success" title="Firma" onclick="obtener_datosGeneralesFirma('.$id.');" data-bs-toggle="modal" data-bs-target="#editarGeneralesFirma"><i class="bi bi-key"></i></a>';
} else {
echo '<a href="#" class="btn btn-outline-success" title="Datos Generales" onclick="obtener_datosGenerales('.$id.');" data-bs-toggle="modal" data-bs-target="#editarGenerales"><i class="bi bi-pencil"></i></a>';
}

echo '&nbsp;&nbsp;';

echo '<a href="#" class="btn btn-outline-danger" title="Eliminar Campo" onclick="#eliminar('.$id.')"><i class="bi bi-trash bg-warnig"></i></a>';

	echo '</td>';
	echo '</tr>';
	}  //** while
?>

                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="pagination-container text-center mt-4">
                    <?php
                    // Asegurarse de que la paginación use el parámetro 'page' para mantener consistencia
                    echo paginate($reload, $page, $total_pages, $adjacents);
                    ?>
                </div>
                <div class="col-md-12 text-center">
                    <p class="text-muted">
<!--                       Mostrando <?php echo min($numrows, ($offset+1)); ?> al
                        <?php echo min($offset+$per_page, $numrows); ?> de
                        <?php echo $numrows; ?> registros --!>
                    </p>
                </div>
            </div>
        </div>
        <?php
    } else {
        // No hay resultados
        ?>
        <div class="alert alert-warning text-center">No hay resultados para esta búsqueda.</div>
        <?php
    }
} else {
    echo "No se ha especificado una acción válida.";
}
?>


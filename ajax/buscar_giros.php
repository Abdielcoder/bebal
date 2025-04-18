<?php


function funcion_MES ($mes)
{

switch ($mes) {
        case "01":
        return "Enero";
        break;
        case "02":
        return "Febrero";
        break;
        case "03":
        return "Marzo";
        break;
        case "04":
        return "Abril";
        break;
        case "05":
        return "Mayo";
        break;
        case "06":
        return "Junio";
        break;
        case "07":
        return "Julio";
        break;
        case "08":
        return "Agosto";
        break;
        case "09":
        return "Septiembre";
        break;
        case "10":
        return "Octubre";
        break;
        case "11":
        return "Noviembre";
        break;
        case "12":
        return "Diciembre";
        break;
}

}



// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
	if($action == 'ajax') {
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

###################
###
		include 'pagination.php'; //include pagination file
		//pagination variables
$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;

		##echo 'page='.$page.', per_page='.$per_page.', adjacents='.$adjacents.', offset='.$offset.', page='.$page.'<br>';

		//Count the total number of row in your table*/
		//echo "SELECT count(*) AS numrows FROM $sTable  $sWhere <br>";
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
$reload = './giro.php';
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
			<table class="table registro-table">
			<thead>
			<tr  class="success">
			<th><font size="1">Giro</font></th>
			<th><font size="1">Cuenta</font></th>
			<th><font size="1">Monto UMAS (ALTA)</font></th>
			<th><font size="1">Monto UMAS (REVAL ANUAL)</font></th>
			<th><font size="1">Horario Funcionamiento</font></th>
			<th><font size="1">Concepto/MesV</font></th>
			<th><font size="1">Acciones</font></th>
			</tr>
			</thead>
			</tbody>
<?php
	while ($row=mysqli_fetch_array($query)){
	$id=$row['id'];
	$descripcion_giro=$row['descripcion_giro'];
	$cuenta=$row['cuenta'];
	$monto_umas=$row['monto_umas'];
	$monto_umas_revalidacion_anual=$row['monto_umas_revalidacion_anual'];
	$mes_vencimiento=$row['mes_vencimiento'];
	$concepto=$row['concepto'];
	$fecha=$row['fecha'];
	$horario_funcionamiento=$row['horario_funcionamiento'];


	$MES_LETRA = funcion_mes($mes_vencimiento);

?>

					
<input type="hidden" value="<?php echo $row['id'];?>" id="id<?php echo $id;?>">
<input type="hidden" value="<?php echo $row['descripcion_giro'];?>" id="descripcion_giro<?php echo $id;?>">
<input type="hidden" value="<?php echo $row['monto_umas_revalidacion_anual'];?>" id="monto_umas_revalidacion_anual<?php echo $id;?>">
<input type="hidden" value="<?php echo $row['mes_vencimiento'];?>" id="mes_vencimiento<?php echo $id;?>">
<input type="hidden" value="<?php echo $cuenta;?>" id="cuenta<?php echo $id;?>">
<input type="hidden" value="<?php echo $monto_umas;?>" id="monto_umas<?php echo $id;?>">
<input type="hidden" value="<?php echo $monto_umas_revalidacion_anual;?>" id="monto_umas_revalidacion_anual<?php echo $id;?>">
<input type="hidden" value="<?php echo $concepto;?>" id="concepto<?php echo $id;?>">
<input type="hidden" value="<?php echo $horario_funcionamiento;?>" id="horario_funcionamiento<?php echo $id;?>">
<input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id;?>">


		<tr>
		<td><font size="1"><?php echo $descripcion_giro; ?></font></td>
		<td align="center"><font size="2"><?php echo $cuenta; ?></font></td>
		<td align="center"><font size="2"><?php echo number_format($monto_umas,2); ?></font></td>
		<td align="center"><font size="2"><?php echo number_format($monto_umas_revalidacion_anual,2); ?></font></td>
		<td><font size="1"><?php echo $horario_funcionamiento; ?></font></td>
		<td><font size="1"><?php echo $concepto.' / <font color="blue">'.$MES_LETRA; ?></font></td>
		<td class='text-right'>
<?php
echo '<a href="#" class="btn btn-outline-success" title="Editar Giro" onclick="obtener_datosGiro('.$id.');" data-bs-toggle="modal" data-bs-target="#editarGiro" disabled><i class="bi bi-pencil"></i></a>';

echo '&nbsp;&nbsp;';

echo '<a href="#" class="btn btn-outline-danger" title="Eliminar Giro" onclick="#eliminar('.$id.')" ><i class="bi bi-trash"></i></a>';
?>
						
					</tr>
					<?php
}  ### While
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





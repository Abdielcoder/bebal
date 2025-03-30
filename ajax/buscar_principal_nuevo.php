<?php
session_start();

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('is_logged.php'); // Archivo verifica que el usuario que intenta acceder está logueado

/* Connect To Database*/
require_once ("../config/db.php"); // Contiene variables de configuración para la base de datos
require_once ("../config/conexion.php"); // Contiene función que conecta a la base de datos

// Verificar conexión a la base de datos
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

$PROFILE = $_SESSION['user_profile'];
$ID_MUNICIPIO = $_SESSION['user_id_municipio'];

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

// Procesar eliminación si se recibe ID por GET
if (isset($_GET['id'])) {
    $id_principal = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * FROM principal WHERE id=".$id_principal);
    if (!$query) {
        die("Error en consulta de eliminación: " . mysqli_error($con));
    }
    $count = mysqli_num_rows($query);
    if ($count != 0) {
        if ($delete1 = mysqli_query($con, "UPDATE principal SET estatus='ELIMINADO' WHERE id=".$id_principal)) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Registro Eliminado Exitosamente.
            </div>
            <?php 
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
              <p><?php echo mysqli_error($con); ?></p>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> No se pudo eliminar el registro.
        </div>
        <?php
    }
}

// Mostrar la lista de registros
if ($action == 'ajax') {
    // Escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('domicilio'); // Columnas de búsqueda
    $sTable = "principal";
    
    // Construir cláusula WHERE según perfil de usuario
    if ($ID_MUNICIPIO == 0) {
        $sWhere = "";
    } else {
        $sWhere = "WHERE id_municipio=".$ID_MUNICIPIO;
    }
    
    // Agregar filtro de búsqueda si se proporciona
    if (!empty($q)) {
        if (empty($sWhere)) {
            $sWhere = "WHERE (";
        } else {
            $sWhere .= " AND (";
        }
        
        for ($i=0; $i<count($aColumns); $i++) {
            $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    
    // Ordenar resultados
    $sWhere .= (empty($sWhere) ? " WHERE " : " AND ") . " estatus!='ELIMINADO' ORDER BY id DESC";
    
    // Verificar si la tabla existe
    $table_check = mysqli_query($con, "SHOW TABLES LIKE '$sTable'");
    if (mysqli_num_rows($table_check) == 0) {
        die("Error: La tabla '$sTable' no existe en la base de datos.");
    }
    
    // Verificar estructura de la tabla
    $structure_check = mysqli_query($con, "DESCRIBE $sTable");
    if (!$structure_check) {
        die("Error al verificar la estructura de la tabla: " . mysqli_error($con));
    }
    
    // Configuración de paginación
    include 'pagination.php';
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 3; // Registros por página
    $adjacents = 4; // Espacios entre páginas
    $offset = ($page - 1) * $per_page;
    
    // Contar registros totales
    $count_sql = "SELECT count(*) AS numrows FROM $sTable $sWhere";
    $count_query = mysqli_query($con, $count_sql);
    if (!$count_query) {
        die("Error en consulta de conteo: " . mysqli_error($con) . "<br>SQL: " . $count_sql);
    }
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    $reload = './principal.php';
    
    // Consulta principal
    $main_sql = "SELECT * FROM $sTable $sWhere LIMIT $offset,$per_page";
    echo "<!-- Debug SQL: " . $main_sql . " -->";
    $query = mysqli_query($con, $main_sql);
    if (!$query) {
        die("Error en consulta principal: " . mysqli_error($con) . "<br>SQL: " . $main_sql);
    }
    
    // Mostrar resultados
    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table registro-table">
                <thead>
                    <tr class="success">
                        <th>Imagen</th>
                        <th>Datos Establecimiento</th>
                        <th>Solicitante</th>
                        <th>Observación</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $ciclo = 1;
                while ($row = mysqli_fetch_array($query)) {
                    $id = $row['id'];
                    $nombre_comercial = $row['nombre_comercial_establecimiento'];
                    $calle = $row['calle_establecimiento'];
                    $entre_calles = $row['entre_calles_establecimiento'];
                    $numero = $row['numero_establecimiento'];
                    $numero_interno = $row['numerointerno_local_establecimiento'];
                    $estatus = $row['estatus'];
                    $folio = $row['folio'];
                    $observaciones = $row['observaciones'];
                    $nombre_solicitante = $row['nombre_persona_fisicamoral_solicitante'];
                    $email = $row['email_solicitante'];
                    $telefono = $row['telefono_solicitante'];
                    ?>
                    <tr>
                        <td data-label="Imagen">
                            <a href="#"><img class="img-thumbnail-custom" src="img/no_imagen.jpg" alt="No Existe Foto"></a>
                            <span class="d-block text-muted mt-2"><small>ID: <?php echo $id; ?> | Folio: <?php echo $folio; ?></small></span>
                        </td>
                        <td data-label="Datos Establecimiento">
                            <div class="datos-establecimiento">
                                <span class="nombre-comercial"><?php echo ucwords($nombre_comercial); ?></span>
                                <span class="direccion"><?php echo $calle . ' ' . $numero; ?></span>
                                <span class="direccion"><?php echo $entre_calles; ?></span>
                            </div>
                        </td>
                        <td data-label="Solicitante">
                            <div class="datos-solicitante">
                                <span class="nombre-comercial"><?php echo ucwords($nombre_solicitante); ?></span>
                                <span class="contacto"><span class="etiqueta">Email:</span> <?php echo $email; ?></span>
                                <span class="contacto"><span class="etiqueta">Tel:</span> <?php echo $telefono; ?></span>
                            </div>
                        </td>
                        <td data-label="Observación">
                            <?php 
                            if (strlen($observaciones) > 150) {
                                echo substr($observaciones, 0, 150) . '...';
                            } else {
                                echo $observaciones; 
                            }
                            ?>
                        </td>
                        <td data-label="Acciones" class="text-end">
                            <div class="action-buttons">
                                <a href="#" class="btn btn-sm btn-action btn-primary-custom" title="Editar registro" onclick="obtener_datos('<?php echo $id; ?>','<?php echo $page; ?>');"><i class="bi bi-pencil"></i></a>
                                <div class="estatus-badge estatus-inspeccion mt-2"><?php echo $estatus; ?></div>
                            </div>
                        </td>
                    </tr>
                <?php
                    $ciclo++;
                }
                ?>
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="pagination-container text-center mt-4">
                    <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                </div>
                <div class="col-md-12 text-center">
                    <p class="text-muted">Mostrando <?php echo ($offset+1); ?> al <?php echo min($offset+$per_page, $numrows); ?> de <?php echo $numrows; ?> registros</p>
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

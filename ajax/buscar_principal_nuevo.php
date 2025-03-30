<?php
// Quito session_start() ya que is_logged.php también lo hace

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
                    $foto = isset($row['foto']) ? $row['foto'] : "";
                    $mapa = isset($row['mapa']) ? $row['mapa'] : "";
                    
                    // Valores ocultos para los modales y acciones
                    ?>
                    <input type="hidden" id="folio<?php echo $id; ?>" value="<?php echo $folio; ?>">
                    <input type="hidden" id="numero_permiso<?php echo $id; ?>" value="<?php echo isset($row['numero_permiso']) ? $row['numero_permiso'] : ''; ?>">
                    <input type="hidden" id="mapa<?php echo $id; ?>" value="<?php echo $mapa; ?>">
                    <input type="hidden" id="estatus<?php echo $id; ?>" value="<?php echo $estatus; ?>">
                    <input type="hidden" id="operacion<?php echo $id; ?>" value="<?php echo isset($row['operacion']) ? $row['operacion'] : ''; ?>">
                    <input type="hidden" id="observaciones<?php echo $id; ?>" value="<?php echo $observaciones; ?>">
                    <input type="hidden" id="direccion<?php echo $id; ?>" value="<?php echo isset($row['direccion']) ? $row['direccion'] : ''; ?>">
                    <input type="hidden" id="delegacion_id<?php echo $id; ?>" value="<?php echo isset($row['delegacion_id']) ? $row['delegacion_id'] : ''; ?>">
                    <input type="hidden" id="colonia_id<?php echo $id; ?>" value="<?php echo isset($row['colonia_id']) ? $row['colonia_id'] : ''; ?>">
                    <input type="hidden" id="COLONIA<?php echo $id; ?>" value="<?php echo isset($row['COLONIA']) ? $row['COLONIA'] : ''; ?>">
                    <input type="hidden" id="DELEGACION<?php echo $id; ?>" value="<?php echo isset($row['DELEGACION']) ? $row['DELEGACION'] : ''; ?>">
                    <input type="hidden" id="GIRO<?php echo $id; ?>" value="<?php echo isset($row['GIRO']) ? $row['GIRO'] : ''; ?>">
                    <input type="hidden" id="MODALIDAD_GA<?php echo $id; ?>" value="<?php echo isset($row['MODALIDAD_GA']) ? $row['MODALIDAD_GA'] : ''; ?>">
                    <input type="hidden" id="nombre_comercial_establecimiento<?php echo $id; ?>" value="<?php echo $nombre_comercial; ?>">
                    <input type="hidden" id="calle_establecimiento<?php echo $id; ?>" value="<?php echo $calle; ?>">
                    <input type="hidden" id="entre_calles_establecimiento<?php echo $id; ?>" value="<?php echo $entre_calles; ?>">
                    <input type="hidden" id="numero_establecimiento<?php echo $id; ?>" value="<?php echo $numero; ?>">
                    <input type="hidden" id="numerointerno_local_establecimiento<?php echo $id; ?>" value="<?php echo $numero_interno; ?>">
                    <input type="hidden" id="cp_establecimiento<?php echo $id; ?>" value="<?php echo isset($row['cp_establecimiento']) ? $row['cp_establecimiento'] : ''; ?>">
                    <input type="hidden" id="nombre_persona_fisicamoral_solicitante<?php echo $id; ?>" value="<?php echo $nombre_solicitante; ?>">
                    <input type="hidden" id="nombre_representante_legal_solicitante<?php echo $id; ?>" value="<?php echo isset($row['nombre_representante_legal_solicitante']) ? $row['nombre_representante_legal_solicitante'] : ''; ?>">
                    <input type="hidden" id="domicilio_solicitante<?php echo $id; ?>" value="<?php echo isset($row['domicilio_solicitante']) ? $row['domicilio_solicitante'] : ''; ?>">
                    <input type="hidden" id="email_solicitante<?php echo $id; ?>" value="<?php echo $email; ?>">
                    <input type="hidden" id="telefono_solicitante<?php echo $id; ?>" value="<?php echo $telefono; ?>">
                    <input type="hidden" id="COLONIAyDELEGACION<?php echo $id; ?>" value="<?php echo isset($row['COLONIAyDELEGACION']) ? $row['COLONIAyDELEGACION'] : ''; ?>">
                    <input type="hidden" id="direccion_establecimiento_completa<?php echo $id; ?>" value="<?php echo isset($row['direccion_establecimiento_completa']) ? $row['direccion_establecimiento_completa'] : ''; ?>">
                    
                    <tr class="registro-row">
                        <td data-label="Imagen" class="imagen-celda">
                            <?php 
                            if (!empty($foto) && file_exists("img/fotos/".$foto)) {
                                echo '<a href="img/fotos/'.$foto.'" data-lightbox="imagen-'.$id.'" data-title="'.$nombre_comercial.'">
                                    <img class="img-thumbnail-custom" src="img/fotos/'.$foto.'" alt="Imagen de '.$nombre_comercial.'">
                                </a>';
                            } else {
                                echo '<a href="#"><img class="img-thumbnail-custom" src="img/no_imagen.jpg" alt="No Existe Foto"></a>';
                            }
                            ?>
                            <span class="d-block text-muted mt-2 id-info"><small>ID: <?php echo $id; ?> | Folio: <?php echo $folio; ?></small></span>
                        </td>
                        <td data-label="Datos Establecimiento" class="datos-celda">
                            <div class="datos-establecimiento">
                                <span class="nombre-comercial"><?php echo ucwords($nombre_comercial); ?></span>
                                <span class="direccion"><?php echo $calle . ' ' . $numero; ?></span>
                                <?php if (!empty($entre_calles)): ?>
                                <span class="direccion"><?php echo $entre_calles; ?></span>
                                <?php endif; ?>
                                <?php if (!empty($numero_interno)): ?>
                                <span class="direccion">Int: <?php echo $numero_interno; ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td data-label="Solicitante" class="datos-celda">
                            <div class="datos-solicitante">
                                <span class="nombre-comercial"><?php echo ucwords($nombre_solicitante); ?></span>
                                <?php if (!empty($email)): ?>
                                <span class="contacto"><span class="etiqueta">Email:</span> <?php echo $email; ?></span>
                                <?php endif; ?>
                                <?php if (!empty($telefono)): ?>
                                <span class="contacto"><span class="etiqueta">Tel:</span> <?php echo $telefono; ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td data-label="Observación" class="observacion-celda">
                            <?php 
                            if (empty($observaciones)) {
                                echo '<span class="text-muted">sin observaciones</span>';
                            } else if (strlen($observaciones) > 150) {
                                echo '<div class="observacion-texto">' . substr($observaciones, 0, 150) . '...</div>';
                            } else {
                                echo '<div class="observacion-texto">' . $observaciones . '</div>'; 
                            }
                            ?>
                        </td>
                        <td data-label="Acciones" class="acciones-celda">
                            <div class="action-buttons">
                                <!-- Botón de editar -->
                                <a href="#" class="btn btn-sm btn-action btn-primary-custom" title="Editar registro" data-bs-toggle="modal" data-bs-target="#editarRegistro" onclick="obtener_datos('<?php echo $id; ?>','<?php echo $page; ?>');"><i class="bi bi-pencil"></i></a>
                                
                                <!-- Botón de coordenadas/mapa -->
                                <a href="#" class="btn btn-sm btn-action btn-info-custom" title="Coordenadas" data-bs-toggle="modal" data-bs-target="#coordenadasModal" onclick="mapa_valla('<?php echo $id; ?>')"><i class="bi bi-geo-alt"></i></a>
                                
                                <!-- Botón de cámara/foto -->
                                <a href="#" class="btn btn-sm btn-action btn-success-custom" title="Foto" data-bs-toggle="modal" data-bs-target="#fotoModal" data-id="<?php echo $id; ?>"><i class="bi bi-camera"></i></a>
                                
                                <!-- Estatus -->
                                <div class="estatus-badge estatus-inspeccion"><?php echo $estatus; ?></div>
                                
                                <?php if ($estatus == "PENDIENTE" || $estatus == "INSPECCION"): ?>
                                <!-- Botón de generar recibo -->
                                <a href="#" class="btn btn-sm btn-action btn-warning-custom btn-generar-recibo mt-2" title="Generar Recibo Inspección" onclick="generar_recibo('<?php echo $id; ?>')">Generar Recibo Inspeccion</a>
                                <?php endif; ?>
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

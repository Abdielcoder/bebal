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
    $aColumns = array('folio'); // Columnas de búsqueda
    $sTable = "principal";
    
    // Construir cláusula WHERE según perfil de usuario
    if ($ID_MUNICIPIO == 0) {
        $sWhere = "";
    } else {


if ( $PROFILE=='inspector' ) $sWhere = "WHERE estatus='Pagos IRAD' AND  id_municipio=".$ID_MUNICIPIO;
    else
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
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? intval($_REQUEST['page']) : 1;

    $per_page = 3; // Registros por página (fijo en 3)
    $adjacents = 4; // Espacios entre páginas
    $offset = ($page - 1) * $per_page;

    //echo 'page='.$page.', per_page='.$per_page.', adjacents='.$adjacents.', offset='.$offset.', page='.$page.'<br>';


    // Contar registros totales
    $count_sql = "SELECT count(*) AS numrows FROM $sTable $sWhere";
    $count_query = mysqli_query($con, $count_sql);
    if (!$count_query) {
        die("Error en consulta de conteo: " . mysqli_error($con) . "<br>SQL: " . $count_sql);
    }
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows/$per_page);
    
    // Validar que la página solicitada esté dentro del rango válido
    if ($page < 1) $page = 1;
    if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
    
    // Recalcular el offset basado en la página validada
    $offset = ($page - 1) * $per_page;
    
    // Definir URL de recarga para la paginación (mantiene la búsqueda)
    $reload = './principal.php';
    if (!empty($q)) {
        $reload .= "?q=" . urlencode($q) . "&";
    } else {
        $reload .= "?";
    }
    
    // Consulta principal con LIMIT ajustado
    $main_sql = "SELECT * FROM $sTable $sWhere LIMIT $offset,$per_page";
    //echo $main_sql.'<br>';
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
                        <th width="10%"> </th>
                        <th width="20%"><font size="1">DATOS ESTABLECIMIENTO</font></th>
                        <th width="20%"><font size="1">SOLICITANTE</font></th>
                        <th width="10%"><font size="1">OBSERVACIÓN</font></th>
                        <th width="15%" style="border-right: none !important;"><font size="1">STATUS</font></th>
                        <th class="text-center" width="25%" style="border-left: none !important;"><font size="1">ACCIONES</font></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $ciclo = 1;
                while ($row = mysqli_fetch_array($query)) {
                    $id = $row['id'];
                    $nombre_comercial = $row['nombre_comercial_establecimiento'];
                    $nombre_comercial_establecimiento = $row['nombre_comercial_establecimiento'];
                    $calle = $row['calle_establecimiento'];
                    $entre_calles = $row['entre_calles_establecimiento'];
                    $numero = $row['numero_establecimiento'];
                    $numero_interno = $row['numerointerno_local_establecimiento'];
                    $estatus = $row['estatus'];
                    $operacion = $row['operacion'];
                    $id_giro = $row['giro'];
                    $modalidad_graduacion_alcoholica = $row['modalidad_graduacion_alcoholica'];
                    $folio = $row['folio'];
                    $observaciones = $row['observaciones'];
                    $fecha_autorizacion = $row['fecha_autorizacion'];
                    $fecha_expiracion = $row['fecha_expiracion'];
                    $nombre_solicitante = $row['nombre_persona_fisicamoral_solicitante'];
                    $email = $row['email_solicitante'];
		    $telefono = $row['telefono_solicitante'];
		    $id_tramite = $row['id_tramite'];
		    $id_proceso_tramites = $row['id_proceso_tramites'];

		    $latitud = $row['latitud'];
		    $longitud = $row['longitud'];

                    $foto = isset($row['foto']) ? $row['foto'] : "";

##
$sql_giro="SELECT * FROM giro WHERE id=".$id_giro;
$result_giro = mysqli_query($con,$sql_giro);
$row_giro = mysqli_fetch_assoc($result_giro);
$GIRO=$row_giro['descripcion_giro'];
$HORARIO_FUNCIONAMIENTO=$row_giro['horario_funcionamiento'];
##

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
                            if (!empty($foto) && is_numeric($foto)) {
                                // Definir un array con todas las posibles rutas para la imagen
                                $posibles_rutas = array(
                                    // 1. Rutas usando la constante FOTOSMEDIAS
                                    "../".FOTOSMEDIAS.$id."-".$foto.".jpg",
                                    FOTOSMEDIAS.$id."-".$foto.".jpg",
                                    // 2. Rutas explícitas relativas
                                    "bebal_images/medias/".$id."-".$foto.".jpg",
                                    "../bebal_images/medias/".$id."-".$foto.".jpg",
                                    // 3. Rutas con nombre de archivo alternativo
                                    "../".FOTOSMEDIAS.$id."_".$foto.".jpg",
                                    FOTOSMEDIAS.$id."_".$foto.".jpg",
                                    // 4. Ruta absoluta desde document root (si está disponible)
                                    (isset($_SERVER["DOCUMENT_ROOT"]) ? $_SERVER["DOCUMENT_ROOT"]."/bebal_images/medias/".$id."-".$foto.".jpg" : "")
                                );
                                
                                // Filtrar rutas vacías
                                $posibles_rutas = array_filter($posibles_rutas);
                                
                                // Variable para almacenar la ruta válida
                                $ruta_valida = "";
                                
                                // Comprobar cada ruta hasta encontrar una válida
                                foreach ($posibles_rutas as $ruta) {
                                    if (file_exists($ruta)) {
                                        $ruta_valida = $ruta;
                                        break;
                                    }
                                }
                                
                                // Si encontramos una ruta válida, mostrar la imagen
                                if (!empty($ruta_valida)) {
                                    // Limpiar la ruta para URL pública (eliminar /var/www/html/ si existe)
                                    $url_imagen = $ruta_valida;
                                    // Eliminar cualquier referencia a /var/www/html/ que pueda estar en la ruta
                                    $url_imagen = str_replace('/var/www/html/', '/', $url_imagen);
                                    // Si la ruta comienza con document_root, convertirla a URL relativa
                                    if (isset($_SERVER["DOCUMENT_ROOT"]) && strpos($url_imagen, $_SERVER["DOCUMENT_ROOT"]) === 0) {
                                        $url_imagen = substr($url_imagen, strlen($_SERVER["DOCUMENT_ROOT"]));
                                    }
                                    
                                    // Asegurarse de que la URL comience con / o sea relativa
                                    if (strpos($url_imagen, '/') === 0) {
                                        // Es una ruta absoluta desde la raíz del servidor
                                        // No necesita modificación adicional
                                    } else if (strpos($url_imagen, '../') === 0) {
                                        // Es una ruta relativa con ../
                                        // Convertir a ruta absoluta desde la raíz del sitio
                                        $url_imagen = str_replace('../', '/', $url_imagen);
                                    }
                                    
                                    echo '<a href="#" class="imagen-registro" data-id="'.$id.'" data-foto="'.$foto.'" data-nombre="'.$nombre_comercial.'" data-folio="'.$folio.'">
                                        <img class="img-thumbnail-custom" src="'.$url_imagen.'" alt="Imagen de '.$nombre_comercial.'">
                                    </a>';
                                } else {
                                    // Si no se encuentra ninguna ruta válida, intentar con URL pública directa
                                    //$url_base = "http://98.80.116.118/bebal_images/medias/";
                                    $url_base = "http://".IPADDRESS."/bebal_images/medias/";
                                    $url_imagen = $url_base.$id."-".$foto.".jpg";
                                    
                                    echo '<a href="#" class="imagen-registro" data-id="'.$id.'" data-foto="'.$foto.'" data-nombre="'.$nombre_comercial.'" data-folio="'.$folio.'">
                                        <img class="img-thumbnail-custom" src="'.$url_imagen.'" alt="Imagen de '.$nombre_comercial.'" onerror="this.src=\'img/no_imagen.jpg\'">
                                    </a>';
                                }
                            } else {
                                // Si no hay foto definida
                                echo '<a href="#" class="imagen-registro" data-id="'.$id.'" data-foto="" data-nombre="'.$nombre_comercial.'" data-folio="'.$folio.'">
                                    <img class="img-thumbnail-custom" src="img/no_imagen.jpg" alt="No Existe Foto">
                                </a>';
                            }
                            ?>
                            <span class="d-block text-muted mt-2 id-info"><small>Folio: <?php echo $folio; ?>, <b><?php echo $operacion; ?><br>Giro: <?php echo $GIRO; ?></b></small></span>
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

if ( $operacion=='Activo' ) {

echo '<font size="1" color="black">Permiso:</font> <font size="1" color="blue">'.$fecha_autorizacion.'</font><br>';
echo '<font size="1" color="black">Autorización:</font> <font size="1" color="blue">'.$fecha_autorizacion.'</font><br>';
echo '<font size="1" color="black">Expiracón:</font> <font size="1" color="blue">'.$fecha_expiracion.'</font><br>';


} else {

	if ( $operacion=='Tramite' ) {
	$sql_tramite10="SELECT * FROM tramite WHERE id=".$id_tramite;
	$result_tramite10 = mysqli_query($con,$sql_tramite10);
	$row_tramite10 = mysqli_fetch_assoc($result_tramite10);
	$TRAMITE_tramite_SOLICITADO=$row_tramite10['descripcion_tramite'];

echo '<font size="1" color="black">Tramite:</font> <font size="1" color="blue">'.$TRAMITE_tramite_SOLICITADO.'</font><br>';


	} else {

                            if (empty($observaciones)) {
                                echo '<span class="text-muted">sin observaciones</span>';
                            } else if (strlen($observaciones) > 150) {
                                echo '<div class="observacion-texto"><font size="1">' . substr($observaciones, 0, 150) . '...</font></div>';
                            } else {
                                echo '<div class="observacion-texto"><font size="1">'. $observaciones . '</font></div>'; 
			    }
	}

}

                            ?>
                        </td>
                        <!-- NUEVA COLUMNA DE STATUS -->
                        <td data-label="Status" class="status-celda" style="border-right: none; padding-right: 0;">
                            <?php
                            // Mostrar el estado correspondiente
                            if ($estatus == "PENDIENTE" || $estatus == "INSPECCION") {
                                echo '<div class="estatus-badge" style="background-color:#AC905B !important; color:white !important;"><font size="1" style="color:white !important;">Generar Recibos IRAD</font></div>';
                            } else if ($estatus == "Presupuesto") {
                                echo '<div class="estatus-badge" style="background-color:#AC905B !important; color:white !important;"><font size="1" style="color:white !important;">Presupuesto</font></div>';
                            } else if ($estatus == "Permiso Autorizado") {
                                echo '<div class="estatus-badge" style="background-color:#AC905B !important; color:white !important;"><font size="1" style="color:white !important;">Permiso Autorizado</font></div>';
                            } else {
                                echo '<div class="estatus-badge" style="background-color:#AC905B !important; color:white !important;"><font size="1" style="color:white !important;">' . $estatus . '</font></div>';
                            }
                            ?>
                        </td>
                        <td data-label="Acciones" class="acciones-celda" style="border-left: none; padding-left: 0; text-align: center;">
                            <div class="action-buttons">
                                <!-- PRIMERO: Todos los botones normales -->
                                <div class="action-row-buttons">
                                <?php
                                    // Botón de acción para Activo (cambios)
                                    if ($operacion=='Activo') {
                                        echo '<a href="#" class="btn btn-xs btn-action btn-success" title="Tramite Cambios Folio '.$folio.', '.$nombre_comercial_establecimiento.'" onclick="obtener_datosParaCambio('.$id.','.$page.');" data-bs-toggle="modal" data-bs-target="#elegirTramite"><i class="bi bi-arrows-fullscreen"></i></a>';
                                    }

                                    // Botón de acción para Trámite
                                    if ($operacion=='Tramite') {
                                        echo '<a href="detalleRegistroTramite.php?id='.$id.'--'.$page.'--'.$id_tramite.'" class="btn btn-xs btn-action btn-success" title="Activo - Tramites Cambios Folio '.$folio.', '.$nombre_comercial_establecimiento.'"><i class="bi bi-arrows-fullscreen"></i></a>';
                                    }

                                    // Botón de editar
                                    if ($operacion=='NUEVO') {
                                        if ($PROFILE=='inspector') {
                                            if ($estatus=='Pagos IRAD' || $estatus=='Inspeccion Realizada' || $estatus=='RAD Realizado') {
                                                echo '<a href="principalFotos.php?id='.$id.'&page='.$page.'" class="btn btn-danger btn-xs" title="Registrar Inspección"><i class="bi bi-clipboard-check"></i><font size="1">Inspección</font></a>';
                                            }
                                        } else {
                                            echo '<a href="detalleRegistro.php?id='.$id.'--'.$page.'--'.$id_tramite.'" class="btn btn-xs btn-action btn-dark" title="Proceso Registro Nuevo Folio '.$folio.', '.$nombre_comercial_establecimiento.'"><font color="red"><i class="bi bi-gear"></i></font></a>';
                                        }
                                    }
                                    
                                    // Botón de coordenadas/mapa
                                    if ($latitud!='' && $longitud!='') {
                                        echo '<a href="#" class="btn btn-sm btn-action btn-primary-custom" title="Coordenadas Latitud y Longitud" data-bs-toggle="modal" data-bs-target="#MapaModal'.$id.'")"><i class="bi bi-geo-alt"></i></a>';
                                    }

                                    // Botón Ver PDFs
                                    $cuentaPT=0;
                                    $KueryPT="SELECT COUNT(*) AS cuentaPT FROM proceso_tramites WHERE en_proceso='Fin' AND id=$id_proceso_tramites";
                                    $arregloPT = mysqli_fetch_array(mysqli_query($con,$KueryPT));
                                    $cuentaPT=$arregloPT['cuentaPT'];
                                    if ($cuentaPT>0) {
                                        echo '<a href="#" class="btn btn-sm btn-action btn-primary-custom" title="Ver PDFs" data-bs-toggle="modal" data-bs-target="#ModalPDF'.$id.'")"><i class="bi bi-file-pdf"></i></a>';

                                        $KueryPTfiles="SELECT * FROM proceso_tramites WHERE id=$id_proceso_tramites AND en_proceso='Fin'";
                                        $arregloPTfiles = mysqli_fetch_array(mysqli_query($con,$KueryPTfiles));

                                        $docs_pdf1DB=$arregloPTfiles['docs_pdf1'];
                                        $estatus_docs_pdf1DB=$arregloPTfiles['estatus_docs_pdf1'];
                                        $docs_pdf2DB=$arregloPTfiles['docs_pdf2'];
                                        $estatus_docs_pdf2DB=$arregloPTfiles['estatus_docs_pdf2'];
                                        $docs_pdf3DB=$arregloPTfiles['docs_pdf3'];
                                        $estatus_docs_pdf3DB=$arregloPTfiles['estatus_docs_pdf3'];
                                        $docs_pdf4DB=$arregloPTfiles['docs_pdf4'];
                                        $estatus_docs_pdf4DB=$arregloPTfiles['estatus_docs_pdf4'];
                                    }
                                ?>
                                </div>
                                
                                <!-- SEGUNDO: Botones amarillos (restaurar el comportamiento original) -->
                                <?php
                                // Determinar si hay que mostrar algún botón amarillo
                                $mostrarBotonAmarillo = false;
                                $botonAmarilloHTML = '';
                                
                                // Botón de "Generar Recibos IRAD"
                                if ($estatus == "PENDIENTE" || $estatus == "INSPECCION") {
                                    $mostrarBotonAmarillo = true;
                                    $botonAmarilloHTML .= '<a href="#" class="amarillo-bottom" style="background-color:#ffc107 !important; color:white !important;" title="Generar Recibo Inspección" onclick="generar_recibo(\''.$id.'\')">Generar Recibos IRAD</a>';
                                }
                                
                                // Botón de "Presupuesto"
                                if ($estatus == "Presupuesto") {
                                    $mostrarBotonAmarillo = true;
                                    $botonAmarilloHTML .= '<button type="button" class="btn btn-sm btn-action" style="background-color:#5e2328 !important; color:white !important;" title="Presupuesto" onclick="presupuesto(\''.$id.'\')"><i class="bi bi-receipt"></i></button>';
                                }
                                
                                // Si hay algún botón amarillo para mostrar, añadir el contenedor
                                if ($mostrarBotonAmarillo) {
                                    echo '<div class="yellow-button-container">'.$botonAmarilloHTML.'</div>';
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php
		$ciclo++;

                                if ( $latitud!='' && $longitud!='' ) {
                                ##echo '<a href="#" class="btn btn-sm btn-action btn-primary-custom" title="Coordenadas Latitud y Longitud" data-bs-toggle="modal" data-bs-target="#MapaModal'.$id.'")"><i class="bi bi-geo-alt"></i></a>';

                                echo '<div class="modal" id="MapaModal'.$id.'" >';
                                echo '<div class="modal-dialog">';
                                echo '<div class="modal-content">';

                                echo '<div class="modal-header"  style="background-color:#AC905B;color:white">';
                                echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-map"></i>   Ubicación Geográfica del Establecimiento</h6>';
                                echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                                echo '</button>';
                                echo '</div>';
                                echo '<div class="modal-body">';
                                echo '<iframe src="map.php?dbLon='.$longitud.'&dbLat='.$latitud.'&nombre_comercial_establecimiento='.$nombre_comercial_establecimiento.'" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>';

echo '<div class="modal-footer">';
echo '<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>';
echo '</div>';

                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

				}

				if ( $cuentaPT>0 ) {
                // Contar cuántos PDFs están realmente disponibles
                $pdfCount = 0;
                if (!empty($docs_pdf1DB)) $pdfCount++;
                if (!empty($docs_pdf2DB)) $pdfCount++;
                if (!empty($docs_pdf3DB)) $pdfCount++;
                if (!empty($docs_pdf4DB)) $pdfCount++;
                
				echo '<div class="modal" id="ModalPDF'.$id.'" tabindex="-1" role="dialog">';
				echo '<div class="modal-dialog modal-lg" role="document">';
				echo '<div class="modal-content">';

				echo '<div class="modal-header" style="background-color:#AC905B;color:white">';
				echo '<h6 class="modal-title" id="myModalLabel"><i class="bi bi-file-earmark-pdf"></i> Documentos PDF (' . $pdfCount . ')</h6>';
				echo '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">';
				echo '<span aria-hidden="true">&times;</span>';
				echo '</button>';
				echo '</div>';
				echo '<div class="modal-body">';
                
                // Si no hay PDFs, mostrar un mensaje
                if ($pdfCount == 0) {
                    echo '<div class="alert alert-warning text-center">No hay documentos PDF disponibles para este registro.</div>';
                } else {
                    echo '<div class="row">';
                    
                    // Columna izquierda - Lista de PDFs
                    echo '<div class="col-md-4" style="border-right: 1px solid #eee;">
                          <h6 class="mb-3">Documentos disponibles: <span class="badge" style="background-color:#742c32 !important;">' . $pdfCount . '</span></h6>
                          <div class="list-group">';
                    
                    // Establecer el PDF activo por defecto - el primero disponible
                    $defaultPdfPath = '';
                    $defaultPdfName = '';
                    $defaultPdfFound = false;
                    
                    // Verificar y mostrar cada PDF disponible
                    if (!empty($docs_pdf1DB)) {
                        $isActive = !$defaultPdfFound ? 'active' : '';
                        if (!$defaultPdfFound) {
                            $defaultPdfPath = '../bebal_docs/'.$docs_pdf1DB;
                            $defaultPdfName = 'Documento 1';
                            $defaultPdfFound = true;
                        }
                        
                        echo '<a href="#" class="list-group-item list-group-item-action pdf-selector ' . $isActive . '" 
                             data-pdf="../bebal_docs/'.$docs_pdf1DB.'" data-name="Documento 1">
                             <i class="bi bi-file-earmark-pdf"></i> Documento 1
                             '.(!empty($estatus_docs_pdf1DB) ? '<span class="badge float-end" style="background-color:#742c32 !important;">'.$estatus_docs_pdf1DB.'</span>' : '').'
                             </a>';
                    }
                    
                    if (!empty($docs_pdf2DB)) {
                        $isActive = !$defaultPdfFound ? 'active' : '';
                        if (!$defaultPdfFound) {
                            $defaultPdfPath = '../bebal_docs/'.$docs_pdf2DB;
                            $defaultPdfName = 'Documento 2';
                            $defaultPdfFound = true;
                        }
                        
                        echo '<a href="#" class="list-group-item list-group-item-action pdf-selector ' . $isActive . '" 
                             data-pdf="../bebal_docs/'.$docs_pdf2DB.'" data-name="Documento 2">
                             <i class="bi bi-file-earmark-pdf"></i> Documento 2
                             '.(!empty($estatus_docs_pdf2DB) ? '<span class="badge float-end" style="background-color:#742c32 !important;">'.$estatus_docs_pdf2DB.'</span>' : '').'
                             </a>';
                    }
                    
                    if (!empty($docs_pdf3DB)) {
                        $isActive = !$defaultPdfFound ? 'active' : '';
                        if (!$defaultPdfFound) {
                            $defaultPdfPath = '../bebal_docs/'.$docs_pdf3DB;
                            $defaultPdfName = 'Documento 3';
                            $defaultPdfFound = true;
                        }
                        
                        echo '<a href="#" class="list-group-item list-group-item-action pdf-selector ' . $isActive . '" 
                             data-pdf="../bebal_docs/'.$docs_pdf3DB.'" data-name="Documento 3">
                             <i class="bi bi-file-earmark-pdf"></i> Documento 3
                             '.(!empty($estatus_docs_pdf3DB) ? '<span class="badge float-end" style="background-color:#742c32 !important;">'.$estatus_docs_pdf3DB.'</span>' : '').'
                             </a>';
                    }
                    
                    if (!empty($docs_pdf4DB)) {
                        $isActive = !$defaultPdfFound ? 'active' : '';
                        if (!$defaultPdfFound) {
                            $defaultPdfPath = '../bebal_docs/'.$docs_pdf4DB;
                            $defaultPdfName = 'Documento 4';
                            $defaultPdfFound = true;
                        }
                        
                        echo '<a href="#" class="list-group-item list-group-item-action pdf-selector ' . $isActive . '" 
                             data-pdf="../bebal_docs/'.$docs_pdf4DB.'" data-name="Documento 4">
                             <i class="bi bi-file-earmark-pdf"></i> Documento 4
                             '.(!empty($estatus_docs_pdf4DB) ? '<span class="badge float-end" style="background-color:#742c32 !important;">'.$estatus_docs_pdf4DB.'</span>' : '').'
                             </a>';
                    }
                    
                    echo '</div></div>';
                    
                    // Columna derecha - Vista previa del PDF
                    echo '<div class="col-md-8">
                          <h6 class="mb-3 pdf-title">Vista previa: <span>'.$defaultPdfName.'</span></h6>
                          <div id="pdfViewer'.$id.'" class="pdf-container">
                            <object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="'.$defaultPdfPath.'"></object>
                          </div>
                          </div>';
                    
                    echo '</div>'; // Cierre del row
                }
                
                // Script para manejar la selección de PDFs
                echo '<script>
                    // Función para inicializar los listeners de PDF
                    function initPdfSelectors'.$id.'() {
                        // Obtener todos los selectores de PDF en este modal específico
                        const pdfSelectors = document.querySelectorAll("#ModalPDF'.$id.' .pdf-selector");
                        
                        // Añadir el evento click a cada selector
                        pdfSelectors.forEach(function(selector) {
                            selector.addEventListener("click", function(e) {
                                e.preventDefault();
                                
                                // Eliminar la clase active de todos los items
                                pdfSelectors.forEach(function(s) {
                                    s.classList.remove("active");
                                });
                                
                                // Agregar la clase active al item seleccionado
                                this.classList.add("active");
                                
                                // Obtener la ruta del PDF y el nombre
                                const pdfPath = this.getAttribute("data-pdf");
                                const pdfName = this.getAttribute("data-name");
                                
                                // Actualizar el título
                                document.querySelector("#ModalPDF'.$id.' .pdf-title span").textContent = pdfName;
                                
                                // Actualizar el contenedor del PDF - usar innerHTML para mayor compatibilidad
                                const pdfContainer = \'<object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="\' + pdfPath + \'"></object>\';
                                document.querySelector("#ModalPDF'.$id.' #pdfViewer'.$id.'").innerHTML = pdfContainer;
                                
                                console.log("Documento cambiado a: " + pdfName + ", ruta: " + pdfPath);
                            });
                        });
                    }
                    
                    // Ejecutar cuando el DOM esté listo
                    document.addEventListener("DOMContentLoaded", function() {
                        // Obtener referencia al modal
                        const modal = document.getElementById("ModalPDF'.$id.'");
                        
                        // Asegurarse de que el modal existe
                        if (modal) {
                            // Inicializar cuando el modal se muestre
                            modal.addEventListener("shown.bs.modal", function() {
                                console.log("Modal '.$id.' mostrado, inicializando selectores PDF");
                                initPdfSelectors'.$id.'();
                            });
                        }
                    });
                    
                    // También inicializar inmediatamente por si el modal ya está abierto
                    if (document.readyState === "complete" || document.readyState === "interactive") {
                        setTimeout(initPdfSelectors'.$id.', 1);
                    }
                </script>';
                
				echo '</div>'; // Cierre de modal-body
                
                echo '<div class="modal-footer">
                     <button type="button" class="btn" style="background-color:#742c32 !important; color:white !important;" data-bs-dismiss="modal">Cerrar</button>
                     </div>';
                     
				echo '</div>';
				echo '</div>';
				echo '</div>';
				}


		}  //* while
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

<style>
.action-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: center;
    border: none !important;
}

/* Eliminar cualquier línea separadora entre grupos */
.action-buttons > div {
    border: none !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Eliminar líneas y separaciones entre filas */
tr {
    border: none !important;
}

/* Eliminar las líneas horizontales */
td {
    border: none !important;
}

/* Eliminar separadores horizontales insertados dinámicamente */
hr, .separator, .divider {
    display: none !important;
}
</style>

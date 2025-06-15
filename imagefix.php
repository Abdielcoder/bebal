<?php
// Script para corregir problemas con imágenes
require_once ("config/db.php"); // Incluye las constantes de directorios

// Habilitar visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Corrección de Imágenes</title>
<style>
body { font-family: 'ITC Avant Garde Std', Arial, Helvetica, sans-serif; margin: 20px; -webkit-font-smoothing: antialiased; }
.success { color: green; }
.error { color: red; }
.warning { color: orange; }
</style>
</head><body>";

echo "<h1>Corrección de Imágenes para el Sistema</h1>";

// Crear directorios necesarios
$directorios = array(
    'bebal_images/',
    'bebal_images/originales/',
    'bebal_images/medias/',
    'bebal_images/thumbs/',
    '../bebal_images/',
    '../bebal_images/originales/',
    '../bebal_images/medias/',
    '../bebal_images/thumbs/'
);

echo "<h2>Creando directorios necesarios:</h2>";

foreach ($directorios as $dir) {
    echo "<p>Verificando directorio: <strong>$dir</strong> ... ";
    
    if (!file_exists($dir)) {
        if (@mkdir($dir, 0777, true)) {
            echo "<span class='success'>CREADO</span></p>";
        } else {
            echo "<span class='error'>ERROR AL CREAR</span></p>";
        }
    } else {
        echo "<span class='warning'>YA EXISTE</span></p>";
        
        // Ajustar permisos
        @chmod($dir, 0777);
    }
}

// Editar archivo de búsqueda para corregir rutas de imágenes
$archivo_busqueda = "ajax/buscar_principal_nuevo.php";
echo "<h2>Actualizando lógica de visualización de imágenes:</h2>";

if (file_exists($archivo_busqueda)) {
    $contenido = file_get_contents($archivo_busqueda);
    
    // Buscar la sección del código que maneja imágenes
    $patron_imagen = '/<td data-label="Imagen" class="imagen-celda">.*?<\/td>/s';
    if (preg_match($patron_imagen, $contenido)) {
        // Reemplazar con código mejorado
        $nuevo_codigo = '<td data-label="Imagen" class="imagen-celda">
                            <?php 
                            if (!empty($foto) && is_numeric($foto)) {
                                // Definir posibles rutas para la imagen
                                $rutaFoto1 = "../".FOTOSMEDIAS.$id."-".$foto.".jpg";    // Ruta carpeta superior
                                $rutaFoto2 = FOTOSMEDIAS.$id."-".$foto.".jpg";          // Ruta directa
                                $rutaFoto3 = "bebal_images/medias/".$id."-".$foto.".jpg"; // Ruta explícita
                                $rutaFoto4 = $_SERVER["DOCUMENT_ROOT"]."/bebal_images/medias/".$id."-".$foto.".jpg"; // Ruta absoluta
                                
                                // Verificar cada ruta
                                if (file_exists($rutaFoto1)) {
                                    $rutaImagen = $rutaFoto1;
                                } elseif (file_exists($rutaFoto2)) {
                                    $rutaImagen = $rutaFoto2;
                                } elseif (file_exists($rutaFoto3)) {
                                    $rutaImagen = $rutaFoto3;
                                } elseif (file_exists($rutaFoto4)) {
                                    $rutaImagen = $rutaFoto4;
                                } else {
                                    // Si no existe en ninguna ruta, intentar con la ruta de nivel superior (más común)
                                    $rutaImagen = "../".FOTOSMEDIAS.$id."-".$foto.".jpg";
                                }
                                
                                echo "<a href=\"".$rutaImagen."\" data-lightbox=\"imagen-".$id."\" data-title=\"".$nombre_comercial."\">
                                    <img class=\"img-thumbnail-custom\" src=\"".$rutaImagen."\" alt=\"Imagen de ".$nombre_comercial."\" onerror=\"this.src=\'img/no_imagen.jpg\'\">
                                </a>";
                            } else {
                                echo "<a href=\"#\"><img class=\"img-thumbnail-custom\" src=\"img/no_imagen.jpg\" alt=\"No Existe Foto\"></a>";
                            }
                            ?>
                            <span class="d-block text-muted mt-2 id-info"><small>ID: <?php echo $id; ?> | Folio: <?php echo $folio; ?></small></span>
                        </td>';
        
        $contenido_actualizado = preg_replace($patron_imagen, $nuevo_codigo, $contenido);
        
        if ($contenido_actualizado !== $contenido) {
            if (file_put_contents($archivo_busqueda, $contenido_actualizado)) {
                echo "<p class='success'>✓ Se actualizó correctamente el archivo de búsqueda para mejorar la visualización de imágenes.</p>";
            } else {
                echo "<p class='error'>✗ No se pudo escribir en el archivo de búsqueda. Verifica los permisos.</p>";
            }
        } else {
            echo "<p class='warning'>⚠ No fue necesario actualizar el archivo de búsqueda.</p>";
        }
    } else {
        echo "<p class='error'>✗ No se encontró la sección de código para imágenes en el archivo de búsqueda.</p>";
    }
} else {
    echo "<p class='error'>✗ No se encontró el archivo de búsqueda principal.</p>";
}

// Realizar prueba de carga de imágenes
echo "<h2>Verificando existencia de imágenes en la base de datos:</h2>";

// Conectar a la base de datos
require_once("config/conexion.php");
if ($con) {
    echo "<p class='success'>✓ Conexión a la base de datos exitosa.</p>";
    
    // Buscar registros con fotos
    $query = mysqli_query($con, "SELECT id, foto FROM principal WHERE foto IS NOT NULL AND foto != '' LIMIT 5");
    
    if ($query && mysqli_num_rows($query) > 0) {
        echo "<p>Se encontraron registros con referencias a fotos. Comprobando accesibilidad:</p>";
        
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>
                <tr>
                    <th>ID</th>
                    <th>Nombre Foto</th>
                    <th>Ruta Calculada</th>
                    <th>¿Existe?</th>
                    <th>Vista Previa</th>
                </tr>";
        
        while ($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $foto = $row['foto'];
            
            // Verificar las rutas posibles
            $rutaFoto1 = "../".FOTOSMEDIAS.$id."-".$foto.".jpg";
            $rutaFoto2 = FOTOSMEDIAS.$id."-".$foto.".jpg";
            $rutaFoto3 = "bebal_images/medias/".$id."-".$foto.".jpg";
            
            if (file_exists($rutaFoto1)) {
                $rutaFinal = $rutaFoto1;
                $existe = "Sí (../FOTOSMEDIAS)";
            } elseif (file_exists($rutaFoto2)) {
                $rutaFinal = $rutaFoto2;
                $existe = "Sí (FOTOSMEDIAS)";
            } elseif (file_exists($rutaFoto3)) {
                $rutaFinal = $rutaFoto3;
                $existe = "Sí (ruta explícita)";
            } else {
                $rutaFinal = "../".FOTOSMEDIAS.$id."-".$foto.".jpg";
                $existe = "No";
            }
            
            echo "<tr>
                    <td>$id</td>
                    <td>$foto</td>
                    <td>$rutaFinal</td>
                    <td>$existe</td>
                    <td>";
            
            if ($existe != "No") {
                echo "<img src='$rutaFinal' style='max-width:100px;'>";
            } else {
                echo "<img src='img/no_imagen.jpg' style='max-width:100px;'>";
            }
            
            echo "</td></tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠ No se encontraron registros con fotos en la base de datos.</p>";
    }
} else {
    echo "<p class='error'>✗ Error de conexión a la base de datos: " . mysqli_connect_error() . "</p>";
}

echo "<hr>";
echo "<h2>Recomendaciones finales</h2>";
echo "<ol>
        <li>Verifica que las imágenes estén correctamente almacenadas en alguna de las rutas indicadas arriba.</li>
        <li>Si las imágenes no se encuentran, súbelas a las carpetas correspondientes.</li>
        <li>Asegúrate de que los nombres de archivo sigan el formato: ID-NUMEROFOTO.jpg</li>
        <li>Verifica que los permisos de las carpetas sean 0777 para permitir escritura.</li>
      </ol>";

echo "<p><a href='check_images.php'>Ejecutar diagnóstico completo</a> | <a href='principal.php'>Volver al sistema</a></p>";
echo "</body></html>";
?> 
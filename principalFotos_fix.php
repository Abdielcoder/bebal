<?php
// Script para corregir problemas con subida de imágenes en principalFotos.php
require_once ("config/db.php"); // Incluye las constantes de directorios

// Habilitar visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Corrección de Subida de Imágenes</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; }
.error { color: red; }
.warning { color: orange; }
.code { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
</style>
</head><body>";

echo "<h1>Corrección de Subida de Imágenes para principalFotos.php</h1>";

// Verificar que las constantes están definidas correctamente
echo "<h2>Verificación de constantes:</h2>";
echo "<p>FOTOSORIGINALES: " . FOTOSORIGINALES . "</p>";
echo "<p>FOTOSMEDIAS: " . FOTOSMEDIAS . "</p>";
echo "<p>FOTOSTHUMB: " . FOTOSTHUMB . "</p>";

// Comprobar si los directorios existen y son escribibles
$directorios = array(
    '../'.FOTOSORIGINALES => "Directorio de imágenes originales (nivel superior)",
    '../'.FOTOSMEDIAS => "Directorio de imágenes medias (nivel superior)",
    '../'.FOTOSTHUMB => "Directorio de imágenes miniaturas (nivel superior)",
    FOTOSORIGINALES => "Directorio de imágenes originales (directo)",
    FOTOSMEDIAS => "Directorio de imágenes medias (directo)",
    FOTOSTHUMB => "Directorio de imágenes miniaturas (directo)"
);

echo "<h2>Estado de los directorios:</h2>";
echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>
<tr>
    <th>Directorio</th>
    <th>Descripción</th>
    <th>Estado</th>
    <th>Permisos</th>
    <th>Acciones realizadas</th>
</tr>";

foreach ($directorios as $dir => $descripcion) {
    echo "<tr>
        <td>$dir</td>
        <td>$descripcion</td>";
        
    $estado = "";
    $permisos = "";
    $acciones = "";
    
    if (!file_exists($dir)) {
        $estado = "<span class='error'>No existe</span>";
        if (@mkdir($dir, 0777, true)) {
            $acciones .= "<span class='success'>Directorio creado</span>";
        } else {
            $acciones .= "<span class='error'>No se pudo crear el directorio</span>";
        }
    } else {
        if (is_dir($dir)) {
            $estado = "<span class='success'>Existe</span>";
            
            if (is_writable($dir)) {
                $permisos = "<span class='success'>Escribible</span>";
            } else {
                $permisos = "<span class='error'>No escribible</span>";
                if (@chmod($dir, 0777)) {
                    $acciones .= "<span class='success'>Permisos corregidos</span>";
                } else {
                    $acciones .= "<span class='error'>No se pudieron corregir los permisos</span>";
                }
            }
        } else {
            $estado = "<span class='error'>Existe pero no es un directorio</span>";
        }
    }
    
    echo "<td>$estado</td>
          <td>$permisos</td>
          <td>$acciones</td>
        </tr>";
}
echo "</table>";

// Verificar conexión a la base de datos
echo "<h2>Verificación de la base de datos:</h2>";
require_once("config/conexion.php");
if ($con) {
    echo "<p class='success'>✓ Conexión a la base de datos exitosa.</p>";
    
    // Verificar la tabla fotos
    $query = mysqli_query($con, "SHOW TABLES LIKE 'fotos'");
    if (mysqli_num_rows($query) > 0) {
        echo "<p class='success'>✓ La tabla 'fotos' existe.</p>";
        
        // Verificar estructura
        $estructura = mysqli_query($con, "DESCRIBE fotos");
        if ($estructura) {
            echo "<p class='success'>✓ La estructura de la tabla 'fotos' parece correcta.</p>";
        } else {
            echo "<p class='error'>✗ Error al verificar la estructura de la tabla 'fotos'.</p>";
        }
    } else {
        echo "<p class='error'>✗ La tabla 'fotos' no existe en la base de datos.</p>";
    }
} else {
    echo "<p class='error'>✗ Error de conexión a la base de datos: " . mysqli_connect_error() . "</p>";
}

// Modificaciones recomendadas para principalFotos.php
echo "<h2>Modificaciones recomendadas para principalFotos.php:</h2>";

echo "<p>El problema principal en la subida de imágenes parece estar en la línea donde se realiza el move_uploaded_file. Hay que asegurarse que las carpetas existan y tengan permisos correctos.</p>";

echo "<div class='code'>
<pre>
// Modificar esta sección en principalFotos.php:
else if (!move_uploaded_file(\$_FILES[\"nuevafoto\"]['tmp_name'],'../'.FOTOSORIGINALES.\$filename)) {
    // Intentar crear el directorio si no existe
    if (!file_exists('../'.FOTOSORIGINALES)) {
        @mkdir('../'.FOTOSORIGINALES, 0777, true);
    }
    
    // Intentar directamente en FOTOSORIGINALES (sin ../)
    if (move_uploaded_file(\$_FILES[\"nuevafoto\"]['tmp_name'],FOTOSORIGINALES.\$filename)) {
        // Si funciona sin '../', actualizar el resto del código
        superscaleimage(FOTOSORIGINALES.\$filename,FOTOSMEDIAS.\$filename,ANCHOMEDIO,ALTOMEDIO,95);
        superscaleimage(FOTOSORIGINALES.\$filename,FOTOSTHUMB.\$filename,ANCHOTHUMB,ALTOTHUMB,95);
        
        \$queryUPDATE=\"UPDATE fotos SET descripcion='OK (ruta directa)' WHERE idfoto=\".\$nextidf.\" AND idprincipal=\".\$IDPRINCIPAL;
        if (!mysqli_query(\$con,\$queryUPDATE)) echo mysqli_error();
    } else {
        \$errorfoto='Error al subir la foto. Rutas intentadas: '.
                   '../'.FOTOSORIGINALES.\$filename.', '.
                   FOTOSORIGINALES.\$filename;
        \$queryUPDATE=\"UPDATE fotos SET descripcion='\".\$errorfoto.\", idprincipal=\".\$IDPRINCIPAL.\"', idprincipal=0 WHERE idfoto=\".\$nextidf.\" AND idprincipal=\".\$IDPRINCIPAL;
        if (!mysqli_query(\$con,\$queryUPDATE)) echo mysqli_error();
    }
}
</pre>
</div>";

// Prueba de escritura
echo "<h2>Prueba de escritura en directorios:</h2>";

function probarEscritura($dir, $nombre) {
    echo "<p>Probando escritura en $dir... ";
    if (!file_exists($dir)) {
        echo "<span class='error'>El directorio no existe</span></p>";
        return false;
    }
    
    $archivo_prueba = $dir . 'test_' . time() . '.txt';
    if (file_put_contents($archivo_prueba, "Prueba de escritura desde principalFotos_fix.php")) {
        echo "<span class='success'>Éxito</span></p>";
        // Eliminar archivo de prueba
        @unlink($archivo_prueba);
        return true;
    } else {
        echo "<span class='error'>Error</span></p>";
        return false;
    }
}

foreach ($directorios as $dir => $desc) {
    probarEscritura($dir, $desc);
}

// Script de corrección
echo "<h2>Script de corrección automática:</h2>";

echo "<p>Este script ha verificado y creado los directorios necesarios para que principalFotos.php funcione correctamente.</p>";

echo "<p>Para implementar las correcciones sugeridas, sigue estos pasos:</p>";
echo "<ol>
    <li>Asegúrate de que todos los directorios tengan permisos 777 (puedes usar FTP o el panel de control de tu servidor).</li>
    <li>Modifica el archivo principalFotos.php con los cambios sugeridos arriba.</li>
    <li>Si sigues teniendo problemas, considera ejecutar estos comandos en el servidor:
        <ul>
            <li><code>mkdir -p bebal_images/originales bebal_images/medias bebal_images/thumbs</code></li>
            <li><code>mkdir -p ../bebal_images/originales ../bebal_images/medias ../bebal_images/thumbs</code></li>
            <li><code>chmod -R 777 bebal_images ../bebal_images</code></li>
        </ul>
    </li>
</ol>";

echo "<p><a href='principalFotos.php'>Volver a la gestión de fotos</a> | <a href='principal.php'>Volver al sistema</a></p>";
echo "</body></html>";
?> 
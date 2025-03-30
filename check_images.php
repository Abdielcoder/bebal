<?php
// Script para verificar el acceso a imágenes
require_once ("config/db.php"); // Incluye las constantes de directorios

// Habilitar visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Función para comprobar si una ruta de archivo está accesible
function checkFileAccess($path, $label) {
    echo "<p><strong>Verificando acceso a: $label</strong></p>";
    echo "<p>Ruta: $path</p>";
    
    if (file_exists($path)) {
        echo "<p style='color:green'>✓ El archivo existe.</p>";
        
        // Verificar si es legible
        if (is_readable($path)) {
            echo "<p style='color:green'>✓ El archivo es legible.</p>";
            
            // Verificar tamaño
            $size = filesize($path);
            echo "<p>Tamaño: $size bytes</p>";
            
            // Verificar tipo MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path);
            finfo_close($finfo);
            echo "<p>Tipo MIME: $mime</p>";
            
            // Mostrar enlace para ver el archivo
            echo "<p><a href='$path' target='_blank'>Ver archivo directamente</a></p>";
            
            // Mostrar imagen
            echo "<img src='$path' style='max-width:300px;border:1px solid #ccc;' alt='Imagen de prueba'>";
        } else {
            echo "<p style='color:red'>✗ El archivo existe pero NO es legible.</p>";
        }
    } else {
        echo "<p style='color:red'>✗ El archivo NO existe en esta ruta.</p>";
    }
    
    echo "<hr>";
}

// Cabecera
echo "<h1>Diagnóstico de acceso a imágenes</h1>";

// Información del sistema
echo "<h2>Información del sistema</h2>";
echo "<p>Directorio actual: " . getcwd() . "</p>";
echo "<p>Document Root del servidor: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";
echo "<p>Constante FOTOSMEDIAS: " . FOTOSMEDIAS . "</p>";

// Verificar conexión a la base de datos
require_once("config/conexion.php");
echo "<h2>Verificando conexión a la base de datos</h2>";
if ($con) {
    echo "<p style='color:green'>✓ Conexión a la base de datos exitosa.</p>";
    
    // Consultar algunos registros con fotos
    $query = mysqli_query($con, "SELECT id, foto FROM principal WHERE foto IS NOT NULL AND foto != '' LIMIT 5");
    
    if ($query && mysqli_num_rows($query) > 0) {
        echo "<h2>Comprobando imágenes de registros</h2>";
        
        while ($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $foto = $row['foto'];
            
            echo "<h3>Registro ID: $id, Foto: $foto</h3>";
            
            // Comprobar diferentes rutas posibles para la imagen
            checkFileAccess(FOTOSMEDIAS.$id."-".$foto.".jpg", "Usando constante FOTOSMEDIAS");
            checkFileAccess("bebal_images/medias/".$id."-".$foto.".jpg", "Ruta explícita relativa");
            checkFileAccess("../bebal_images/medias/".$id."-".$foto.".jpg", "Ruta nivel superior");
            checkFileAccess($_SERVER['DOCUMENT_ROOT']."/bebal_images/medias/".$id."-".$foto.".jpg", "Ruta absoluta desde Document Root");
        }
    } else {
        echo "<p style='color:orange'>⚠ No se encontraron registros con fotos en la base de datos.</p>";
    }
} else {
    echo "<p style='color:red'>✗ Error de conexión a la base de datos: " . mysqli_connect_error() . "</p>";
}

// Directorios
echo "<h2>Verificando directorios de imágenes</h2>";
$directories = array(
    "bebal_images/" => "Directorio raíz de imágenes (relativo)",
    "bebal_images/medias/" => "Directorio de imágenes medias (relativo)",
    "../bebal_images/medias/" => "Directorio de imágenes medias (nivel superior)",
    FOTOSMEDIAS => "Directorio de imágenes medias (constante)"
);

foreach ($directories as $dir => $label) {
    echo "<h3>$label</h3>";
    echo "<p>Ruta: $dir</p>";
    
    if (file_exists($dir)) {
        echo "<p style='color:green'>✓ El directorio existe.</p>";
        
        if (is_dir($dir)) {
            echo "<p style='color:green'>✓ Es un directorio válido.</p>";
            
            if (is_readable($dir)) {
                echo "<p style='color:green'>✓ El directorio es legible.</p>";
                
                if (is_writable($dir)) {
                    echo "<p style='color:green'>✓ El directorio tiene permisos de escritura.</p>";
                } else {
                    echo "<p style='color:red'>✗ El directorio NO tiene permisos de escritura.</p>";
                }
                
                // Listar algunos archivos
                echo "<p>Archivos en el directorio:</p>";
                $files = glob($dir . "*.jpg");
                if (count($files) > 0) {
                    echo "<ul>";
                    $count = 0;
                    foreach ($files as $file) {
                        echo "<li>$file</li>";
                        $count++;
                        if ($count >= 5) break; // Mostrar máximo 5 archivos
                    }
                    if (count($files) > 5) {
                        echo "<li>... y " . (count($files) - 5) . " más</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No se encontraron archivos .jpg en este directorio.</p>";
                }
            } else {
                echo "<p style='color:red'>✗ El directorio NO es legible.</p>";
            }
        } else {
            echo "<p style='color:red'>✗ La ruta existe pero NO es un directorio.</p>";
        }
    } else {
        echo "<p style='color:red'>✗ El directorio NO existe.</p>";
    }
    
    echo "<hr>";
}

echo "<p><a href='principal.php'>Volver al sistema</a></p>";
?> 
<?php
// Inicializador de directorios para imágenes
require_once ("config/db.php"); // Incluye las constantes de directorios

// Habilitar visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Inicialización de directorios de imágenes</h2>";

// Función para crear directorios si no existen
function checkCreateDir($path) {
    echo "<p>Verificando directorio: " . $path . "</p>";
    
    // Verificar si el directorio ya existe
    if (file_exists($path)) {
        echo "<p style='color:blue'>- El directorio ya existe.</p>";
        
        // Verificar permisos
        if (is_writable($path)) {
            echo "<p style='color:green'>- El directorio tiene permisos de escritura.</p>";
        } else {
            echo "<p style='color:red'>- El directorio NO tiene permisos de escritura. Intentando corregir...</p>";
            if (@chmod($path, 0777)) {
                echo "<p style='color:green'>- Permisos ajustados correctamente a 0777.</p>";
            } else {
                echo "<p style='color:red'>- No se pudieron ajustar los permisos. Por favor, ajuste los permisos manualmente.</p>";
            }
        }
        return true;
    }
    
    // Intentar crear el directorio
    if (@mkdir($path, 0777, true)) {
        echo "<p style='color:green'>- Directorio creado correctamente con permisos 0777.</p>";
        return true;
    } else {
        echo "<p style='color:red'>- Error al crear el directorio. Verificando path absoluto...</p>";
        
        // Intentar crear con path absoluto
        $absolute_path = realpath(dirname(__FILE__)) . '/' . $path;
        echo "<p>Intentando crear: " . $absolute_path . "</p>";
        
        if (@mkdir($absolute_path, 0777, true)) {
            echo "<p style='color:green'>- Directorio creado correctamente usando path absoluto.</p>";
            return true;
        } else {
            echo "<p style='color:red'>- No se pudo crear el directorio. Verifique permisos del servidor.</p>";
            
            // Información de diagnóstico
            echo "<h4>Información de diagnóstico:</h4>";
            echo "<p>Directorio actual: " . getcwd() . "</p>";
            echo "<p>Permisos del directorio actual: " . substr(sprintf('%o', fileperms(getcwd())), -4) . "</p>";
            echo "<p>Usuario del proceso: " . get_current_user() . "</p>";
            
            return false;
        }
    }
}

// Crear primer las rutas explícitas (más probable que funcionen)
$rutas_explicitas = array(
    'bebal_images/',
    'bebal_images/originales/',
    'bebal_images/medias/',
    'bebal_images/thumbs/',
    '../bebal_images/',
    '../bebal_images/originales/',
    '../bebal_images/medias/',
    '../bebal_images/thumbs/'
);

echo "<h3>Creando directorios con rutas explícitas:</h3>";
foreach ($rutas_explicitas as $dir) {
    checkCreateDir($dir);
}

// Crear directorios de imágenes en la raíz
$directorios = array(
    FOTOSORIGINALES,
    FOTOSMEDIAS,
    FOTOSTHUMB
);

// Crear directorios de imágenes en el directorio superior (usado por principalFotos.php)
$directoriosSuperior = array(
    '../'.FOTOSORIGINALES,
    '../'.FOTOSMEDIAS,
    '../'.FOTOSTHUMB
);

echo "<h3>Creando directorios usando constantes:</h3>";
foreach ($directorios as $dir) {
    checkCreateDir($dir);
}

echo "<h3>Creando directorios en nivel superior:</h3>";
foreach ($directoriosSuperior as $dir) {
    checkCreateDir($dir);
}

// Crear un archivo de prueba para verificar permisos
$test_file = FOTOSMEDIAS . 'test.txt';
if (file_put_contents($test_file, 'Prueba de escritura')) {
    echo "<p style='color:green'>Se pudo escribir un archivo de prueba correctamente en " . $test_file . "</p>";
    unlink($test_file); // Eliminar archivo de prueba
} else {
    echo "<p style='color:red'>No se pudo escribir el archivo de prueba. Revise los permisos.</p>";
}

echo "<h3>Comprobación completa.</h3>";
echo "<p>Ahora deberías poder subir imágenes y verlas en la tabla principal.</p>";
echo "<p>Para volver al sistema, <a href='principal.php'>haga clic aquí</a>.</p>";
?> 
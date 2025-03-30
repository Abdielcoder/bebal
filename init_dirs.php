<?php
// Inicializador de directorios para imágenes
require_once ("config/db.php"); // Incluye las constantes de directorios

// Función para crear directorios si no existen
function checkCreateDir($path) {
    if (!file_exists($path)) {
        if (mkdir($path, 0777, true)) {
            echo "Directorio creado: " . $path . "<br>";
            return true;
        } else {
            echo "Error al crear directorio: " . $path . "<br>";
            return false;
        }
    } else {
        echo "Directorio ya existe: " . $path . "<br>";
        return true;
    }
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

echo "<h2>Inicialización de directorios de imágenes</h2>";

echo "<h3>Creando directorios en la raíz:</h3>";
foreach ($directorios as $dir) {
    checkCreateDir($dir);
}

echo "<h3>Creando directorios en nivel superior:</h3>";
foreach ($directoriosSuperior as $dir) {
    checkCreateDir($dir);
}

echo "<h3>Comprobación completa.</h3>";
echo "<p>Para volver al sistema, <a href='principal.php'>haga clic aquí</a>.</p>";
?> 
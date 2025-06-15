<?php
// Script para corregir el problema de las URLs de imágenes que incluyen /var/www/html/
require_once ("config/db.php"); // Incluye las constantes de directorios

// Habilitar visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<html><head><title>Corrección de URLs de Imágenes</title>
<style>
body { font-family: 'ITC Avant Garde Std', Arial, Helvetica, sans-serif; margin: 20px; -webkit-font-smoothing: antialiased; }
.success { color: green; }
.error { color: red; }
.warning { color: orange; }
.box { border: 1px solid #ddd; padding: 15px; margin: 15px 0; border-radius: 5px; }
img.test { max-width: 300px; border: 1px solid #ccc; margin: 10px 0; }
</style>
</head><body>";

echo "<h1>Corrección de URLs de Imágenes</h1>";
echo "<p>Este script corrige el problema de las URLs de imágenes que incluyen <code>/var/www/html/</code> en la ruta.</p>";

// Información del sistema
echo "<div class='box'>";
echo "<h2>Información del Sistema</h2>";
echo "<p>Document Root: " . (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : 'No disponible') . "</p>";
echo "<p>Script Path: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";
echo "<p>FOTOSMEDIAS: " . FOTOSMEDIAS . "</p>";
echo "<p>Server IP/Domain: " . $_SERVER['SERVER_NAME'] . "</p>";
echo "</div>";

// Verificar si se ha ejecutado desde el servidor
require_once("config/conexion.php");
if ($con) {
    echo "<div class='box'>";
    echo "<h2>Test con Imágenes Reales</h2>";
    
    $query = mysqli_query($con, "SELECT id, foto FROM principal WHERE foto IS NOT NULL AND foto != '' LIMIT 5");
    
    if ($query && mysqli_num_rows($query) > 0) {
        echo "<p class='success'>✓ Se encontraron imágenes en la base de datos para probar.</p>";
        
        echo "<h3>Prueba de URLs de Imágenes</h3>";
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>
        <tr>
            <th>ID-Foto</th>
            <th>Ruta del Sistema</th>
            <th>URL Incorrecta</th>
            <th>URL Corregida</th>
            <th>Previsualización</th>
        </tr>";
        
        while ($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $foto = $row['foto'];
            
            // Construir posibles rutas
            $ruta_sistema = "../".FOTOSMEDIAS.$id."-".$foto.".jpg";
            
            // URL incorrecta (con /var/www/html/)
            $url_incorrecta = "/var/www/html/bebal_images/medias/".$id."-".$foto.".jpg";
            
            // URL corregida
            $url_corregida = "/bebal_images/medias/".$id."-".$foto.".jpg";
            
            // URL completa para previsualización
            $url_completa = "http://98.80.116.118/bebal_images/medias/".$id."-".$foto.".jpg";
            
            echo "<tr>
                <td>$id-$foto</td>
                <td>$ruta_sistema</td>
                <td>$url_incorrecta</td>
                <td>$url_corregida</td>
                <td>
                    <img src='$url_completa' class='test' alt='Imagen $id-$foto' onerror=\"this.src='img/no_imagen.jpg'; this.style.border='1px solid red';\">
                </td>
            </tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p class='warning'>⚠ No se encontraron imágenes en la base de datos para probar.</p>";
    }
    echo "</div>";
}

// Solución implementada
echo "<div class='box'>";
echo "<h2>Solución Implementada</h2>";
echo "<p>Se ha modificado el archivo <code>ajax/buscar_principal_nuevo.php</code> para corregir las URLs de las imágenes. La solución:</p>";
echo "<ol>
    <li>Elimina cualquier referencia a <code>/var/www/html/</code> de las rutas</li>
    <li>Convierte rutas absolutas del sistema a URLs relativas</li>
    <li>Usa URLs directas cuando no se encuentra una imagen en el servidor</li>
</ol>";

echo "<p>Si después de aplicar esta solución, aún tienes problemas, puedes establecer una URL base fija:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>
// Definir una URL base explícita (modificar según tu configuración)
\$url_base = 'http://98.80.116.118/bebal_images/medias/';
\$url_imagen = \$url_base.\$id.\"-\".\$foto.\".jpg\";

echo '&lt;a href=\"'.\$url_imagen.'\" data-lightbox=\"imagen-'.\$id.'\" data-title=\"'.\$nombre_comercial.'\">
    &lt;img class=\"img-thumbnail-custom\" src=\"'.\$url_imagen.'\" alt=\"Imagen de '.\$nombre_comercial.'\">
&lt;/a>';
</pre>";
echo "</div>";

// Guía para el servidor
echo "<div class='box'>";
echo "<h2>Acciones en el Servidor</h2>";
echo "<p>Si eres administrador del servidor, puedes realizar estas acciones adicionales:</p>";
echo "<ol>
    <li>Verifica el <code>document_root</code> configurado en Apache:
        <pre>grep -r 'DocumentRoot' /etc/apache2/</pre>
    </li>
    <li>Configura un alias en Apache para que las URLs funcionen correctamente:
        <pre>
Alias /bebal_images /var/www/html/bebal_images
&lt;Directory /var/www/html/bebal_images>
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
&lt;/Directory>
        </pre>
    </li>
    <li>Asegúrate de que los permisos de las carpetas sean correctos:
        <pre>chown -R www-data:www-data /var/www/html/bebal_images/</pre>
    </li>
</ol>";
echo "</div>";

echo "<p><a href='principal.php' class='btn'>Volver al sistema</a></p>";
echo "</body></html>";
?> 
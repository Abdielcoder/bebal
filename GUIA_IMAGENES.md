# Guía para resolver problemas de imágenes en BEBAL

## Problema
Las imágenes no se muestran correctamente en la tabla principal porque el sistema está buscando las imágenes en rutas incorrectas o las carpetas no existen.

## Solución implementada

Se han implementado las siguientes soluciones para resolver los problemas de visualización de imágenes:

1. **Scripts de diagnóstico y corrección**:
   - `check_images.php`: Analiza y diagnostica problemas con las imágenes.
   - `imagefix.php`: Crea los directorios necesarios y corrige la lógica de visualización.
   - `init_dirs.php`: Inicializa las carpetas necesarias para las imágenes.

2. **Mejoras en el código**:
   - Se ha mejorado `ajax/buscar_principal_nuevo.php` para buscar imágenes en múltiples ubicaciones posibles.
   - La lógica ahora verifica varias rutas antes de mostrar una imagen predeterminada.

## Estructura de directorios

Las imágenes deben estar en las siguientes ubicaciones:

```
bebal_images/
  ├── originales/  (Imágenes originales subidas)
  ├── medias/      (Imágenes redimensionadas para visualización estándar)
  └── thumbs/      (Miniaturas para visualización rápida)
```

También puede existir una estructura paralela en el directorio superior:

```
../bebal_images/
  ├── originales/
  ├── medias/
  └── thumbs/
```

## Instrucciones para corregir el problema

1. **Verificar las rutas de imágenes**:
   - Accede a `check_images.php` para diagnosticar el problema.
   - Este script mostrará si los directorios de imágenes existen y si tienen los permisos correctos.

2. **Crear directorios necesarios**:
   - Ejecuta `imagefix.php` para crear automáticamente los directorios necesarios.
   - Alternativamente, ejecuta `init_dirs.php` para inicializar los directorios.

3. **Verificar permisos**:
   - Asegúrate de que las carpetas de imágenes tengan permisos 0777 para permitir la escritura.
   - Puedes ejecutar: `chmod -R 777 bebal_images/` y `chmod -R 777 ../bebal_images/` en el servidor.

4. **Subir imágenes correctamente**:
   - Usa la funcionalidad "Gestionar Fotos" en la tabla principal.
   - Asegúrate de que las imágenes tengan un formato válido (JPG) y resolución mínima (640x480).

## Solución de problemas comunes

### Las imágenes no se muestran después de subirse
- Verifica que los directorios `bebal_images/medias/` y `../bebal_images/medias/` existan.
- Comprueba que el código esté buscando en las rutas correctas.
- Revisa si los permisos de las carpetas permiten la lectura desde el servidor web.

### Error al subir imágenes
- Verifica que los directorios `bebal_images/originales/` y `../bebal_images/originales/` existan.
- Asegúrate de que tengan permisos de escritura (0777).
- Comprueba los límites de tamaño de subida en la configuración de PHP.

### Imágenes truncadas o corruptas
- Verifica que la función de redimensionamiento funcione correctamente.
- Asegúrate de que la imagen original tenga el formato correcto.

## Ajustes del servidor

Si el problema persiste, es posible que necesites ajustar la configuración del servidor:

1. **Límites de PHP**:
   - Aumenta `upload_max_filesize` y `post_max_size` en php.ini.
   - Ajusta `memory_limit` para permitir el procesamiento de imágenes grandes.

2. **Rutas del servidor**:
   - Verifica la estructura de directorios en el servidor.
   - Asegúrate de que las rutas relativas funcionen correctamente.

## Soporte adicional

Si sigues teniendo problemas después de intentar estas soluciones:

1. Ejecuta `check_images.php` para obtener un diagnóstico detallado.
2. Revisa los logs de errores del servidor para identificar problemas específicos.
3. Contacta al administrador del sistema para obtener asistencia adicional. 
/**
 * Script para manejar el modal de imágenes en principal.php
 */

// Variables globales
let registroActual = null;
let todasLasImagenes = [];
let imagenActual = 0;

// Función para abrir el modal con las imágenes de un registro
function abrirModalImagenes(idRegistro, idFoto, nombreComercial, folio, id_proceso_tramites) {
    // Guardar referencia al registro actual
    registroActual = {
        id: idRegistro,
        idFoto: idFoto,
        nombreComercial: nombreComercial,
        folio: folio,
        id_proceso_tramites: id_proceso_tramites,
    };
    
    // Limpiar imágenes previas
    $('#imagenesSecundarias').empty();
    $('#imagenPrincipal').attr('src', 'img/loading.gif');
    
    // Actualizar título e información del modal
    $('#imagenesModalLabel').text('Imágenes: ' + nombreComercial);
    $('#infoRegistro').text('Registro: ' + folio + ' (ID: ' + idRegistro + ')');
    
    // Configurar enlace para administrar fotos
    $('#btnAdministrarFotos').attr('href', 'principalFotos.php?id=' + idRegistro + '&page=1');
    
    // Cargar imágenes del registro
    cargarImagenesRegistro(idRegistro, idFoto, id_proceso_tramites );
    
    // Mostrar el modal
    $('#imagenesModal').modal('show');
}

// Función para cargar las imágenes del registro
function cargarImagenesRegistro(idRegistro, idFoto, id_proceso_tramites) {
    $.ajax({
        url: 'ajax/obtener_imagenes_registro.php',
        type: 'GET',
        data: { id: idRegistro },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                todasLasImagenes = response.imagenes;
                
                // Si no hay imágenes, mostrar mensaje
                if (todasLasImagenes.length === 0) {
                    $('#imagenPrincipal').attr('src', 'img/no_imagen.jpg');
                    $('#imagenesSecundarias').html('<div class="alert alert-info">Este registro no tiene imágenes.</div>');
                    return;
                }
                
                // Mostrar imagen principal
                mostrarImagenPrincipal(0);
                
                // Generar miniaturas para todas las imágenes
                todasLasImagenes.forEach((imagen, index) => {
                    const miniatura = $('<img>')
                        .addClass('imagen-miniatura mb-2')
                        .attr('src', imagen.rutaImagen)
                        .attr('data-index', index)
                        .attr('alt', 'Imagen ' + (index + 1));
                    
                    // Marcar la imagen actual como activa
                    if (index === 0) {
                        miniatura.addClass('active');
                    }
                    
                    // Evento click para cambiar la imagen principal
                    miniatura.on('click', function() {
                        $('.imagen-miniatura').removeClass('active');
                        $(this).addClass('active');
                        mostrarImagenPrincipal($(this).data('index'));
                    });
                    
                    $('#imagenesSecundarias').append(miniatura);
                });
            } else {
                // Mostrar mensaje de error
                $('#imagenPrincipal').attr('src', 'img/no_imagen.jpg');
                $('#imagenesSecundarias').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar imágenes:', error);
            $('#imagenPrincipal').attr('src', 'img/no_imagen.jpg');
            $('#imagenesSecundarias').html('<div class="alert alert-danger">Error al cargar las imágenes. Por favor intente de nuevo.</div>');
        }
    });
}

// Función para mostrar la imagen principal seleccionada
function mostrarImagenPrincipal(index) {
    imagenActual = index;
    const imagen = todasLasImagenes[index];
    $('#imagenPrincipal').attr('src', imagen.rutaImagen);
    $('#imagenPrincipal').attr('alt', 'Imagen ' + (index + 1) + ' de ' + todasLasImagenes.length);
}

// Inicialización cuando el documento está listo
$(document).ready(function() {
    // Delegación de eventos para los clicks en imágenes de la tabla
    $(document).on('click', '.imagen-registro', function(e) {
        e.preventDefault();
        
        const id = $(this).data('id');
        const idFoto = $(this).data('foto');
        const nombreComercial = $(this).data('nombre');
        const folio = $(this).data('folio');
        const id_proceso_tramites = $(this).data('id_proceso_tramites');
        
        abrirModalImagenes(id, idFoto, nombreComercial, folio, id_proceso_tramites);
    });
}); 

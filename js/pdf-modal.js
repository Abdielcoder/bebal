// Variables para manejar el dropzone
let dropzone;
let uploadingFiles = 0;

// Función para inicializar el modal de PDF para un registro específico
function pdf_registro(id) {
    // Establecer el ID del registro en el campo oculto
    $('#pdf_id_registro').val(id);
    
    // Limpiar resultados previos
    $('#resultados_pdf').html('');
    $('#pdf_archivos_manual').val('');
    $('#upload-progress-container').addClass('d-none');
    $('#upload-progress-bar').css('width', '0%').attr('aria-valuenow', 0);
    
    // Destruir Dropzone si existe
    if (typeof dropzone !== 'undefined' && dropzone !== null) {
        dropzone.destroy();
        dropzone = null;
    }
    
    // Inicializar Dropzone
    inicializarDropzone(id);
    
    // Cargar la lista de PDFs existentes para este registro
    cargarPDFs(id);
}

// Función para inicializar Dropzone de forma simplificada
function inicializarDropzone(id_registro) {
    // Aseguramos que Dropzone no auto-descubra el elemento
    Dropzone.autoDiscover = false;
    
    // Crear nueva instancia de Dropzone
    dropzone = new Dropzone("#dropzone-pdfs", {
        url: "ajax/subir_pdf.php",
        method: "post",
        paramName: "pdf_archivo",
        acceptedFiles: ".pdf",
        maxFiles: null, // Sin límite de archivos
        maxFilesize: 20, // 20MB
        parallelUploads: 3,
        createImageThumbnails: false,
        autoQueue: true,
        autoProcessQueue: true,
        clickable: true,
        previewsContainer: false,
        params: {
            id_registro: id_registro
        }
    });
    
    // Eventos de Dropzone
    
    // Cuando se inicia el proceso total
    dropzone.on("sending", function(file) {
        // Mostrar barra de progreso
        $('#upload-progress-container').removeClass('d-none');
        
        // Actualizar contador
        uploadingFiles++;
        
        // Mostrar mensaje de carga
        if ($('#resultados_pdf').find('.alert-info').length === 0) {
            $('#resultados_pdf').html('<div class="alert alert-info">Subiendo archivos... <div class="loading-spinner"></div></div>');
        }
    });
    
    // Durante el progreso de subida
    dropzone.on("uploadprogress", function(file, progress) {
        let progressValue = Math.round(progress);
        $('#upload-progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);
    });
    
    // Cuando un archivo se sube con éxito
    dropzone.on("success", function(file, response) {
        console.log("Archivo subido con éxito:", file.name);
        
        uploadingFiles--;
        
        // Si ya no quedan archivos subiendo
        if (uploadingFiles === 0) {
            $('#resultados_pdf').html('<div class="alert alert-success">Todos los archivos se han subido correctamente.</div>');
            cargarPDFs(id_registro);
            
            // Ocultar barra de progreso después de un tiempo
            setTimeout(function() {
                $('#upload-progress-container').addClass('d-none');
            }, 1000);
        }
    });
    
    // Cuando ocurre un error
    dropzone.on("error", function(file, errorMessage) {
        console.error("Error al subir archivo:", file.name, errorMessage);
        
        uploadingFiles--;
        
        // Si ya no quedan archivos subiendo
        if (uploadingFiles === 0) {
            $('#resultados_pdf').html('<div class="alert alert-danger">Error al subir algunos archivos.</div>');
            cargarPDFs(id_registro);
            
            // Ocultar barra de progreso
            $('#upload-progress-container').addClass('d-none');
        }
    });
    
    // Mostrar mensaje cuando se completa toda la cola
    dropzone.on("queuecomplete", function() {
        console.log("Cola de subida completada");
        
        // Verificar si hay archivos con errores
        if (dropzone.getUploadingFiles().length === 0 && dropzone.getQueuedFiles().length === 0) {
            // Recargar la lista
            cargarPDFs(id_registro);
        }
    });
    
    // Eventos para prevenir el comportamiento predeterminado
    
    // Prevenir abrir PDFs cuando se arrastran al documento
    $(document).on('dragover drop', function(e) {
        if (!$(e.target).closest('#dropzone-pdfs').length) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
    
    // Eventos especiales para la zona de dropzone
    $('#dropzone-pdfs').on('dragenter', function() {
        $(this).addClass('dz-drag-hover');
    }).on('dragleave dragend drop', function() {
        $(this).removeClass('dz-drag-hover');
    });
    
    console.log("Dropzone inicializado correctamente");
}

// Función para cargar PDFs manualmente
$(document).on('click', '#btn-subir-pdf-manual', function() {
    const archivos = $('#pdf_archivos_manual')[0].files;
    
    if (archivos.length === 0) {
        $('#resultados_pdf').html('<div class="alert alert-warning">Debe seleccionar al menos un archivo PDF.</div>');
        return;
    }
    
    // Mostrar mensaje de carga
    $('#resultados_pdf').html('<div class="alert alert-info">Preparando archivos para subir... <div class="loading-spinner"></div></div>');
    
    // Mostrar barra de progreso
    $('#upload-progress-container').removeClass('d-none');
    $('#upload-progress-bar').css('width', '0%').attr('aria-valuenow', 0);
    
    // Contador para archivos subidos
    let archivosSubidos = 0;
    let archivosConError = 0;
    
    // Subir cada archivo individualmente
    for (let i = 0; i < archivos.length; i++) {
        const formData = new FormData();
        formData.append('id_registro', $('#pdf_id_registro').val());
        formData.append('pdf_archivo', archivos[i]);
        
        // Calcular progreso aproximado para esta parte del proceso
        const progresoInicial = Math.round((i / archivos.length) * 100);
        $('#upload-progress-bar').css('width', progresoInicial + '%').attr('aria-valuenow', progresoInicial);
        
        $.ajax({
            url: 'ajax/subir_pdf.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    archivosSubidos++;
                    console.log("Archivo subido con éxito:", archivos[i].name);
                } else {
                    archivosConError++;
                    console.error('Error al subir archivo:', response.message);
                }
                
                // Actualizar progreso
                const progreso = Math.round(((archivosSubidos + archivosConError) / archivos.length) * 100);
                $('#upload-progress-bar').css('width', progreso + '%').attr('aria-valuenow', progreso);
                
                // Verificar si todos los archivos se han procesado
                if ((archivosSubidos + archivosConError) === archivos.length) {
                    // Actualizar mensaje según resultado
                    if (archivosConError === 0) {
                        $('#resultados_pdf').html('<div class="alert alert-success">Todos los archivos se han subido correctamente.</div>');
                    } else if (archivosSubidos === 0) {
                        $('#resultados_pdf').html('<div class="alert alert-danger">No se pudo subir ningún archivo. Por favor, inténtelo nuevamente.</div>');
                    } else {
                        $('#resultados_pdf').html('<div class="alert alert-warning">Se subieron ' + archivosSubidos + ' archivos, pero ' + archivosConError + ' no se pudieron subir.</div>');
                    }
                    
                    // Recargar la lista de PDFs
                    cargarPDFs($('#pdf_id_registro').val());
                    
                    // Limpiar campo de archivo
                    $('#pdf_archivos_manual').val('');
                    
                    // Ocultar barra de progreso después de un tiempo
                    setTimeout(function() {
                        $('#upload-progress-container').addClass('d-none');
                    }, 1000);
                }
            },
            error: function() {
                archivosConError++;
                
                // Actualizar progreso
                const progreso = Math.round(((archivosSubidos + archivosConError) / archivos.length) * 100);
                $('#upload-progress-bar').css('width', progreso + '%').attr('aria-valuenow', progreso);
                
                // Verificar si todos los archivos se han procesado
                if ((archivosSubidos + archivosConError) === archivos.length) {
                    // Actualizar mensaje según resultado
                    if (archivosSubidos === 0) {
                        $('#resultados_pdf').html('<div class="alert alert-danger">Error al subir los archivos. Por favor, inténtelo nuevamente.</div>');
                    } else {
                        $('#resultados_pdf').html('<div class="alert alert-warning">Se subieron ' + archivosSubidos + ' archivos, pero ' + archivosConError + ' no se pudieron subir.</div>');
                    }
                    
                    // Recargar la lista de PDFs
                    cargarPDFs($('#pdf_id_registro').val());
                    
                    // Limpiar campo de archivo
                    $('#pdf_archivos_manual').val('');
                    
                    // Ocultar barra de progreso después de un tiempo
                    setTimeout(function() {
                        $('#upload-progress-container').addClass('d-none');
                    }, 1000);
                }
            }
        });
    }
});

// Función para cargar los PDFs existentes
function cargarPDFs(id_registro) {
    $.ajax({
        url: 'ajax/obtener_pdfs_registro.php',
        type: 'POST',
        data: { id_registro: id_registro },
        dataType: 'json',
        success: function(response) {
            let lista_html = '';
            
            if (response.success && response.pdfs.length > 0) {
                response.pdfs.forEach(function(pdf) {
                    lista_html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="${pdf.rutaPdf}" target="_blank" class="text-primary">
                                <i class="bi bi-file-pdf me-2"></i>${pdf.nombre_archivo}
                            </a>
                            <small class="text-muted d-block">${pdf.fecha_subida}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger eliminar-pdf" data-id="${pdf.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
                });
            } else {
                lista_html = '<div class="alert alert-info">No hay documentos PDF asociados a este registro.</div>';
            }
            
            $('#lista_pdfs').html(lista_html);
        },
        error: function() {
            $('#lista_pdfs').html('<div class="alert alert-danger">Error al cargar los PDFs.</div>');
        }
    });
}

// Evento para eliminar un PDF
$(document).on('click', '.eliminar-pdf', function() {
    if (confirm('¿Está seguro de eliminar este documento?')) {
        let id_pdf = $(this).data('id');
        let id_registro = $('#pdf_id_registro').val();
        
        $.ajax({
            url: 'ajax/eliminar_pdf.php',
            type: 'POST',
            data: { id_pdf: id_pdf },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Recargar la lista de PDFs
                    cargarPDFs(id_registro);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error al eliminar el documento.');
            }
        });
    }
}); 
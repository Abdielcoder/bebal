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
    
    // Inicializar Dropzone si no existe
    if (!dropzone) {
        inicializarDropzone();
    } else {
        // Si ya existe, actualizamos el ID del registro
        dropzone.options.params.id_registro = id;
        dropzone.removeAllFiles(true);
    }
    
    // Cargar la lista de PDFs existentes para este registro
    cargarPDFs(id);
}

// Función para inicializar Dropzone
function inicializarDropzone() {
    // Deshabilitar la funcionalidad automática de Dropzone
    Dropzone.autoDiscover = false;
    
    // Eliminar instancia previa si existe
    if (dropzone) {
        dropzone.destroy();
    }
    
    // Configurar Dropzone
    dropzone = new Dropzone("#dropzone-pdfs", {
        url: "ajax/subir_pdf.php",
        paramName: "pdf_archivo",
        acceptedFiles: ".pdf",
        autoProcessQueue: true,
        uploadMultiple: false,
        parallelUploads: 2,
        maxFilesize: 20, // MB
        dictDefaultMessage: "Arrastra archivos aquí o haz clic para seleccionarlos",
        dictFallbackMessage: "Tu navegador no soporta la carga de archivos por arrastrar y soltar.",
        dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo: {{maxFilesize}}MB.",
        dictInvalidFileType: "No puedes subir archivos de este tipo. Solo se permiten PDF.",
        dictResponseError: "El servidor respondió con {{statusCode}}",
        dictCancelUpload: "Cancelar",
        dictCancelUploadConfirmation: "¿Estás seguro de que deseas cancelar esta carga?",
        dictRemoveFile: "Eliminar",
        dictMaxFilesExceeded: "No puedes subir más archivos.",
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
        },
        params: {
            id_registro: $('#pdf_id_registro').val()
        },
        init: function() {
            const dz = this;
            
            // Cuando se agrega un archivo
            this.on("addedfile", function(file) {
                uploadingFiles++;
                // Mostrar mensaje de carga
                $('#resultados_pdf').html('<div class="alert alert-info">Subiendo archivos... <div class="loading-spinner"></div></div>');
            });
            
            // Cuando un archivo comienza a subirse
            this.on("uploadprogress", function(file, progress) {
                // Mostrar barra de progreso
                $('#upload-progress-container').removeClass('d-none');
                // Actualizar valor de la barra
                let progressValue = Math.round(progress);
                $('#upload-progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);
            });
            
            // Cuando un archivo se sube con éxito
            this.on("success", function(file, response) {
                try {
                    const respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (respuesta.success) {
                        uploadingFiles--;
                        
                        if (uploadingFiles === 0) {
                            // Todos los archivos se han subido
                            $('#resultados_pdf').html('<div class="alert alert-success">Todos los archivos se han subido correctamente.</div>');
                            
                            // Recargar la lista de PDFs
                            cargarPDFs($('#pdf_id_registro').val());
                            
                            // Ocultar barra de progreso después de un tiempo
                            setTimeout(function() {
                                $('#upload-progress-container').addClass('d-none');
                            }, 1000);
                            
                            // Limpiar la cola después de un tiempo
                            setTimeout(function() {
                                dz.removeAllFiles(true);
                            }, 2000);
                        }
                    } else {
                        uploadingFiles--;
                        // Mostrar mensaje de error para este archivo específico
                        file.previewElement.classList.add("dz-error");
                        const errorNode = document.createElement('div');
                        errorNode.innerHTML = respuesta.message;
                        file.previewElement.appendChild(errorNode);
                        
                        // Actualizar mensaje global si es el último archivo
                        if (uploadingFiles === 0) {
                            $('#resultados_pdf').html('<div class="alert alert-warning">Algunos archivos no se pudieron subir. Verifica los mensajes de error.</div>');
                            
                            // Ocultar barra de progreso
                            $('#upload-progress-container').addClass('d-none');
                        }
                    }
                } catch (e) {
                    // Error al parsear la respuesta JSON
                    uploadingFiles--;
                    file.previewElement.classList.add("dz-error");
                    $('#resultados_pdf').html('<div class="alert alert-danger">Error inesperado al procesar la respuesta del servidor.</div>');
                    
                    // Ocultar barra de progreso
                    $('#upload-progress-container').addClass('d-none');
                }
            });
            
            // Cuando ocurre un error
            this.on("error", function(file, errorMessage) {
                uploadingFiles--;
                if (uploadingFiles === 0) {
                    $('#resultados_pdf').html('<div class="alert alert-danger">Error al subir los archivos.</div>');
                    
                    // Ocultar barra de progreso
                    $('#upload-progress-container').addClass('d-none');
                }
            });
            
            // Cuando se completa la cola (ya sea con éxito o error)
            this.on("queuecomplete", function() {
                if (uploadingFiles === 0) {
                    // Recargar la lista de PDFs
                    cargarPDFs($('#pdf_id_registro').val());
                }
            });
        }
    });
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
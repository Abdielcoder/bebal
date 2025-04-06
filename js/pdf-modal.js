// Variables para manejar el dropzone
let dropzone;
let uploadingFiles = 0;

// Función para inicializar el modal de PDF para un registro específico
function pdf_registro(id) {
    // Establecer el ID del registro en el campo oculto
    $('#pdf_id_registro').val(id);
    
    // Limpiar resultados previos
    $('#resultados_pdf').html('');
    
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
                $('#resultados_pdf').html('<div class="alert alert-info">Subiendo archivos... <i class="bi bi-arrow-repeat spin"></i></div>');
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
                        }
                    }
                } catch (e) {
                    // Error al parsear la respuesta JSON
                    uploadingFiles--;
                    file.previewElement.classList.add("dz-error");
                    $('#resultados_pdf').html('<div class="alert alert-danger">Error inesperado al procesar la respuesta del servidor.</div>');
                }
            });
            
            // Cuando ocurre un error
            this.on("error", function(file, errorMessage) {
                uploadingFiles--;
                if (uploadingFiles === 0) {
                    $('#resultados_pdf').html('<div class="alert alert-danger">Error al subir los archivos.</div>');
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
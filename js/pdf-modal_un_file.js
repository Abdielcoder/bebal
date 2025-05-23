// Variables globales
let dropzoneInstance;
let uploadingFiles = 0;

// Función para inicializar el modal de PDF para un registro específico
function pdf_registro1file(id,conjunto,folio,id_proceso_tramites,page) {
    console.log("Inicializando modal PDF para registro ID:", id);
 
//alert("id="+id+", conjunto="+conjunto+", folio="+folio+", id_proceso_tramites="+id_proceso_tramites);
    // Establecer el ID del registro en el campo oculto
    $('#pdf_id_registro').val(id);
    $('#pdf_conjunto').val(conjunto);
    $('#pdf_folio').val(folio);
    $('#pdf_id_proceso_tramites').val(id_proceso_tramites);
    $('#page').val(page);
    
    // Limpiar resultados previos
    $('#resultados_pdf').html('');
    $('#pdf_archivos_manual').val('');
    $('#upload-progress-container').addClass('d-none');
    $('#upload-progress-bar').css('width', '0%').attr('aria-valuenow', 0);
    
    // Desactivar la auto-detección para manejar manualmente
    Dropzone.autoDiscover = false;
    
    // Destruir instancia previa si existe
    if (dropzoneInstance) {
        dropzoneInstance.destroy();
        console.log("Instancia previa de Dropzone destruida");
    }
    
    // Inicializar nueva instancia de Dropzone
    console.log("Creando nueva instancia de Dropzone");
    
    dropzoneInstance = new Dropzone("#mi-dropzone", {
        paramName: "pdf_archivo",
        acceptedFiles: ".pdf",
        maxFilesize: 20, // 20MB
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: null, // Sin límite
        addRemoveLinks: true,
        dictDefaultMessage: "Arrastra archivos aquí o haz clic para seleccionarlos",
        dictRemoveFile: "Eliminar",
        dictCancelUpload: "Cancelar",
        dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo: {{maxFilesize}}MB.",
        dictResponseError: "Error: {{statusCode}}",
        params: {
            id_registro: id
        },
        init: function() {
            console.log("Dropzone inicializado con ID de registro:", id);
            
            this.on("addedfile", function(file) {
                console.log("Archivo añadido:", file.name);
            });
            
            this.on("sending", function(file, xhr, formData) {
                // Asegurarse de que el id_registro se envía correctamente
                formData.append("id_registro", id);
                console.log("Enviando archivo:", file.name);
                
                // Mostrar indicador de progreso
                $('#upload-progress-container').removeClass('d-none');
                $('#resultados_pdf').html('<div class="alert alert-info">Subiendo archivos... <div class="loading-spinner"></div></div>');
                
                uploadingFiles++;
            });
            
            this.on("uploadprogress", function(file, progress) {
                let progressValue = Math.round(progress);
                $('#upload-progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);
                console.log("Progreso:", file.name, progressValue + "%");
            });
            
            this.on("success", function(file, response) {
                console.log("Archivo subido con éxito:", file.name, response);
                
                uploadingFiles--;
                file.previewElement.classList.add("dz-success");
                
                if (uploadingFiles === 0) {
                    $('#resultados_pdf').html('<div class="alert alert-success">Todos los archivos se han subido correctamente.</div>');
                    cargarPDFs(id);
                    
                    setTimeout(function() {
                        $('#upload-progress-container').addClass('d-none');
                    }, 1000);
                }
            });
            
            this.on("error", function(file, errorMessage) {
                console.error("Error al subir archivo:", file.name, errorMessage);
                
                uploadingFiles--;
                file.previewElement.classList.add("dz-error");
                
                if (uploadingFiles === 0) {
                    $('#resultados_pdf').html('<div class="alert alert-danger">Ha ocurrido un error al subir algunos archivos.</div>');
                    cargarPDFs(id);
                    
                    $('#upload-progress-container').addClass('d-none');
                }
            });
            
            this.on("queuecomplete", function() {
                console.log("Cola de subida completada");
                cargarPDFs(id);
            });
        }
    });
    
    // Cargar la lista de PDFs existentes para este registro
    cargarPDFs(id);
}

// Función para cargar PDFs manualmente
$(document).on('click', '#btn-subir-pdf-manual', function() {
    const archivos = $('#pdf_archivos_manual')[0].files;
    const id_registro = $('#pdf_id_registro').val();
    const conjunto = $('#pdf_conjunto').val();
    const folio = $('#pdf_folio').val();
    const id_proceso_tramites = $('#pdf_id_proceso_tramites').val();
    const page = $('#page').val();
    
//alert("btn-subir-pdf-manual--> id="+id_registro+", conjunto="+conjunto+", folio="+folio+", id_proceso_tramites="+id_proceso_tramites);
	//
    console.log("Iniciando carga manual de", archivos.length, "archivos para registro Folio:", folio);
    
    if (archivos.length === 0) {
        $('#resultados_pdf').html('<div class="alert alert-warning">Debe seleccionar un archivo PDF.</div>');
        return;
    }
    
    // Mostrar mensaje de carga
    $('#resultados_pdf').html('<div class="alert alert-info">Preparando archivo para subir... <div class="loading-spinner"></div></div>');
    
    // Mostrar barra de progreso
    $('#upload-progress-container').removeClass('d-none');
    $('#upload-progress-bar').css('width', '0%').attr('aria-valuenow', 0);
    
    // Contador para archivos subidos
    let archivosSubidos = 0;
    let archivosConError = 0;
    
    // Subir cada archivo individualmente
    for (let i = 0; i < archivos.length; i++) {
        const formData = new FormData();
        formData.append('id_registro', id_registro);
        formData.append('conjunto', conjunto);
        formData.append('folio', folio);
        formData.append('id_proceso_tramites', id_proceso_tramites);
        formData.append('page', page);
        formData.append('pdf_archivo', archivos[i]);
        
        console.log("Preparando archivo", i+1, "de", archivos.length, ":", archivos[i].name);
        
        // Calcular progreso aproximado para esta parte del proceso
        const progresoInicial = Math.round((i / archivos.length) * 100);
        $('#upload-progress-bar').css('width', progresoInicial + '%').attr('aria-valuenow', progresoInicial);
        
        $.ajax({
            url: 'ajax/subir_1pdf.php',
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
                        $('#resultados_pdf').html('<div class="alert alert-success">El archivo ha subido correctamente. Espere un Momento  la ventana se cerrará Automáticamente..</div>');
                    } else if (archivosSubidos === 0) {
                        $('#resultados_pdf').html('<div class="alert alert-danger">No se pudo subir ningún archivo. Por favor, inténtelo nuevamente.</div>');
                    } else {
                        $('#resultados_pdf').html('<div class="alert alert-warning">Se subieron ' + archivosSubidos + ' archivos, pero ' + archivosConError + ' no se pudieron subir.</div>');
                    }
                    
                    // Recargar la lista de PDFs
                    cargarPDFs(id_registro);
                    
                    // Limpiar campo de archivo
                    $('#pdf_archivos_manual').val('');
                    
                    // Ocultar barra de progreso después de un tiempo
                    setTimeout(function() {
                        $('#upload-progress-container').addClass('d-none');
                    }, 1000);
                }



                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
            location.replace('principalPDFs.php?id='+id_registro+'&page='+page+'&id_proceso_tramites='+id_proceso_tramites);
                        }, 3000);



            },
            error: function() {
                archivosConError++;
                console.error("Error de Ajax al subir archivo:", archivos[i].name);
                
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
                    cargarPDFs(id_registro);
                    
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
    console.log("Cargando lista de PDFs para registro ID:", id_registro);
    
    $.ajax({
        url: 'ajax/obtener_pdfs_registro.php',
        type: 'POST',
        data: { id_registro: id_registro },
        dataType: 'json',
        success: function(response) {
            console.log("Respuesta de PDFs obtenida:", response);
            
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
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error al cargar PDFs:", textStatus, errorThrown);
            $('#lista_pdfs').html('<div class="alert alert-danger">Error al cargar los PDFs.</div>');
        }
    });
}

// Evento para eliminar un PDF
$(document).on('click', '.eliminar-pdf', function() {
    if (confirm('¿Está seguro de eliminar este documento?')) {
        let id_pdf = $(this).data('id');
        let id_registro = $('#pdf_id_registro').val();
        let conjunto = $('#pdf_conjunto').val();
    	let folio = $('#pdf_folio').val();
    	let id_proceso_tramites = $('#pdf_id_proceso_tramites').val();

        
        console.log("Eliminando PDF ID:", id_pdf);
        
        $.ajax({
            url: 'ajax/eliminar_pdf.php',
            type: 'POST',
            data: { id_pdf: id_pdf },
            dataType: 'json',
            success: function(response) {
                console.log("Respuesta al eliminar PDF:", response);
                
                if (response.success) {
                    // Recargar la lista de PDFs
                    cargarPDFs(id_registro);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error al eliminar PDF:", textStatus, errorThrown);
                alert('Error al eliminar el documento.');
            }
        });
    }
}); 

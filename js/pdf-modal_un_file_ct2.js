// Variables globales
let dropzoneInstance_ct2;
let uploadingFiles_ct2 = 0;

// Función para inicializar el modal de PDF para un registro específico
function pdf_registro1file_ct2(id,conjunto,folio,id_proceso_tramites,page) {
    console.log("Inicializando modal PDF para registro ID:", id);
 
//alert("id="+id+", conjunto="+conjunto+", folio="+folio+", id_proceso_tramites="+id_proceso_tramites);
    // Establecer el ID del registro en el campo oculto
    $('#pdf_id_registro_ct2').val(id);
    $('#pdf_conjunto_ct2').val(conjunto);
    $('#pdf_folio_ct2').val(folio);
    $('#pdf_id_proceso_tramites_ct2').val(id_proceso_tramites);
    $('#page_ct2').val(page);
    
    // Limpiar resultados previos
    $('#resultados_pdf_ct2').html('');
    $('#pdf_archivos_manual_ct2').val('');
    $('#upload-progress-container_ct2').addClass('d-none');
    $('#upload-progress-bar_ct2').css('width', '0%').attr('aria-valuenow', 0);
    
    // Desactivar la auto-detección para manejar manualmente
    Dropzone.autoDiscover = false;
    
    // Destruir instancia previa si existe
    if (dropzoneInstance_ct2) {
        dropzoneInstance_ct2.destroy();
        console.log("Instancia previa de Dropzone destruida");
    }
    
    // Inicializar nueva instancia de Dropzone
    console.log("Creando nueva instancia de Dropzone");
    
    dropzoneInstance_ct2 = new Dropzone("#mi-dropzone", {
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
                $('#upload-progress-container_ct2').removeClass('d-none');
                $('#resultados_pdf_ct2').html('<div class="alert alert-info">Subiendo archivos... <div class="loading-spinner"></div></div>');
                
                uploadingFiles_ct2++;
            });
            
            this.on("uploadprogress", function(file, progress) {
                let progressValue = Math.round(progress);
                $('#upload-progress-bar_ct2').css('width', progressValue + '%').attr('aria-valuenow', progressValue);
                console.log("Progreso:", file.name, progressValue + "%");
            });
            
            this.on("success", function(file, response) {
                console.log("Archivo subido con éxito:", file.name, response);
                
                uploadingFiles_ct2--;
                file.previewElement.classList.add("dz-success");
                
                if (uploadingFiles_ct2 === 0) {
                    $('#resultados_pdf_ct2').html('<div class="alert alert-success">Todos los archivos se han subido correctamente.</div>');
                    cargarPDFs(id);
                    
                    setTimeout(function() {
                        $('#upload-progress-container_ct2').addClass('d-none');
                    }, 1000);
                }
            });
            
            this.on("error", function(file, errorMessage) {
                console.error("Error al subir archivo:", file.name, errorMessage);
                
                uploadingFiles_ct2--;
                file.previewElement.classList.add("dz-error");
                
                if (uploadingFiles_ct2 === 0) {
                    $('#resultados_pdf_ct2').html('<div class="alert alert-danger">Ha ocurrido un error al subir algunos archivos.</div>');
                    cargarPDFs(id);
                    
                    $('#upload-progress-container_ct2').addClass('d-none');
                }
            });
            
            this.on("queuecomplete", function() {
                console.log("Cola de subida completada");
                cargarPDFs(id);
            });
        }
    });
    
    // Cargar la lista de PDFs existentes para este registro
    //cargarPDFs(id);
}

// Función para cargar PDFs manualmente
$(document).on('click', '#btn-subir-pdf-manual_ct2', function() {
    const archivos = $('#pdf_archivos_manual_ct2')[0].files;
    const id_registro = $('#pdf_id_registro_ct2').val();
    const conjunto = $('#pdf_conjunto_ct2').val();
    const folio = $('#pdf_folio_ct2').val();
    const id_proceso_tramites = $('#pdf_id_proceso_tramites_ct2').val();
    const page = $('#page_ct2').val();
    
//alert("btn-subir-pdf-manual--> id="+id_registro+", conjunto="+conjunto+", folio="+folio+", id_proceso_tramites="+id_proceso_tramites);

	//
    console.log("Iniciando carga manual de", archivos.length, "archivos para registro Folio:", folio);
    
    if (archivos.length === 0) {
        $('#resultados_pdf_ct2').html('<div class="alert alert-warning">Debe seleccionar un archivo PDF.</div>');
        return;
    }
    
    // Mostrar mensaje de carga
    $('#resultados_pdf_ct2').html('<div class="alert alert-info">Preparando archivo para subir... <div class="loading-spinner"></div></div>');
    
    // Mostrar barra de progreso
    $('#upload-progress-container_ct2').removeClass('d-none');
    $('#upload-progress-bar_ct2').css('width', '0%').attr('aria-valuenow', 0);
    
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
        $('#upload-progress-bar_ct2').css('width', progresoInicial + '%').attr('aria-valuenow', progresoInicial);
        
        $.ajax({
            url: 'ajax/subir_1pdfTemporal.php',
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
                $('#upload-progress-bar_ct2').css('width', progreso + '%').attr('aria-valuenow', progreso);
                
                // Verificar si todos los archivos se han procesado
                if ((archivosSubidos + archivosConError) === archivos.length) {
                    // Actualizar mensaje según resultado
                    if (archivosConError === 0) {
                        $('#resultados_pdf_ct2').html('<div class="alert alert-success">El archivo ha subido correctamente. Espere un Momento  la ventana se cerrará Automáticamente..</div>');
                    } else if (archivosSubidos === 0) {
                        $('#resultados_pdf_ct2').html('<div class="alert alert-danger">No se pudo subir ningún archivo. Por favor, inténtelo nuevamente.</div>');
                    } else {
                        $('#resultados_pdf_ct2').html('<div class="alert alert-warning">Se subieron ' + archivosSubidos + ' archivos, pero ' + archivosConError + ' no se pudieron subir.</div>');
                    }
                    
                    // Recargar la lista de PDFs
                    //cargarPDFs(id_registro);
                    
                    // Limpiar campo de archivo
                    $('#pdf_archivos_manual_ct2').val('');
                    
                    // Ocultar barra de progreso después de un tiempo
                    setTimeout(function() {
                        $('#upload-progress-container_ct2').addClass('d-none');
                    }, 1000);
                }



                        window.setTimeout(function() {
                                $(".alert").fadeTo(150, 0).slideUp(150, function(){
                                $(this).remove();});
            location.replace('principalPDFsTemporal.php?id='+id_registro+'&page='+page+'&id_proceso_tramites='+id_proceso_tramites);
                        }, 3000);



            },
            error: function() {
                archivosConError++;
                console.error("Error de Ajax al subir archivo:", archivos[i].name);
                
                // Actualizar progreso
                const progreso = Math.round(((archivosSubidos + archivosConError) / archivos.length) * 100);
                $('#upload-progress-bar_ct2').css('width', progreso + '%').attr('aria-valuenow', progreso);
                
                // Verificar si todos los archivos se han procesado
                if ((archivosSubidos + archivosConError) === archivos.length) {
                    // Actualizar mensaje según resultado
                    if (archivosSubidos === 0) {
                        $('#resultados_pdf_ct2').html('<div class="alert alert-danger">Error al subir los archivos. Por favor, inténtelo nuevamente.</div>');
                    } else {
                        $('#resultados_pdf_ct2').html('<div class="alert alert-warning">Se subieron ' + archivosSubidos + ' archivos, pero ' + archivosConError + ' no se pudieron subir.</div>');
                    }
                    
                    // Recargar la lista de PDFs
                    //cargarPDFs(id_registro);
                    
                    // Limpiar campo de archivo
                    $('#pdf_archivos_manual_ct2').val('');
                    
                    // Ocultar barra de progreso después de un tiempo
                    setTimeout(function() {
                        $('#upload-progress-container_ct2').addClass('d-none');
                    }, 1000);
                }
            }
        });
    }
});


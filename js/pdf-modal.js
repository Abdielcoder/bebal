// Función para inicializar el modal de PDF para un registro específico
function pdf_registro(id) {
    // Establecer el ID del registro en el campo oculto
    $('#pdf_id_registro').val(id);
    
    // Limpiar el formulario
    $('#pdf_descripcion').val('');
    $('#pdf_archivo').val('');
    $('#resultados_pdf').html('');
    
    // Cargar la lista de PDFs existentes para este registro
    cargarPDFs(id);
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
                                <i class="bi bi-file-pdf me-2"></i>${pdf.descripcion}
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

// Evento para subir un nuevo PDF
$(document).on('click', '#btn-subir-pdf', function() {
    // Validar que se haya seleccionado un archivo
    if (!$('#pdf_archivo').val()) {
        $('#resultados_pdf').html('<div class="alert alert-danger">Debe seleccionar un archivo PDF.</div>');
        return;
    }
    
    // Validar que se haya ingresado una descripción
    if (!$('#pdf_descripcion').val().trim()) {
        $('#resultados_pdf').html('<div class="alert alert-danger">Debe ingresar una descripción para el documento.</div>');
        return;
    }
    
    // Crear un objeto FormData para enviar los datos del formulario
    let formData = new FormData($('#form-pdf')[0]);
    
    // Mostrar indicador de carga
    $('#resultados_pdf').html('<div class="text-center"><i class="bi bi-arrow-repeat spin"></i> Subiendo documento...</div>');
    
    // Enviar los datos al servidor
    $.ajax({
        url: 'ajax/subir_pdf.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#resultados_pdf').html('<div class="alert alert-success">El documento se ha subido correctamente.</div>');
                $('#pdf_descripcion').val('');
                $('#pdf_archivo').val('');
                
                // Recargar la lista de PDFs
                cargarPDFs($('#pdf_id_registro').val());
            } else {
                $('#resultados_pdf').html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        },
        error: function() {
            $('#resultados_pdf').html('<div class="alert alert-danger">Error al subir el documento.</div>');
        }
    });
});

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
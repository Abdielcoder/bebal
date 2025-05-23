<?php
// Modal para cargar PDFs
?>
<!-- Modal para PDFs -->
<div class="modal fade" id="pdfModalc4" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header"  style="background-color:#AC905B;color:white">
           <h6 class="modal-title" id="pdfModalLabel"><i class='bi bi-cloud-upload'></i>   Cargar PDF C4</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Botón para seleccionar archivos manualmente -->
        <div class="mb-3">
          <label for="pdf_archivos_manual_c4" class="form-label">Seleccionar Archivo C4 :</label>
          <div class="input-group">
            <input type="file" class="form-control" id="pdf_archivos_manual_c4" name="pdf_archivos_manual_c4" accept=".pdf" multiple>
            <button type="button" class="btn btn-primary" id="btn-subir-pdf-manual_c4">
              <i class="bi bi-upload"></i> Subir Archivo C4
            </button>
          </div>
        </div>
          
<!--        <div class="mb-3">--!>
          <!-- Este es el formulario que Dropzone convertirá en zona de arrastrar y soltar 
          <form action="ajax/subir_pdf.php" class="dropzone" id="mi-dropzone"> --!>
            <input type="hidden" id="pdf_id_registro_c4" name="id_registro" value=""> 
            <input type="hidden" id="pdf_conjunto_c4" name="conjunto" value=""> 
            <input type="hidden" id="pdf_folio_c4" name="folio" value=""> 
            <input type="hidden" id="pdf_id_proceso_tramites_c4" name="id_proceso_tramites" value=""> 
            <input type="hidden" id="page_c4" name="page" value=""> 
<!--           <div class="fallback">
              <input name="pdf_archivo" type="file" multiple />
            </div>
            <div class="dz-message needsclick">
              <i class="bi bi-file-pdf fs-1"></i>
              <h5>Arrastra los archivos PDF aquí o haz clic para seleccionarlos</h5>
              <p class="text-muted">Puedes subir múltiples archivos a la vez</p>
            </div>   --!>
          </form>
<!--        </div> --!>
          
        <!-- Indicador de progreso de carga -->
        <div class="progress mb-3 d-none" id="upload-progress-container_c4">
          <div class="progress-bar progress-bar-striped progress-bar-animated" id="upload-progress-bar_c4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
          
        <div id="resultados_pdf_c4"></div>
        
        <!-- Lista de PDFs existentes -->
<!--        <div class="mt-4">
          <h6>Documentos PDF asociados</h6>
          <div id="lista_pdfs" class="list-group"> --!>
            <!-- La lista de PDFs se cargará dinámicamente -->
<!--          </div>
        </div> --!>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
/* Estilos para Dropzone */
.dropzone {
  border: 2px dashed #0087F7;
  border-radius: 5px;
  background: #f8f9fa;
  min-height: 150px;
  padding: 20px;
  text-align: center;
  position: relative;
}

.dropzone:hover, 
.dropzone.dz-drag-hover {
  border-style: solid;
  background: #e9ecef;
}

.dropzone .dz-message {
  text-align: center;
  margin: 2em 0;
}

.dropzone .dz-preview .dz-image {
  border-radius: 8px;
  overflow: hidden;
  width: 120px;
  height: 120px;
  position: relative;
  display: block;
  z-index: 10;
}

.dropzone .dz-preview.dz-success .dz-success-mark {
  opacity: 1;
}

.dropzone .dz-preview.dz-error .dz-error-mark {
  opacity: 1;
}

/* Estilo para el spinner de carga */
.loading-spinner {
  display: inline-block;
  width: 1.5rem;
  height: 1.5rem;
  border: 0.25rem solid rgba(0, 0, 0, 0.1);
  border-right-color: #007bff;
  border-radius: 50%;
  animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
  to { transform: rotate(360deg); }
}
</style> 

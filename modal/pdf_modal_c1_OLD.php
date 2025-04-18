<?php
// Modal para cargar PDFs
?>
<!-- Modal para PDFs -->
<div class="modal fade" id="pdfModalc1" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header"  style="background-color:#AC905B;color:white">
           <h6 class="modal-title" id="pdfModalLabel"><i class='bi bi-cloud-upload'></i>   Cargar PDF C1</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Botón para seleccionar archivos manualmente -->
        <div class="mb-3">
          <label for="pdf_archivos_manual" class="form-label">Selecciona Archivo manualmente:</label>
          <div class="input-group">
            <input type="file" class="form-control" id="pdf_archivos_manual" name="pdf_archivos_manual" accept=".pdf" multiple>
            <button type="button" class="btn btn-primary" id="btn-subir-pdf-manual">
              <i class="bi bi-upload"></i> Subir Archivo
            </button>
          </div>
          
          </form>
        </div>
          
        <!-- Indicador de progreso de carga -->
        <div class="progress mb-3 d-none" id="upload-progress-container">
          <div class="progress-bar progress-bar-striped progress-bar-animated" id="upload-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
          
        <div id="resultados_pdf"></div>
        
        <!-- Lista de PDFs existentes -->
        <div class="mt-4">
          <h6>Documento PDF Asociado</h6>
          <div id="lista_pdfs" class="list-group">
            <!-- La lista de PDFs se cargará dinámicamente -->
          </div>
        </div>
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

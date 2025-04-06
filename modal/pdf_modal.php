<?php
// Modal para cargar PDFs
?>
<!-- Modal para PDFs -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfModalLabel">Cargar PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-pdf" enctype="multipart/form-data">
          <input type="hidden" id="pdf_id_registro" name="id_registro" value="">
          
          <!-- Botón para seleccionar archivos -->
          <div class="mb-3">
            <label for="pdf_archivos_manual" class="form-label">Seleccionar archivos manualmente:</label>
            <div class="input-group">
              <input type="file" class="form-control" id="pdf_archivos_manual" name="pdf_archivos_manual" accept=".pdf" multiple>
              <button type="button" class="btn btn-primary" id="btn-subir-pdf-manual">
                <i class="bi bi-upload"></i> Subir archivos
              </button>
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">O arrastra los archivos aquí:</label>
            <div class="dropzone-container">
              <div class="dropzone" id="dropzone-pdfs">
                <div class="dz-message">
                  <i class="bi bi-file-pdf fs-1"></i>
                  <h4>Arrastra los archivos PDF aquí o haz clic para seleccionarlos</h4>
                  <p class="text-muted">Puedes subir múltiples archivos a la vez</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Indicador de progreso de carga -->
          <div class="progress mb-3 d-none" id="upload-progress-container">
            <div class="progress-bar progress-bar-striped progress-bar-animated" id="upload-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
          </div>
          
          <div id="resultados_pdf"></div>
        </form>
        
        <!-- Lista de PDFs existentes -->
        <div class="mt-4">
          <h6>Documentos PDF asociados</h6>
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
.dropzone-container {
  position: relative;
  min-height: 150px;
  width: 100%;
}

.dropzone {
  border: 2px dashed #0087F7;
  border-radius: 5px;
  background: #f8f9fa;
  min-height: 150px;
  padding: 20px;
  text-align: center;
  cursor: pointer;
  width: 100%;
  position: relative;
}

.dropzone.dz-drag-hover {
  border-style: solid;
  background: #e9ecef;
}

.dz-message {
  margin: 2em 0;
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
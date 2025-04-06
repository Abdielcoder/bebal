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
          
          <div class="mb-3">
            <div class="dropzone" id="dropzone-pdfs">
              <div class="dz-message">
                <i class="bi bi-file-pdf fs-1"></i>
                <h4>Arrastra los archivos PDF aquí o haz clic para seleccionarlos</h4>
                <p class="text-muted">Puedes subir múltiples archivos a la vez</p>
              </div>
            </div>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
.dropzone {
  border: 2px dashed #0087F7;
  border-radius: 5px;
  background: #f8f9fa;
  min-height: 150px;
  padding: 20px;
  text-align: center;
  cursor: pointer;
}

.dropzone.dz-drag-hover {
  border-style: solid;
  background: #e9ecef;
}

.dz-message {
  margin: 2em 0;
}
</style> 
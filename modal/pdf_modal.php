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
            <label for="pdf_descripcion" class="form-label">Descripción del documento</label>
            <input type="text" class="form-control" id="pdf_descripcion" name="descripcion" required>
          </div>
          
          <div class="mb-3">
            <label for="pdf_archivo" class="form-label">Seleccionar PDF</label>
            <input type="file" class="form-control" id="pdf_archivo" name="pdf_archivo" accept=".pdf" required>
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
        <button type="button" class="btn btn-primary" id="btn-subir-pdf">Subir PDF</button>
      </div>
    </div>
  </div>
</div> 
<div class="modal fade" id="reciboPDF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Recibo de Inspección - <span id="modal_nombre_establecimiento"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe id="pdf_iframe" class="embed-responsive-item" src="about:blank" style="height:600px;"></iframe>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <a id="download_pdf" href="#" target="_blank" class="btn btn-primary">Descargar PDF</a>
        <button type="button" id="print_pdf" class="btn btn-success">Imprimir</button>
      </div>
    </div>
  </div>
</div>

<script>
// Script para manejar la previsualización y descarga del PDF
$(document).ready(function() {
  $('#reciboPDF').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');
    
    var modal = $(this);
    
    // Establecer el nombre del establecimiento en el título
    modal.find('#modal_nombre_establecimiento').text(nombre);
    
    // Configurar la URL del iframe y del enlace de descarga
    var pdfUrl = 'generar_pdf_recibo.php?id=' + id;
    modal.find('#pdf_iframe').attr('src', pdfUrl);
    modal.find('#download_pdf').attr('href', pdfUrl + '&download=1');
    
    // Configurar el botón de impresión
    modal.find('#print_pdf').on('click', function() {
      var iframe = document.getElementById('pdf_iframe');
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    });
  });
});
</script> 
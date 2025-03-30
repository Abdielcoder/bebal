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
            <div id="pdf_loading" class="text-center">
              <p><i class="glyphicon glyphicon-refresh glyphicon-spin"></i> Cargando PDF...</p>
            </div>
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
        <a id="html_version" href="#" target="_blank" class="btn btn-info">Versión HTML</a>
      </div>
    </div>
  </div>
</div>

<script>
// Estilos para el ícono de carga
document.head.insertAdjacentHTML('beforeend', `
  <style>
    .glyphicon-spin {
      animation: spin 1s infinite linear;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
`);

// Script para manejar la previsualización y descarga del PDF
$(document).ready(function() {
  $('#reciboPDF').on('show.bs.modal', function (event) {
    // Obtener el botón que activó el modal
    var button = $(event.relatedTarget);
    
    // Obtener los datos del botón
    var id = button.data('id');
    var nombre = button.data('nombre');
    
    // Referencia al modal
    var modal = $(this);
    
    // Establecer el nombre del establecimiento en el título
    modal.find('#modal_nombre_establecimiento').text(nombre);
    
    // Mostrar indicador de carga
    $('#pdf_loading').show();
    
    // Configurar la URL del iframe y del enlace de descarga
    var pdfUrl = 'generar_pdf_recibo.php?id=' + id;
    var htmlUrl = 'generar_pdf_html.php?id=' + id;
    
    // Cargar el PDF en el iframe
    var iframe = document.getElementById('pdf_iframe');
    iframe.onload = function() {
      // Ocultar indicador de carga cuando el PDF se cargue
      $('#pdf_loading').hide();
    };
    
    // Asignar URL al iframe y al enlace de descarga
    modal.find('#pdf_iframe').attr('src', pdfUrl);
    modal.find('#download_pdf').attr('href', pdfUrl + '&download=1');
    modal.find('#html_version').attr('href', htmlUrl);
    
    // Configurar el botón de impresión
    modal.find('#print_pdf').off('click').on('click', function() {
      var iframe = document.getElementById('pdf_iframe');
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
    });
  });
  
  // Asegurarse de que el modal se limpie al cerrarse
  $('#reciboPDF').on('hidden.bs.modal', function () {
    $(this).find('#pdf_iframe').attr('src', 'about:blank');
  });
});
</script> 
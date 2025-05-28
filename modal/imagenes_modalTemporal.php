<!-- Modal para mostrar las imágenes de los registros -->
<div class="modal fade" id="imagenesModalTemporal" tabindex="-1" aria-labelledby="imagenesModalLabelTemporal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

<div class="modal-header"  style="background-color:#AC905B;color:white">

        <h6 class="modal-title" id="imagenesModalLabelTemporal">Imágenes del registro</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 imagen-principal-container">
            <img id="imagenPrincipal" src="" class="img-fluid rounded" alt="Imagen principal">
          </div>
          <div class="col-md-4 imagenes-secundarias">
            <h6 class="mb-3">Todas las imágenes</h6>
            <div id="imagenesSecundarias" class="d-flex flex-column gap-2">
              <!-- Aquí se cargarán dinámicamente las miniaturas de las imágenes -->
            </div>
          </div>
        </div>
        <div class="mt-3">
          <h6 id="infoRegistro" class="text-muted"></h6>
        </div>
      </div>
      <div class="modal-footer">
<!--<a id="btnAdministrarFotos" href="#" class="btn btn-primary me-auto">Administrar fotos</a>--!>
        <button type="button" class="btn btn-dorado" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
  .imagen-principal-container {
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .imagenes-secundarias {
    max-height: 300px;
    overflow-y: auto;
  }
  
  .imagen-miniatura {
    width: 100%;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 4px;
    transition: all 0.2s;
  }
  
  .imagen-miniatura:hover, .imagen-miniatura.active {
    border-color: var(--color-primary);
  }
  
  .btn-dorado {
    background-color: #8c7342;
    color: white;
    border: none;
  }
  
  .btn-dorado:hover {
    background-color: #705a34;
    color: white;
  }
</style> 

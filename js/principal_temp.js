		function load(page){
			var q = $("#q").val();

			// Mostrar el indicador de carga
			$("#loadingOverlay").addClass("active");
			$("#loader").fadeIn('slow');
			$(".outer_div").css('opacity', '0.5');
			
			// Actualizar la URL pero sin recargar la página para mantener el estado
			var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
			var queryParams = [];
			
			// Agregar el parámetro page a la URL
			if (page && page != 1) {
				queryParams.push("page=" + page);
			}
			
			// Agregar el parámetro de búsqueda si existe
			if (q && q.trim() !== '') {
				queryParams.push("q=" + encodeURIComponent(q));
			}
			
			// Construir la URL con los parámetros
			if (queryParams.length > 0) {
				newUrl += "?" + queryParams.join("&");
			}
			
			// Actualizar la URL sin recargar la página usando History API
			if (window.history && history.pushState) {
				history.pushState({page: page, q: q}, document.title, newUrl);
			}
			
			$.ajax({
				url: './ajax/buscar_principal_nuevo_temp.php?action=ajax&page=' + page + '&q=' + q,
				beforeSend: function(objeto){
					$('#loader').html('<img src="img/ajax-loader.gif"> Cargando...');
				},
				success: function(data){
					// Ocultar el indicador de carga
					$("#loadingOverlay").removeClass("active");
					
					if(data.trim() === '') {
						console.error("La respuesta del servidor está vacía");
						$('#loader').html('No se recibieron datos del servidor. Intentando de nuevo...');
						// Intentar nuevamente después de un breve retraso
						setTimeout(function() {
							load(page);
						}, 2000);
						return;
					}
					
					$(".outer_div").html(data).fadeIn('slow');
					$(".outer_div").css('opacity', '1');
					$('#loader').html('');
					
					// Inicializar eventos de botones modales para la nueva interfaz
					inicializarEventosModal();
					
					// Inicializar eventos para los enlaces de paginación
					initializePaginationEvents();
				},
				error: function(xhr, status, error) {
					// Ocultar el indicador de carga
					$("#loadingOverlay").removeClass("active");
					
					console.error("Error en la carga: ", error);
					console.error("Status: ", status);
					console.error("Respuesta: ", xhr.responseText);
					
					$('#loader').html('Error al cargar los datos: ' + error + '. Intentando de nuevo...');
					$(".outer_div").css('opacity', '1');
					
					// Intentar nuevamente después de un breve retraso
					setTimeout(function() {
						load(page);
					}, 3000);
				},
				complete: function() {
					// Verificar si no hay contenido después de la carga
					setTimeout(function() {
						$("#loadingOverlay").removeClass("active");
						
						if ($(".outer_div").is(':empty') || $(".outer_div").html().trim() === '') {
							console.log("Contenedor vacío después de la carga, intentando recargar...");
							load(page);
						}
						$('#loader').html('');
					}, 1500);
				}
			});
		}

		// Función para inicializar los eventos de los enlaces de paginación
		function initializePaginationEvents() {
			// Interceptar los clics en los enlaces de paginación
			$('.pagination-container a.page-link').off('click').on('click', function(e) {
				e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
				
				var href = $(this).attr('href');
				if (!href) return; // Si no hay href, no hacer nada
				
				// Extraer el número de página del href
				var pageMatch = href.match(/[?&]page=(\d+)/);
				var page = pageMatch ? parseInt(pageMatch[1]) : 1;
				
				// Cargar la página correspondiente
				load(page);
				
				// Scroll hacia arriba suavemente
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			});
		}

		// Función para inicializar eventos de botones modales
		function inicializarEventosModal() {
			// Botones de mapa
			$('[id^="myBtn2_"]').each(function() {
				var id = $(this).attr('id').split('_')[1];
				$(this).off('click').on('click', function() {
					$("#myModal_Emergente2_" + id).css('display', 'block');
				});
			});

			// Cerrar modal de mapa
			$('[class^="close_Emergente2_"]').each(function() {
				var id = $(this).attr('class').split('_')[2];
				$(this).off('click').on('click', function() {
					$("#myModal_Emergente2_" + id).css('display', 'none');
				});
			});

			// Cerrar modal al hacer clic fuera del contenido
			$('[id^="myModal_Emergente2_"]').each(function() {
				var id = $(this).attr('id').split('_')[2];
				$(this).off('click').on('click', function(event) {
					if (event.target == this) {
						$(this).css('display', 'none');
					}
				});
			});
		}

		// Inicializar carga al cargar la página
		$(document).ready(function(){
			// Obtener el parámetro 'page' de la URL actual
			const urlParams = new URLSearchParams(window.location.search);
			let currentPage = parseInt(urlParams.get('page')) || 1; // Usar página de URL o 1 por defecto

			// Asegurarse de que la conexión a la base de datos está disponible
			load(currentPage); // <<<--- Usar la página actual de la URL
			
			// Si después de 5 segundos sigue cargando, intentar recargar automáticamente
			setTimeout(function() {
				if ($(".outer_div").is(':empty') || $(".outer_div").html().trim() === '') {
					console.log("Contenedor sigue vacío, recargando automáticamente...");
					// Intentar recargar la misma página que se intentó cargar originalmente
					load(currentPage); // <<<--- Usar la página actual de la URL
				}
			}, 5000);
			
			// Interceptar el evento de envío del formulario de búsqueda
			$("#datos_cotizacion").on("submit", function(e) {
				e.preventDefault();
				load(1); // <<<--- La búsqueda sí debe ir a la página 1
			});
		});

		function eliminar (id)
		{
		var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el Registro de la Valla ?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_principal_temp.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		
	
$( "#guardar_trabajo" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_trabajo.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_categoria" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_categoria.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	
	$('#myModal2').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var nombre = button.data('nombre') 
	  var descripcion = button.data('descripcion') 
	  var id = button.data('id') 
	  var modal = $(this)
	  modal.find('.modal-body #mod_nombre').val(nombre)
	  modal.find('.modal-body #mod_descripcion').val(descripcion) 
	  modal.find('.modal-body #mod_id').val(id)
	})
		

// Función para generar recibo de inspección
function generar_recibo(id) {
    // Mostrar el indicador de carga
    $("#loadingOverlay").show();
    
    // Realizar petición AJAX para generar el recibo
    $.ajax({
        url: 'ajax/generar_recibo.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            // Ocultar el indicador de carga
            $("#loadingOverlay").hide();
            
            try {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    // Mostrar mensaje de éxito
                    $("#resultados").html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>¡Éxito!</strong> ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    
                    // Si hay un PDF para descargar
                    if (data.pdf_url) {
                        window.open(data.pdf_url, '_blank');
                    }
                    
                    // Recargar la tabla después de un breve retraso
                    setTimeout(function() {
                        load(1);
                    }, 1500);
                } else {
                    // Mostrar mensaje de error
                    $("#resultados").html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            } catch (e) {
                // Mostrar el mensaje tal cual en caso de que la respuesta no sea JSON
                $("#resultados").html(`
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        ${response}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        },
        error: function(xhr, status, error) {
            // Ocultar el indicador de carga y mostrar error
            $("#loadingOverlay").hide();
            $("#resultados").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error en la petición!</strong> No se pudo procesar la solicitud.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            console.error("Error: " + error);
        }
    });
}

// Manejo del modal de coordenadas
$(document).ready(function() {
    // Cuando se abre el modal de coordenadas
    $('#obtenerCoordenadas').click(function() {
        // Mostrar mensaje de carga en el contenedor de info
        $('#coordenadas_info').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Obteniendo ubicación...</span></div> Obteniendo ubicación...');
        
        // Verificar si el navegador soporta geolocalización
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                
                // Mostrar las coordenadas en el campo de texto
                $('#mapa_data2').val(lat + ',' + lng);
                
                // Actualizar el mensaje informativo
                $('#coordenadas_info').html('Coordenadas obtenidas correctamente: ' + lat + ',' + lng);
                
                // Si existe un mapa, actualizarlo
                if (typeof map !== 'undefined') {
                    var nuevaPos = {lat: lat, lng: lng};
                    map.setCenter(nuevaPos);
                    marker.setPosition(nuevaPos);
                } else {
                    // Inicializar el mapa
                    inicializarMapa(lat, lng);
                }
            }, function(error) {
                // Manejar errores de geolocalización
                var mensaje = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        mensaje = "El usuario denegó la solicitud de geolocalización.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        mensaje = "La información de ubicación no está disponible.";
                        break;
                    case error.TIMEOUT:
                        mensaje = "Se agotó el tiempo para obtener la ubicación.";
                        break;
                    case error.UNKNOWN_ERROR:
                        mensaje = "Ocurrió un error desconocido.";
                        break;
                }
                $('#coordenadas_info').html('<div class="alert alert-danger">Error: ' + mensaje + '</div>');
            });
        } else {
            // El navegador no soporta geolocalización
            $('#coordenadas_info').html('<div class="alert alert-warning">Su navegador no soporta geolocalización.</div>');
        }
    });
    
    // Guardar las coordenadas
    $('#guardar_coordenadas').click(function() {
        var id = $('#mod_id').val();
        var coordenadas = $('#mapa_data2').val();
        
        if (coordenadas.trim() === '') {
            $('#coordenadas_info').html('<div class="alert alert-warning">Por favor ingrese las coordenadas.</div>');
            return;
        }
        
        // Mostrar el indicador de carga
        $("#loadingOverlay").show();
        
        $.ajax({
            url: 'ajax/guardar_coordenadas.php',
            type: 'POST',
            data: {
                id: id,
                coordenadas: coordenadas
            },
            success: function(data) {
                // Ocultar el indicador de carga
                $("#loadingOverlay").hide();
                
                // Cerrar el modal
                $('#coordenadasModal').modal('hide');
                
                // Mostrar mensaje de éxito
                $("#resultados").html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${data}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                
                // Recargar la tabla después de un breve retraso
                setTimeout(function() {
                    load(1);
                }, 1500);
            },
            error: function(xhr, status, error) {
                // Ocultar el indicador de carga
                $("#loadingOverlay").hide();
                
                // Mostrar mensaje de error
                $('#coordenadas_info').html('<div class="alert alert-danger">Error al guardar las coordenadas: ' + error + '</div>');
            }
        });
    });
});

// Función para inicializar el mapa
function inicializarMapa(lat, lng) {
    // Esta función se usa cuando se cargan las APIs de Google Maps
    // Si no se usa Google Maps, se puede implementar con otro proveedor como Leaflet
    if (typeof google !== 'undefined') {
        var ubicacion = {lat: parseFloat(lat), lng: parseFloat(lng)};
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: ubicacion
        });
        
        marker = new google.maps.Marker({
            position: ubicacion,
            map: map,
            draggable: true
        });
        
        // Actualizar las coordenadas cuando se arrastra el marcador
        google.maps.event.addListener(marker, 'dragend', function() {
            var pos = marker.getPosition();
            $('#mapa_data2').val(pos.lat() + ',' + pos.lng());
            $('#coordenadas_info').html('Coordenadas actualizadas: ' + pos.lat() + ',' + pos.lng());
        });
    } else {
        // Alternativa si no se tiene acceso a Google Maps
        $('#map').html('<div class="alert alert-info">El mapa no está disponible. Las coordenadas se guardarán en formato texto.</div>');
    }
}


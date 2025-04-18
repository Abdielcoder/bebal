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
				url:'./ajax/buscar_tramites.php?action=ajax&page='+page+'&q='+q,
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
                        // Asegurarse de que la conexión a la base de datos está disponible
                        load(1);

                        // Si después de 5 segundos sigue cargando, intentar recargar automáticamente
                        setTimeout(function() {
                                if ($(".outer_div").is(':empty') || $(".outer_div").html().trim() === '') {
                                        console.log("Contenedor sigue vacío, recargando automáticamente...");
                                        load(1);
                                }
                        }, 5000);

                        // Interceptar el evento de envío del formulario de búsqueda
                        $("#datos_cotizacion").on("submit", function(e) {
                                e.preventDefault();
                                load(1);
                        });
                });






//		$(document).ready(function(){
//			load(1);
//		});
//
//		function load(page){
//			var q= $("#q").val();
//			$("#loader").fadeIn('slow');
//			$.ajax({
//				url:'./ajax/buscar_tramites.php?action=ajax&page='+page+'&q='+q,
//				 beforeSend: function(objeto){
//				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
//			  },
//				success:function(data){
//					$(".outer_div").html(data).fadeIn('slow');
//					$('#loader').html('');
//					
//				}
//			})
//		}

	
		
	function eliminar (id)
		{
		var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el Tramite ?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_tramites.php",
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
		
		
	
